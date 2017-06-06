<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AuthorizedPersonController extends Controller
{
    //
    public function ClientNotVerified (Request $request) {
        if ($request->user()->verified === 1 || count($request->user()->social)) {
            return redirect('/');
        }
        return view('client/not_verified');
    }
    public function WorkerNotVerified (Request $request) {
        if ($request->user()->verified === 1 || count($request->user()->social)) {
            return redirect('/');
        }
        return view('worker/not_verified');
    }

    public function SelectRole (Request $request) {
        return view('selectRole');
    }

    public function SaveRole (Request $request) {
        $user = User::find($request->user()->id);
        $user->role = $request->get('role');
        $user->save();

        return $user;
    }

}

?>
