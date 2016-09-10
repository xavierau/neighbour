<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    protected $resetView = 'passwordReset';
    protected $redirectTo = '/';

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendResetLinkEmail(Request $request)
    {
        if($request->ajax()){
            $result = $this->checkAjaxRequest($request);
            if (!$result) return response()->json(['fail'=>'incorrect email']);
        }

        $this->validateSendResetLinkEmail($request);

        $broker = $this->getBroker();

        $response = Password::broker($broker)->sendResetLink(
            $this->getSendResetLinkEmailCredentials($request),
            $this->resetEmailBuilder()
        );

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return $this->getSendResetLinkEmailSuccessResponse($response);
            case Password::INVALID_USER:
            default:
                return $this->getSendResetLinkEmailFailureResponse($response);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    private function checkAjaxRequest(Request $request)
    {
        if ($request->has("email")) {
            $email = $request->get("email");
            return !! User::whereEmail($email)->first();
        }
        return false;
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function getResetValidationRules()
    {
        $pattern = "/((?:[0-9]{1,})(?:[a-zA-Z]{1,}))|((?:[a-zA-Z]{1,})(?:[0-9]{1,}))/";

        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ["required", "min:5", "confirmed", "regex:".$pattern],
        ];
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user->forceFill([
                             'password' => $password,
                             'remember_token' => Str::random(60),
                         ])->save();

        Auth::guard($this->getGuard())->login($user);
    }
}
