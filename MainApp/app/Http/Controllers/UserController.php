<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Auth;

class UserController extends Controller
{
    public function viewLogin()
    {
    	return view('user.login');
    }

    public function login_action(Request $request)
    {
    	if(Auth::attempt(['email' => $request->input('email'),'password' => $request->input('password')]))
    	{
    		return redirect()->route('home');
    	}
    	else
    	{
    		return redirect()->back();
    	}
    }

    public function logout(Request $request)
    {
    	if(Auth::check())
    	{
    		Auth::logout();
    		$request->session()->flush();
    		return redirect()->route('login');
    	}
    	else
    	{
    		return redirect()->route('login');
    	}
    }
}
