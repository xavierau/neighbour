<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function getCategoryList(Request $request)
    {
        if ($request->wantsJson()) {
            $list = Category::where("showInList", true)
                ->select("id", "name", "code")
                ->get();

            return response()->json($list);
        }
    }

    public function index()
    {
        $categories = Category::all();

        return view('categories.index', compact('categories'));
    }

    public function edit($id)
    {
        $category = Category::find($id);

        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $category->update($request->all());
        
        $request->session()->flash('message', 'update successfully');

        return redirect("/categories");
    }

    public function delete(Request $request, $id)
    {
        $category = Category::find($id);
        $category->delete();

        $request->session()->flash('message', 'category deleted');

        return redirect("/categories");
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        Category::create($request->all());
        
        $request->session()->flash('message', 'new category created!');
        return redirect("/categories");
    }
}
