<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index()
    {
        if (Auth::guard('superadmin')->check()) {
            // Untuk superadmin
            $user = Auth::guard('superadmin')->user();

            $breadcrumb = (object) [
                'title' => 'Dashboard Superadmin',
                'list' => ['Home', 'Superadmin']
            ];
            $activeMenu = 'dashboard';
            $activeSubmenu = null;

            return view('dashboard.super', compact('breadcrumb', 'activeMenu', 'activeSubmenu'));
        }

        if (Auth::guard('web')->check()) {
            // Untuk user biasa
            /** @var \App\Models\UserModel $user */
            $user = Auth::guard('web')->user();

            $roleKode = $user->role->role_kode ?? null; // Menghindari null error

            if (!$roleKode) {
                abort(403, 'User tidak memiliki role.');
            }

            $breadcrumb = (object) [
                'title' => 'Dashboard ' . ucfirst($roleKode),
                'list' => ['Home', ucfirst($roleKode)]
            ];
            $activeMenu = 'dashboard';
            $activeSubmenu = null;

            // Arahkan ke dashboard sesuai role_kode
            switch ($roleKode) {
                case 'KRIT1':
                    return view('dashboard.kriteria', compact('breadcrumb', 'activeMenu', 'activeSubmenu'));
                case 'KRIT2':
                    return view('dashboard.kriteria', compact('breadcrumb', 'activeMenu', 'activeSubmenu'));
                case 'DIR':
                case 'KPSKJR':
                    return view('dashboard.kds', compact('breadcrumb', 'activeMenu', 'activeSubmenu'));
                default:
                    abort(403, 'Role tidak dikenali: ' . $roleKode);
            }
        }

        // Jika tidak login
        return redirect('/login');
    }
}
