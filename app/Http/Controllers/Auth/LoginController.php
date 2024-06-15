<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('user-login');
    }


    public function login(Request $request)
    {
        Log::info($request->all());

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return view('layout');
            // return response()->json([
            //     'message' => 'Login successful',
            //     'user' => Auth::user()
            // ], 200);
        }

        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }
}
