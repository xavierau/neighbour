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
}
