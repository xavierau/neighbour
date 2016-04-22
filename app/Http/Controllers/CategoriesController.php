<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

use App\Http\Requests;

class CategoriesController extends Controller
{
    public function getCategoryList(Request $request)
    {
        if($request->wantsJson()){
            $list = Category::where("showInList",true)
                    ->select("id", "name", "code")
                    ->get();
            return response()->json($list);
        }
    }
}
