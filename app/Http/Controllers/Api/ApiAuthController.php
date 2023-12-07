<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{

    //function to get all users
    public function index()
    {
        $users = User::get() ;
        return response()->json($users);
    }
    //function to edit admin role
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

        $success = ('Role Has Been Changed');
        return response()->json($success);
    }
    //function to handle Register operation
    public function handleRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'password' => 'required|string|max:100|min:5',

        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors);
        }

       $user = User::create([
            'name' => $request->name  ,
            'email'=> $request->email ,
            'password'=> Hash::make($request->password),
            'token' => Str::random(64),
        ]);


        return response()->json($user->token);
    }
    //function to handle Login operation
    public function handleLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:100',
            'password' => 'required|string|max:100|min:5',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors);
        }
        $is_login = Auth::attempt(['email' => $request->email, 'password' => $request->password]) ;
        if(!$is_login)
        {
            $error = 'the credintials is not correct';
            return response()->json($error);
        }
        $user = User::where('email',$request->email)->first();
        $new_token = Str::random(64);
        $user->update([
            'token' => $new_token
        ]);
        return response()->json($new_token);
    }
    //function to handle logout operation
    public function logout(Request $request)
    {
        $user = User::where('token',$request->token)->first();

         if($user == null){
            $error = 'token not correct';
            return response()->json($error);
         }
        $user->update([
            'token'=> NULL
        ]);
        $success = 'Logged out successfully';
        return response()->json($success);
    }
}