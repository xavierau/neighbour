<?php

namespace App\Http\Controllers;

use App\Category;
use App\Event;
use App\Events\NewPostCreated;
use App\Events\Notification;
use App\Events\NotificationEvent;
use App\Feed;
use App\Http\Requests;
use App\Services\MediaServices;
use App\Stream;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as GR;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class FeedsController extends Controller
{
    public function postFeed(Request $request)
    {
        $files = array_filter($request->all(), function ($entry) {
            return $entry instanceof UploadedFile;
        });
        if ($request->ajax()) {
            $feedData = $request->all();
            $feedData["reply_to"] = 0;
            $feed = Auth::user()->feeds()->create($feedData);

            if (count($files) > 0) {
                $mediaService = new MediaServices();
                foreach ($files as $file) {
                    $link = $mediaService->storeFeedPhoto($file);
                    $data = [
                        'link' => $link,
                        'type' => 'image'
                    ];
                    $feed->media()->create([])->update($data);
                }
            }

            event(new NewPostCreated($feed));

            if ($feed->category->showInPublic) {
                $feed->load(["sender", "media"]);

                return response()->json(['status' => "okay", 'feed' => $feed]);
            }

            return response()->json(['status' => "okay"]);
        }
    }

    public function getFeed($id)
    {
        logger('feed test');
        $feed = Feed::find($id);

        return response()->json(compact("feed"));
    }

    public function getFeeds(Request $request, $feedOption)
    {
        if ($feedOption == "showPublicfrontPage" or $feedOption == 'public') {

            $stream = Stream::orderBy('created_at', "desc")->with('item')->paginate(5);
            $items = new Collection();
            foreach ($stream as $item) {
                if ($item->item instanceof Feed) {
                    $item->item = $item->item->loadStandardFetchSetting();
                }
                if ($item->item instanceof Event) {
                    $item->item = $item->item->loadStandardFetchSetting();
                }
                $items->push($item->item);
            }

            $nextPageUrl = $stream->nextPageUrl();
            $currentPage = $stream->currentPage();
            $hasMorePages = $stream->hasMorePages();
            $previousPageUrl = $stream->previousPageUrl();

            return response()->json(compact(
                'items', 'nextPageUrl', 'currentPage', 'hasMorePages', 'previousPageUrl'
            ));
        } elseif (in_array($feedOption, $categoryList = Category::lists('code', "id")->toArray())) {
            $feeds = Feed::feedCategory($feedOption)
                ->standardFetchSetting()
                ->get();
            $category_id = 0;
            foreach ($categoryList as $id => $categoryCode) {
                if ($feedOption == $categoryCode) {
                    $category_id = $id;
                }
            }

            return response()->json(compact("feeds", "category_id"));
        }
    }

    public function commentFeed(Request $request)
    {
        $feedId = $request->get('feedId');
        $comment = $request->get('comment');
        $feed = Feed::find($feedId);
        $replay = $request->user()->feeds()->create([
            "content"     => $comment,
            "reply_to"    => $feedId,
            "category_id" => $feed->category->id
        ]);
        $replay->load('sender');
        if ($feed->sender->id != $request->user()->id) {
            event(new NotificationEvent($feed, $feed->sender->id, $request->user()->id));
            event(new Notification($feed->sender));
        }

        return response()->json(['comment' => $replay]);
    }

    public function getFeedComments(Request $request)
    {
        $comments = Feed::orderBy('created_at', 'desc')
            ->where("reply_to", $request->get('feedId'))
            ->standardFetchSetting()
            ->get();

        return response()->json(compact("comments"));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $feedId
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteFeed(Request $request, $feedId)
    {
        $feed = $request->user()->feeds()->find($feedId);
        if ($feed->reply_to == 0) {
            $class = get_class($feed);
            $stream = Stream::whereItemType($class)
                ->whereItemId($feed->id)
                ->first();
            $stream->delete();
        }
        $feed->delete();

        return response()->json('completed');
    }

    public function deleteComment(Request $request, $postId, $commentId)
    {
        $feed = $request->user()->feeds()->whereReplyTo($postId)->whereId($commentId)->first();
        if ($feed) {
            $feed->delete();
        }

        return response()->json('completed');
    }

    public function urlPreview(Request $request)
    {
        $uri = $request->get('uri');
        $client = new Client();
        $httpRequest = new GR('GET', $uri);
        $content = "";
        $promise = $client->sendAsync($httpRequest)->then(function ($response) use ($content) {
            $stream = $response->getBody();
            while (!$stream->eof()) {
                $content = $content . $stream->read(1024);
            }

            if (preg_match('/(?:<head[^>]*>)(.*)<\/head>/isU', $content, $matches)) {
                $content = $matches[1];
            }

            return $this->getMetaTags($content);
        });

        return $promise->wait();
    }

    private function getMetaTags($str)
    {
        $pattern = '
          ~<\s*meta\s
        
          # using lookahead to capture type to $1
            (?=[^>]*?
            \b(?:name|property|http-equiv)\s*=\s*
            (?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|
            ([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=))
          )
        
          # capture content to $2
          [^>]*?\bcontent\s*=\s*
            (?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|
            ([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=))
          [^>]*>
        
          ~ix';

        if (preg_match_all($pattern, $str, $out)) {
            return array_combine($out[1], $out[2]);
        }

        return array();
    }

}
