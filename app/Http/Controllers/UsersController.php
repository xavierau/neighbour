<?php

namespace App\Http\Controllers;

use App\Clan;
use App\Enums\UserStatus;
use App\Events\UserApprovedEvent;
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
        $this->authorize('updateProfile', $user);
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
        $users = User::where('first_name', 'like', "%$needle%")->orWhere('last_name', 'like', "%$needle%")->get();
        return response()->json(compact('users'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('show', new User());
        $users = User::orderBy('first_name')->paginate(15);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', new User());

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
        $this->authorize('create', new User());

        $rules = [
            "first_name"=>"required",
            "last_name"=>"required",
            "email"=>"required|email|unique:users",
            "clan_id"=>"required|in:".implode(",",Clan::lists("id")->toArray()),
            "role_id"=>"required|in:".implode(",",Role::lists("id")->toArray()),
        ];
        $this->validate($request, $rules);

        $user = User::create($request->all());
        $user->roles()->sync([$request->get("role_id")]);

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
        $this->authorize('edit', new User());
        $user = User::findOrFail($id);
        $clans = Clan::all();
        $roles = Role::all();
        return view('users.edit', compact("user", "clans", "roles"));
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
        $this->authorize('edit', new User());

        $rules = [
            "first_name"=>"required",
            "last_name"=>"required",
            "email"=>"required|email|unique:users,email,".$id,
            "clan_id"=>"required|in:".implode(",",Clan::lists("id")->toArray()),
            "role_id"=>"required|in:".implode(",",Role::lists("id")->toArray()),
        ];
        $this->validate($request, $rules);

        $user = User::findOrFail($id);
        $user->update($request->all());
        $user->roles()->sync([$request->get("role_id")]);


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
        $this->authorize('delete', new User());

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

        Auth::login($user);

        return redirect("/");
    }

    public function getPendingUsers(Request $request)
    {
        $this->authorize('get', [User::class, UserStatus::PENDING]);


        $user = $request->user();
        if($user->is('dev') or $user->is("sadmin")){
            return response()->json(['PendingUsers'=>User::getPendingUsers()]);
        }
        return response()->json(['PendingUsers'=>User::getPendingUsers($user->clan_id)]);
    }

    public function approveUser(Request $request, $userId)
    {
        // Select that particular user whose status is pending or suspend. Otherwise not approval need
        $pendingStatusId = \App\UserStatus::whereCode(UserStatus::PENDING)->first()->id;
        $suspendStatusId = \App\UserStatus::whereCode(UserStatus::SUSPEND)->first()->id;
        $user = User::whereId($userId)->whereUserStatusId($pendingStatusId)->orWhere('user_status_id', $suspendStatusId)->first();

        $this->authorize('approve', $user);

        $newStatus = \App\UserStatus::whereCode("new")->first();

        if ($user){
            $user->email_confirmation_token = str_random(128);
            $user->status()->associate($newStatus);
            $user->save();
            event(new UserApprovedEvent($user));
            return response()->json(['Status'=>"approved"]);
        }
        return response()->json(['Status'=>"NA"]);
    }
}
