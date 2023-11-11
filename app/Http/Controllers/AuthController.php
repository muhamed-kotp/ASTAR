<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;




class AuthController extends Controller
{
    public function index()
    {
        $users = User::get() ;
        return view('users.index',compact('users'));
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        if($user->Is_admin ==1)
        {
            $user->update([
                'name' => $user->name  ,
                'email'=> $user->email ,
                'password'=> $user->password,
                'Is_admin'=> 0,
                'token'=> $user->token
            ]);
        }
        else if($user->Is_admin == 0){
            $user->update([
                'name' => $user->name  ,
                'email'=> $user->email ,
                'password'=> $user->password,
                'Is_admin'=> 1,
                'token'=> $user->token

            ]);
        }

        return back();
    }
    public function register ()
    {
        return view('users.register');
    }

    public function  handleRegister(Request $request)

    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'password' => 'required|string|max:100|min:5',

        ]);

        if ($validator->stopOnFirstFailure()->fails()) {

            // dd($errors);
            return redirect()->back()  ->withErrors($validator);
            // return response()->json($errors);
        }

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
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:100',
            'password' => 'required|string|max:100|min:5',
        ]);
        if ($validator->stopOnFirstFailure()->fails()) {

            return redirect()->back()  ->withErrors($validator);
        }


        $is_login = Auth::attempt(['email' => $request->email, 'password' => $request->password]) ;

        if(!$is_login)
        {
            return redirect()->back()->with('fail',  'The Email or Password is not correct');
        }

                return redirect(route('welcome'));
    }



    public function logout ()
    {
        Auth::logout() ;
        session()->flush();
        return redirect(route('auth.login'));

    }


}
