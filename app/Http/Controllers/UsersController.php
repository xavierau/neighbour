<?php

namespace App\Http\Controllers;

use App\Services\MediaServices;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function getProfile()
    {
        return Auth::user();
    }

    public function updateProfile(Request $request)
    {

        $inputs = $request->all();
        $user = User::findOrFail($inputs['id']);
        $user->name = $inputs['name'];
        $user->email = $inputs['email'];
        if($request->hasFile('file')){
            $service = new MediaServices();
            $user->avatar = $service->storeProfilePic($request->file("file"));
        }
        if($request->has('password')){
            $user->password = bcrypt($inputs['password']);
        }
        $user->save();
        return response()->json(compact('user'));
    }

    public function searchByUserName(Request $request)
    {
        $needle = $request->get('name');
        $users = User::where('name', 'like', "%$needle%")->get();
        return response()->json(compact('users'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
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

        User::create($request->all());
        return redirect()->route('admin.users.index')->withMessage("Successfully create a user.");
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
        $user = User::findOrFail($id);
        return view('users.edit', compact("user"));
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

        $user = User::findOrFail($id);
        $user->update($request->all());
        return redirect()->route('admin.users.index')->withMessage("Successfully update the clan.");

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
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route("admin.users.index")->withMessage("Successfully Deleted");
    }
}
