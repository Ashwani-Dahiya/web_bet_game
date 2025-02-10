<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function login_page()
    {
        if (Auth::check()) {
            return redirect()->route('home.page');
        }
        return view('auth.login');
    }
    public function register_page()
    {
        return view('auth.register');
    }
    public function check_login(Request $request)
    {

        $this->validate($request, [
            'mobile' => 'required|min:10|max:10',
            'password' => 'required|string',
        ]);
        if (Auth::attempt($request->only('mobile', 'password'))) {
            return redirect()->route('home.page')->with('success', 'Successfully Logged In');
        }

        return redirect()->back()->with('error-db', 'Invalid Credentials');
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('home.page')->with('success-logout', 'Logout Successfully');
    }

    public function register_post(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'name' => 'required|string|min:2|max:50',
            'mobile' => 'required|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|same:password',
        ]);
        $base_64_pass=base64_encode($request->password);
        User::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
            'in_hash' => $base_64_pass,
        ]);
        if (Auth::attempt($request->only('mobile', 'password'))) {
            return redirect()->route('home.page')->with('success', 'Successfully Logged In');
        }
        return redirect('autn.register')->withError('error');
    }


}
