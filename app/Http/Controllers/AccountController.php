<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AccountController extends Controller
{
    public function index(){
        return view('admin/account/add-account')
            ->with('Title', 'Add Account')
            ->with('user', Auth::user());
    }

    public function create(Request $request){
        try{
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'role' => 'required|in:1,2,3',
                'password' => 'required|string|min:8|confirmed',
            ]);

            $validatedData['change_password'] = 0;
            $validatedData['password'] = Hash::make($validatedData['password']);

            // Create the user
            $user = User::create($validatedData);
            Log::info('User created successfully '.$user->username, [
                'user' => Auth::user()->username,
                'time' => Carbon::now()
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully '.$user->username
            ], 201);
        }catch (ValidationException $e) {
            Log::info('Creating Account | Error |'.$e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Saving failed',
                'errors' => $e->errors()
            ], 422);
        }catch(Exception $e){
            Log::info('Creating Account | Error |'.$e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Please try again!',
            ], 422);
        }

    }
}
