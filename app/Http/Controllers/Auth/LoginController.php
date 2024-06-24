<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('employee-dashboard');
        }
        return view('user-login');
    }


    public function login(Request $request)
    {
        $currentTime = Carbon::now();

        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            Log::info('User logged in', [
                'user' => Auth::user()->username,
                'time' => $currentTime
            ]);
            return redirect()->route('employee-dashboard')->with('no-back', true);
        }

        return redirect()->back()->withErrors(['error' => 'Incorrect username or password. Please try again.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
