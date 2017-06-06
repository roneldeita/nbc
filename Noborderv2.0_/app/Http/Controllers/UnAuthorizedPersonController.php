<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UnAuthorizedPersonController extends Controller
{
    //
    public function Index (Request $request) {
        if ($request->user()) {
            if ($request->user()->role === 1) {
                return redirect('/client');
            } else if ($request->user()->role === 2) {
                return redirect('/worker');
            } else if ($request->user()->role === 3) {
                return redirect('/coordinator');
            } else {
              return redirect('/selectRole');
            }
        }
        return view('welcome');
    }

    public function VerifyEmail ($verficationCode, $email) {
        $user = User::where('verification', $verficationCode)->where('email', $email)->first();
        if ($user) {
            $user->verified = 1;
            $user->save();
            return redirect('/');
        }
        return view('errors/404');
    }
}
