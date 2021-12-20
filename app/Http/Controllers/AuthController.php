<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request){


        $validateData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        $token =$user->createToken('myapptoken')->plainTextToken;

        return response()->json(['data' => $user,$token] , 200);
    }

    public function login(Request $request){

        $validateData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email' , $request->email)->first();

        if (!$user || Hash::check($user->password , $request->password)){

            return response()->json('Bad Creds' , 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        return response()->json(['data' => $token,$user] , 200);

    }

    public function logout(Request $request){

        Auth::user()->tokens()->delete();

        return response()->json('Logged out' , 200);
    }


}
