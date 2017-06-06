<?php

namespace App\Http\Controllers\Auth;



use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeEmailValidation;


use App\SecurityQuestion;
use App\User;
use App\UserOther;

use App\Jobs\SendVerificationEmail;
use Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'question' => 'required',
            'answer' => 'required'
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
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => $data['role'],
            'verification' => str_random(30),
            'verified' => 0,
            'online' => 0
        ]);

        $user->account_id = sprintf("%08d", $user->id);
        $user->save();

        $user_other = UserOther::create([
            'user_id' => $user->id,
            'question_id' => $data['question'],
            'answer' => bcrypt($data['answer'])
        ]);
        //dispatch(new SendVerificationEmail($user));
        Mail::to($user->email)->send(new WelcomeEmailValidation($user));
        return $user;
    }
    public function showRegistrationForm()
    {
        $questions = SecurityQuestion::all();
        return view("auth.register", compact("questions"));
    }

}
