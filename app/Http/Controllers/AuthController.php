<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'ml_id'         => 'integer',
            'ml_server'     => 'integer',
            'in_game_name'  => 'required|string',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|string'
        ]);

        $user = User::create([
            'ml_id'         => $request->ml_id,
            'ml_server'     => $request->ml_server,
            'in_game_name'  => $request->in_game_name,
            'email'         => $request->email,
            'password'      => bcrypt($request->password),
        ]);

        return response()->json([
            'message' => 'Registration success'
        ],202);
    }

    public function login(Request $request){
        $creds = $request->only('email', 'password');

        if(!$token = auth()->attempt($creds)){
            return response()->json([
                'error' => 'Unauthorized'
            ],401);
        }
        return $this->respondWithToken($token);
    }

    public function me(){
        return response()->json(auth()->user());
    }

    public function logout() {
        auth()->logout();
        return response()->json([
            'message' => 'Succesfully Logged Out.'
        ]);
    }

    private function respondWithToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
