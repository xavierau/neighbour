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

    public function getSelectCategoryList(Request $request)
    {
        if ($request->wantsJson()) {
            $list = Category::where("canSelect", true)
                ->select("id", "name", "code")
                ->get();

            return response()->json($list);
        }
    }

    public function index()
    {
        $this->authorize('show', new Category());

        $categories = Category::all();

        return view('categories.index', compact('categories'));
    }

    public function edit($id)
    {
        $this->authorize('edit', new Category());

        $category = Category::find($id);

        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $this->authorize('edit', new Category());

        $category = Category::find($id);
        $category->update($request->all());
        
        $request->session()->flash('message', 'update successfully');

        return redirect()->route('admin.categories.index');;
    }

    public function destroy(Request $request, $id)
    {

        $this->authorize('delete', new Category());

        $category = Category::find($id);
        $category->delete();

        $request->session()->flash('message', 'category deleted');

        return redirect()->route('admin.categories.index');
    }

    public function create()
    {
        $this->authorize('create', new Category());

        return view('categories.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', new Category());

        Category::create($request->all());
        
        $request->session()->flash('message', 'new category created!');
        return redirect()->route('admin.categories.index');
    }
}
