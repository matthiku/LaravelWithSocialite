<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Socialite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\AuthenticateUser;

class AuthController extends Controller
{


    // defines the route after a successful login
    protected $redirectTo = '/tasks';



    /*
    |--------------------------------------------------------------------------
    | Socialite Implementation 
    | part 1 of 3
    | see http://www.codeanchor.net/blog/complete-laravel-socialite-tutorial/
    |--------------------------------------------------------------------------
    |
    */
    public function loginViaProvider(AuthenticateUser $authenticateUser, Request $request, $provider = null) 
    {
        return $authenticateUser->execute( $request->all(), $this, $provider );
    }
    // redirect to dashboard after a succesful login
    public function userHasLoggedIn($user) {
        \Session::flash( 'status', 'Welcome, '.$user->name.'! You have been logged in via '.$user->provider );
        return redirect('/tasks');
    }

    /**
     * Redirect the user to the Provider's authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('github')->user();

        // $user->token;
    }




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
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
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
            'password' => 'required|confirmed|min:6',
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
}
