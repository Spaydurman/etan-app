<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AddAccountController extends Controller
{
    public function create(){
        try{
            User::create([
                'first_name' => 'Clark',
                'surname' => 'Velasco',
                'username' => 'Admin',
                'email' => 'admin@test.com',
                'change_password' => 1,
                'password' => Hash::make('password123'),
                'role' => 1,
                'image' => null
            ]);

            return response()->json([
                'message' => 'Created successful'
            ], 200);
        }catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }

    }
}
