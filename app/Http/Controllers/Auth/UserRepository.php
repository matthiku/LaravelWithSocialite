<?php

namespace App\Http\Controllers\Auth;

/**
  * UserRepository.php 
  *
  * part 3 of 3 of Socialite implementation -
  * see http://www.codeanchor.net/blog/complete-laravel-socialite-tutorial/
  */

use App\User;

class UserRepository {
    public function findByUserNameOrCreate($userData, $provider) {
        $user = User::where('provider_id', '=', $userData->id)->first();
        if ($provider==='twitter') {
            // twitter does not return an email address, so we fake one
            $userData->email = $userData->nickname.'@twitter.com';
        }
        if(!$user) {
            //if ()
            $user = User::create([
                'provider_id' => $userData->id,
                'provider'    => $provider,
                'name'        => $userData->name,
                'username'    => $userData->nickname,
                'email'       => $userData->email,
                'avatar'      => $userData->avatar,
                'active'      => 1,
            ]);
        }

        $this->checkIfUserNeedsUpdating( $userData, $user, $provider );
        return $user;
    }

    public function checkIfUserNeedsUpdating($userData, $user, $provider) {

        $socialData = [
            'avatar'   => $userData->avatar,
            'email'    => $userData->email,
            'name'     => $userData->name,
            'username' => $userData->nickname,
            'provider' => $provider,
        ];
        $dbData = [
            'avatar'   => $user->avatar,
            'email'    => $user->email,
            'name'     => $user->name,
            'username' => $user->username,
            'provider' => $user->provider,
        ];

        if ( !empty(array_diff($socialData, $dbData)) ) {
            $user->avatar   = $userData->avatar;
            $user->email    = $userData->email;
            $user->name     = $userData->name;
            $user->username = $userData->nickname;
            $user->provider = $provider;
            $user->save();
        }
    }
}