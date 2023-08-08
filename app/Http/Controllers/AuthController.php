<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showRegisterPage() {
        return view('pages.auth.register');
    }

    public function showLoginPage() {
        return view('pages.auth.login');
    }

    public function register(Request $reguest) {

        if(Auth::check()) {
            return redirect('/login')->withErrors('You are already logged in!');
        }
        $reguest->validate([
            'name' => 'required|min:2|max:32',
            'email' => 'required|unique:users,email',
            'password' => 'required|string|min:5|max:255|confirmed'
        ]);

        $newUser = User::create([
                'name' => $reguest->name,
                'email' => $reguest->email,
                'password' => Hash::make($reguest->password)
            ]);

        Auth::login($newUser);

        return redirect('/')->with('status', 'Sucessfully logged in');
    }

    public function login(Request $reguest) {
        if(Auth::check()) {
            return redirect('/login')->withErrors('You are already logged in!');
        }

        $reguest->validate([
            'email' => 'required|exists:users,email',
            'password' => 'required'
        ]);


        $credentials = $reguest->only('email', 'password');
        if(Auth::attempt($credentials)) {
            return redirect('/')->with('status', 'Sucessfully logged in');
        }

        return redirect('/login')->withErrors('Invalid Credentials');

    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect('/login')->with('status', 'You are logged out');
    }
}
