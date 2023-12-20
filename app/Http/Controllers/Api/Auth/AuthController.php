<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Traits\AuthorizeCheck;

class AuthController extends Controller
{
    use AuthorizeCheck;
    //function to get all users
    public function index()
    {
        $this->authorizCheck('view-users');
        $users = User::get() ;
        return response()->json($users);
    }//End Method

 //Function To Update users role
    public function update(Request $request, $id)
    {
        $this->authorizCheck('edit-users');
        $user = User::findOrFail($id);
        $user->update([
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'role' =>$request->role,
        ]);
        $user->assignRole($request->role);
        $success = ('Role Has Been Changed');
        return response()->json($success);
    }//End Method


    //function to handle Register operation
    public function handleRegister(Request $request)
    {

            $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email|max:100',
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
        ]);


        return response()->json([
            'status' => true,
            'message' => 'user created successfully',
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ],200);

    }//End Method

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
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password]) )

        {
            $error = 'the credintials is not correct';
            return response()->json($error);
        }
        $user = User::where('email',$request->email)->first();
        return response()->json([
            'status' => true,
            'message' => 'user Logged in successfully',
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ],200);
    }//End Method

    //function to handle logout operation
    public function logout(Request $request)
    {
        $user = $request->user();

        $user->tokens()->delete();

        return response()->json([
        'status' => true,
        'message' => 'Logged out successfully'
        ]);
    }//End Method
}