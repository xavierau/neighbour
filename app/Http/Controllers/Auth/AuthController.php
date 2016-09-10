<?php

namespace App\Http\Controllers\Auth;

use App\City;
use App\Clan;
use App\FacebookUser;
use App\Role;
use App\Services\FbServices;
use App\User;
use App\UserStatus;
use App\UserType;
use Facebook\FacebookRequest;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
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
    protected $redirectTo = '/';


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
        $pattern = "/((?:[0-9]{1,})(?:[a-zA-Z]{1,}))|((?:[a-zA-Z]{1,})(?:[0-9]{1,}))/";

        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => ["required", "min:5", "confirmed", "regex:".$pattern],
            'clan_id' => 'required|in:'.implode(",", Clan::lists('id')->toArray()),
            'city_id' => 'required|in:'.implode(",", City::lists('id')->toArray()),
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
        $role = Role::whereCode("gen")->first();
        $userStatus = UserStatus::whereCode('pending')->first();
        $userType = UserType::whereType('app')->first();

        $user = $userStatus->users()->create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'city_id' => $data['city_id'],
            'clan_id' => $data['clan_id'],
            'user_type_id' => $userType->id,
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'status' =>'pending',
        ]);

        $user->roles()->save($role);

        return $user;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $this->create($request->all());
        $buildingName = Clan::find($request->get("clan_id"))->label;

        return redirect($this->redirectPath())->withRegistration($buildingName);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);
        $activeStatusId = UserStatus::whereCode('active')->first()->id;
        $credentials['user_status_id'] = $activeStatusId;

        if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {

            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles && ! $lockedOut) {
            $this->incrementLoginAttempts($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function facebookSignUp()
    {
        return Socialite::driver('facebook')->scopes([
            'user_managed_groups', 'email','user_status','user_relationships','user_friends'
        ])->redirect();
    }

    public function facebookLogin()
    {
        return Socialite::driver('facebook')->scopes([
            'user_managed_groups', 'email','user_status','user_relationships','user_friends'
        ])->redirect();
    }

    public function handleFacebookSignUpCallback()
    {
        $fbUser = Socialite::driver('facebook')->user();

        $service  = new FbServices($fbUser);

        $user = $service->fetchOrCreateAppUserFromFacebookUserGraph();


        $service->fetchFeedFromGroup();

        Auth::login($user);

        return redirect('/app');
    }

    public function twitterSignUp()
    {
        return Socialite::driver('twitter')->redirect();
    }

    public function handleTwitterSignUpCallback()
    {
        try {
            $user = Socialite::driver('twitter')->user();
        } catch (Exception $e) {
            dd($e);
            return redirect('auth/twitter');
        }

        $authUser = $this->findOrCreateUser($user);

        Auth::login($authUser, true);

        return redirect()->route('home');
    }

    private function findOrCreateUser($twitterUser)
    {
        $userTypeConst = "TWITTER";
        $authUser = User::where('twitter_id', $twitterUser->id)->first();
        if ($authUser){
            return $authUser;
        }
        $type = constant("\App\Enums\UserType::".$userTypeConst);
        $userType = UserType::whereType($type)->first();

        $data = [
            'name' => $twitterUser->name,
            'handle' => $twitterUser->nickname,
            'twitter_id' => $twitterUser->id,
            'avatar' => $twitterUser->avatar_original
        ];

        $userType->users()->create($data);

        return User::create([
            'name' => $twitterUser->name,
            'handle' => $twitterUser->nickname,
            'twitter_id' => $twitterUser->id,
            'avatar' => $twitterUser->avatar_original
        ]);
    }

    /**
     * Create the response for when a request fails validation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $errors
     * @return \Illuminate\Http\Response
     */
    protected function buildFailedValidationResponse(Request $request, array $errors)
    {
        if (($request->ajax() && ! $request->pjax()) || $request->wantsJson()) {
            return new JsonResponse($errors, 422);
        }

        return redirect()->to($this->getRedirectUrl())
            ->withInput($request->input())
            ->withFrom($request->path())
            ->withErrors($errors, $this->errorBag());
    }

    /**
     * Get the failed login response instance.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->back()
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withFrom($request->path())
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }

    protected function authenticated(Request $request, User $authUser) {

        if($authUser->is('sadmin'))
            return redirect('/admin/dashboard');

        return redirect()->intended($this->redirectPath());

    }

}
