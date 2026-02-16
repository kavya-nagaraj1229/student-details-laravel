<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username'=>'required',
            'password'=>'required'
        ]);

        $user = DB::table('users')->where('username', $request->username)->first();

        if($user && Hash::check($request->password, $user->password)) {
            session(['user_id' => $user->id]);
            return redirect('/students');
        } else {
            return back()->with('error', 'Invalid username or password');
        }
    }

    public function logout()
    {
        session()->forget('user_id');
        return redirect('/login');
    }
}