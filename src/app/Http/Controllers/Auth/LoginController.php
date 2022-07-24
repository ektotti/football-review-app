<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\IdentityProvider;
use App\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider($provider) {
        return socialite::driver($provider)->redirect();
    }

    public function callbackFromProvider($provider) {
        try{
            $userFromProvider = Socialite::driver($provider)->stateless()->user();
        } catch(Exeption $e){
            return redirect('/login')->with("{$provider}のアカウントが見つかりませんでした");
        }

        $user = $this->findOrCreateUser($userFromProvider, $provider);
        if($user) {
            Auth::login($user, true);
            return redirect('/');
        } else {
            return redirect('/login');
        }
        
    }

    private function findOrCreateUser($userFromProvider, $provider){
        $account = IdentityProvider::where('provider_id', $userFromProvider->getId())->first();
        if($account){
            return User::where('id', $account->user_id)->first();
        } else {
            $account = User::where('email', $userFromProvider->getEmail())->first();
            if($account) {
                return $account;
            }
        }
        
        $user = new User;
        $user->name = $userFromProvider->getName();
        $user->email = $userFromProvider->getEmail();
        $user->icon_image = env('ICON_IMAGE_DEFAULT');
        $user->save();

        $savedUser = User::where('email', $userFromProvider->getEmail())->first();
        $userWithProvider = new IdentityProvider;
        $userWithProvider->user_id = $savedUser->id;
        $userWithProvider->provider_name = $provider;
        $userWithProvider->provider_id = $userFromProvider->getId();
        $userWithProvider->save();

        return $savedUser;
    }

}
