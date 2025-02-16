<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $usuario = Auth::user();

            // Obtener roles del usuario
            $roles = $usuario->roles->pluck('nombre')->toArray();

            // Guardar roles en la sesión
            session(['roles' => $roles]);

            return response()->json(['usuario' => $usuario, 'roles' => $roles]);
        }

        return response()->json(['message' => 'Credenciales inválidas'], 401);
    }

    public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    $frontendUrl = env('FRONTEND_URL', 'http://localhost:4200/logout');

    if ($request->expectsJson() || $request->hasHeader('X-Requested-With', 'XMLHttpRequest')) {
        return response()->json([
            'message' => 'Sesión cerrada',
            'redirect' => $frontendUrl
        ]);
    }

    return redirect()->away($frontendUrl);
}

}
