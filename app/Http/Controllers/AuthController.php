<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::guard('superadmin')->check()) {
            return redirect('/index');
        }
        if (Auth::guard('web')->check()) {
            return redirect('/index');
        }
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $credentials = $request->only('username', 'password');

            if (Auth::guard('superadmin')->attempt($credentials)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login Superadmin Berhasil',
                    'redirect' => url('/index')
                ]);
            } elseif (Auth::guard('web')->attempt($credentials)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login User Berhasil',
                    'redirect' => url('/index')
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Login Gagal'
            ]);
        }

        return redirect('login');
    }

    public function logout(Request $request)
    {
        // Logout sesuai guard yang sedang aktif
        if (Auth::guard('superadmin')->check()) {
            Auth::guard('superadmin')->logout();
        } elseif (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
