<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LikesController extends Controller
{
    public function like(Request $request, $object, $objectId)
    {
        $object = "App\\" . $object;
        $model = App::make($object);
        $likeableItem = $model->find($objectId);
        if ($likeableItem != null and method_exists($likeableItem, 'likes')) {

            $like = $likeableItem->likes()->create([]);
            $like->user_id = $request->user()->id;
            $like->save();

            return response()->json(compact('like'));

        }

        return 'error';
    }

    public function unlike(Request $request, $object, $likeId)
    {
        $object = "App\\" . $object;
        $model = App::make($object);

        if (method_exists($model, 'likes')) {

            $like = Like::find($likeId);
            if ($like) {
                if ($like->user_id == $request->user()->id and $like->likeable_type == $object) {
                    $like->delete();

                    return response()->json('deleted');
                }

                return response()->json('unauthorized');

            }

            return response()->json('no like found');

        }

        return 'error';
    }
}
