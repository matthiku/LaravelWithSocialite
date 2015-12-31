<?php 

namespace App\Http\Controllers\Auth;

/**
  * AuthenticateUser.php 
  *
  * part 2 of 3 of Socialite implementation -
  * see http://www.codeanchor.net/blog/complete-laravel-socialite-tutorial/
  */


use Illuminate\Contracts\Auth\Guard; 
use Laravel\Socialite\Contracts\Factory as Socialite; 
use App\Http\Controllers\Auth\UserRepository; 
use Illuminate\Http\Request;
//use Request; 


class AuthenticateUser {     

     private $socialite;
     private $auth;
     private $users;

     public function __construct(Socialite $socialite, Guard $auth, UserRepository $users) {   
        $this->socialite = $socialite;
        $this->users = $users;
        $this->auth = $auth;
    }


    /**
     * Check if we received an OAuth token from a social media provider by looking at the $request variable
     *
     * If empty, defer to getAuthorizationFirst method which will make a call to my given provider so that the user logs in
     */
    public function execute($request, $listener, $provider) {
        // wrong url, provider was omitted
       if (!$provider) 
          return redirect('/auth/login')->withErrors(['error' => 'Wrong URL!']);

       // on the first instance, the request is empty so we get the authorization first
       if (!$request) 
          return $this->getAuthorizationFirst($provider);

        if ( ! isset($request['code']) && ! isset($request['oauth_token']) )
        {
          return redirect()->route('home')->withErrors(['error' => 'Authorization via '.$provider.' failed']);
        }

        if ( isset($request->error) )
        {
          return redirect()->route('home')->withErrors(['error' => 'Authorization via '.$provider.' failed with error!']);
        }

       // create the user object from the existing or new user
       $user = $this->users->findByUserNameOrCreate( $this->getSocialUser($provider), $provider );

       // Login the user into this app
       $this->auth->login($user, true);

       // return a view with the success message
       return $listener->userHasLoggedIn($user);
    }


    /**
     * Authorize the user with the given provider
     */
    private function getAuthorizationFirst($provider) { 
        // make sure we have a proper authorization
        $socialiteDriver = $this->socialite->driver($provider);
        //dd($socialiteDriver);
        if ($socialiteDriver) 
            return $socialiteDriver->redirect();
        // no proper authorization received!
        $msg = 'Unable to authorize with ' . $provider;
        return redirect('/auth/login')->withErrors(['error' => $msg]);
    }

    private function getSocialUser($provider) {
        return $this->socialite->driver($provider)->user();
    }

}