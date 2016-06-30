<?php

namespace App\Http\Controllers;

use Guzzle\Http\Client;
use Illuminate\Http\Request;

use App\Http\Requests;

class UrlsController extends Controller
{
    public function preview(Request $request)
    {
            $uri = $request->get('uri');
            $client = new Client();
            $httpRequest = new Request('GET', $uri);
            $content = "";
            $promise = $client->sendAsync($httpRequest)->then(function ($response) use ($content) {
                $stream = $response->getBody();
                while (!$stream->eof()) {
                    $content = $content . $stream->read(1024);
                }
                if (preg_match('/(?:<head[^>]*>)(.*)<\/head>/isU', $content, $matches)) {
                    $content = $matches[1];
                }

                return getWebPageMetaTags($content);
            });

            return $promise->wait();
    }
}
