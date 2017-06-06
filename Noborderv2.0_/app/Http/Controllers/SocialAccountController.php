<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Socialite;

use App\User;
use App\SocialAccount;

class SocialAccountController extends Controller
{
    //
    public function redirect ()
    {
      return Socialite::driver('facebook')->redirect();
    }

    public function callback ()
    {
      $user =$this->findOrCreateUser(Socialite::driver('facebook')->user());

      auth()->login($user);

      return redirect()->to('/selectRole');
    }

    public function findOrCreateUser ($provider)
    {
      $account = SocialAccount::where('provider_id', $provider->getId())
            ->first();

      if ($account) {
        return $account->user;
      }
      $account = new SocialAccount([
        'provider_id' => $provider->getId(),
        'provider' => 'facebook'
      ]);

      $user = User::where('email', $provider->getEmail())->first();
      if (!$user) {
        $user = new User;
        $user->name = $provider->getName();
        $user->email = $provider->getEmail();
        $user->verified = 1;
        $user->avatar = $provider->getAvatar();
        //$user->avatar = 'http://graph.facebook.com/'.$provider->getId().'/picture';
        //$user->role = 1; // 1 - client , 2 - worker , 3 - coordinator
        $user->save();

        $user->account_id = sprintf("%08d", $user->id);
        $user->save();
      }

      $account->user()->associate($user);
      $account->save();
      return $user;
    }
}
