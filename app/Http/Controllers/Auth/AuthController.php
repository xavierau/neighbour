<?php

namespace App\Http\Controllers\Auth;

use App\FacebookUser;
use App\Services\FbServices;
use App\User;
use Facebook\FacebookRequest;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/app';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function facebookSignUp()
    {
        return Socialite::driver('facebook')->redirect();
    }


    public function facebookLogin()
    {
        return Socialite::driver('facebook')->redirect();
    }


    public function handleFacebookSignUpCallback()
    {
        $fbUser = Socialite::driver('facebook')->user();
        $fbService = new FbServices($fbUser->token);
        $avatar = $fbService->getAvatar($fbUser->id);
        $user = User::whereEmail($fbUser->email)->first();
        if($user){
            Auth::login($user);
        }else{

            $user = new User();
            $user->name = $fbUser->name;
            $user->email = $fbUser->email;
            $user->avatar = $avatar;
            $user->password = bcrypt(str_random(12));
            $user->save();

            $newFbUser = new FacebookUser();
            $newFbUser->id = $fbUser->id;
            $newFbUser->token = $fbUser->token;
            $newFbUser->name = $fbUser->name;
            $newFbUser->email = $fbUser->email;
            $newFbUser->avatar = $avatar;
            $newFbUser->gender = $fbUser->user["gender"];
            $newFbUser->user_id = $user->id;
            $newFbUser->save();
        }
        return redirect('/app');
    }
    
}
