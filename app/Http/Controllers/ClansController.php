<?php

namespace App\Http\Controllers;

use App\Clan;
use Illuminate\Http\Request;

use App\Http\Requests;

class ClansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clans = Clan::all();
        return view('clans.index', compact('clans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            "label"=>"required|min:3",
            "code"=>"required|unique:clans,code",
        ];
        $this->validate($request, $rules);

        Clan::create($request->all());
        return redirect()->route('admin.clans.index')->withMessage("Successfully create a clan.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $clan = Clan::findOrFail($id);
        return view('clans.edit', compact("clan"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
          "label"=>"required|min:3",
          "code"=>"required|unique:clans,code,".$id,
        ];
        $this->validate($request, $rules);

        $clan = Clan::findOrFail($id);
        $clan->update($request->all());
        return redirect()->route('admin.clans.index')->withMessage("Successfully update the clan.");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Clan $clan
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $clan = Clan::findOrFail($id);
        
        $clan->delete();

        return redirect()->route("admin.clans.index")->withMessage("Successfully Deleted");
    }
}