<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\MatchOldPassword;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission;

class AuthenticateController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function make_login(Request $request)
    {
        $request->validate([
            'UserID' => 'required',
            'Password' => 'required',
        ]);

        //dd($request->all());
        $credentials = array(
            'UserID' => $request->input('UserID'),
            'password' => $request->input('Password')
        );

        if (Auth::attempt($credentials)) {
            //dd(Auth()->user()->getPermissionNames());
            Toastr::success('Login successful', 'GoodJob!', ["positionClass" => "toast-top-right"]);
            //return redirect()->intended('dashboard');
            return redirect()->route('dashboard');
        }
        Toastr::error('Login Failed', 'Opps!', ["positionClass" => "toast-top-right"]);
        return redirect()->route('authenticate.login');
    }



    public function register()
    {
        return view('auth.register');
    }


    public function make_register(Request $request)
    {
        $request->validate([
            'UserID' => 'required|unique:UserManager,UserID',
            'UserName' => 'required',
            'Email' => 'required|email',
            'Password' => 'required|min:4',
        ]);

        $data = $request->all();
        $check = $this->create($data);

        //$permission = Permission::create(['name' => 'Sample1']);
        //$check->givePermissionTo('Sample1');

        if ($check == true) {
            Toastr::success('Registration successful', 'GoodJob!', ["positionClass" => "toast-top-right"]);
        } else {
            Toastr::error('Registration Failed', 'Opps!', ["positionClass" => "toast-top-right"]);
        }

        return redirect()->route('authenticate.login');
    }


    public function create(array $data)
    {
        return User::create([
            'UserID' => $data['UserID'],
            'UserName' => $data['UserName'],
            'Designation' => $data['Designation'],
            'Email' => $data['Email'],
            'Active' => 'Y',
            'Password' => Hash::make($data['Password'])
        ]);
    }


    public function dashboard()
    {
        if (Auth::check()) {
            return view('home');
        }
        return redirect()->route('authenticate.login');
    }


    public function logout()
    {
        Session::flush();
        Auth::logout();

        return Redirect()->route('authenticate.login');
    }

    public function pass_change()
    {
        return view('layouts.change_password');
    }

    public function pass_change_submit(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['Password' => Hash::make($request->new_password)]);

        Toastr::success('Password Change Successfully', 'GoodJob!', ["positionClass" => "toast-top-right"]);
        return redirect()->route('dashboard');
    }
}
