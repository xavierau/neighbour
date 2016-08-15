<?php

namespace App\Http\Controllers;

use App\Clan;
use App\Http\Requests\ConfirmEmailRequest;
use App\Role;
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
        $user->first_name = $inputs['first_name'];
        $user->last_name = $inputs['last_name'];
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
    public function create(Request $request)
    {
        if($request->user()->cannot("createUser")) abort(403);

        $roles = Role::select('label','id')->get();
        $clans = Clan::select('label','id')->get();
        return view('users.create', compact("roles","clans"));
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

    public function confirmEmail(ConfirmEmailRequest $request)
    {
        $email = $request->get('email');
        $token = $request->get('token');
        $user = User::whereEmail($email)->first();

        if ($user->email_confirmation_token != $token){throw  new Exception("Invalid Token");}

        $activeStatus = \App\UserStatus::whereCode('active')->first();
        $user->email_confirmation_token = null;
        $user->status()->associate($activeStatus);
        $user->save();

        return redirect("/");
    }

    public function getPendingUsers(Request $request)
    {
        $user = $request->user();
        if($user && $user->can("approveUser")){
            if($user->is('dev') or $user->is("sadmin")){
                return response()->json(['PendingUsers'=>User::getPendingUsers()]);
            }
            return response()->json(['PendingUsers'=>User::getPendingUsers($user->clan_id)]);
        }
    }
}
