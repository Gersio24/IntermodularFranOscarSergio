<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin(){
        return response()->json([
            'redirect' => env('FRONTEND_URL', 'http://localhost:4200') . '/'
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $roles = $user->roles->pluck('nombre')->toArray();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'access_token' => $token,
                'user' => $user,
                'roles' => $roles
            ]);
        }
    }
    public function log(Request $request){
        $email = $request->query('email');  // Obtener desde la URL
        $password = $request->query('password');

        if(Auth::attempt(['email' => $email, 'password' => $password])){
            return redirect()->route("admin");
        }

        return redirect()->route('login')->with('error', 'Inicio de sesión fallido');
    }


    public function logout(){
        Auth::logout();
        return redirect()->route('Frontend_URL');
    }
}
