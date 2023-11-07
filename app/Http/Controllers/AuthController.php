<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;



class AuthController extends Controller
{
    public function register ()
    {
        return view('users.register');
    }

    public function  handleRegister(Request $request)

    {
        $request ->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'password' => 'required|string|max:100|min:5',
        ]);

       $user = User::create([
            'name' => $request->name  ,
            'email'=> $request->email ,
            'password'=> Hash::make($request->password)
        ]);
        Auth::login($user);

        return redirect(route('welcome'));
    }


    public function login ()
    {
        return view('users.login');
    }

    public function  handleLogin (Request $request)
    {
        $request ->validate([
            'email' => 'required|email|max:100',
            'password' => 'required|string|max:100|min:5',
        ]);



        $is_login = Auth::attempt(['email' => $request->email, 'password' => $request->password]) ;

        if(!$is_login)
        {
            return back() ;
        }

                return redirect(route('welcome'));
    }



    public function logout ()
    {
        Auth::logout() ;
        return redirect(route('auth.login'));
    }

    public function redirectToProvider ()
    {
        return Socialite::driver('github')->redirect();
    }
    public function handleProviderCallback ()
    {
        $githubUser = Socialite::driver('github')->user();
        $email= $githubUser->email ;

        $db_user =User::where('email','=',$email)->first();

        if($db_user==null){
            $user = User::updateOrCreate([
                'name' => $githubUser->name,
                'email' => $githubUser->email,
                'password' =>Hash::make(123456),
                'oauth_token' => $githubUser->token,

            ]);

            Auth::login($user);
        }else{
            Auth::login($db_user);
        }


        return redirect(route('welcome'));
    }




        }
