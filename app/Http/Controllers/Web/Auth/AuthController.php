<?php

namespace App\Http\Controllers\Web\Auth;


use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use App\Traits\AuthorizeCheck;
class AuthController extends Controller
{
    use AuthorizeCheck;

        //Function To Show All Users
    public function index()
    {
        $this->authorizCheck('view-users');
        $users = User::get() ;
        return view('users.index',compact('users'));
    }//End Method

    //Function To Show Users and edit them
    public function edit($id)
    {
        $this->authorizCheck('edit-users');
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('users.edit',compact('user','roles',));
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
            return redirect(route('users.index'))->with(['success'=> "The Role For $user->name Is updated Successfully"]);
        }//End Method

        //function to show Register operation
    public function register ()
    {
        return view('users.register');
    }//End Method

        //function to handle Register operation
    public function  handleRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email|max:100',
            'password' => 'required|string|max:100|min:5',

        ]);

        if ($validator->stopOnFirstFailure()->fails()) {

            // dd($errors);
            return redirect()->back()->withErrors($validator);
            // return response()->json($errors);
        }

       $user = User::create([
            'name' => $request->name  ,
            'email'=> $request->email ,
            'password'=> Hash::make($request->password)
        ]);
        Auth::login($user);

        return redirect(route('welcome'));
    }//End Method

    //function to Show Login operation
    public function login ()
    {
        return view('users.login');
    }//End Method

        //function to handle Login operation
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
    }//End Method

        //function to handle logout operation
    public function logout ()
    {
        Auth::guard('web')->logout();
        session()->flush();
        return redirect(route('auth.login'));
    }//End Method


}