<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DetailKriteriaModel;
use App\Models\KriteriaModel;

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

            $jumlah_tervalidasi = DetailKriteriaModel::whereIn('status', ['acc1', 'acc2'])->count();
            $jumlah_revisi = DetailKriteriaModel::where('status', 'revisi')->count();
            $menunggu_validasi = DetailKriteriaModel::where('status', 'submit')->count();

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

            $jumlah_tervalidasi = DetailKriteriaModel::whereIn('status', ['acc1', 'acc2'])->count();
            $jumlah_revisi = DetailKriteriaModel::where('status', 'revisi')->count();
            $menunggu_validasi = DetailKriteriaModel::where('status', 'submit')->count();

            if (in_array($roleKode, ['KRIT1', 'KRIT2', 'KRIT3', 'KRIT4', 'KRIT5', 'KRIT6', 'KRIT7', 'KRIT8', 'KRIT9', 'KPSKJR'])) {
                $daftar_kriteria = KriteriaModel::with('detail')->get();

                $data = $daftar_kriteria->map(function ($kriteria) {
                    $semua_status = $kriteria->detail->pluck('status');

                    if ($semua_status->isEmpty()) {
                        $status = 'Belum Terpenuhi';
                    } elseif ($semua_status->contains('revisi')) {
                        $status = 'Belum Terpenuhi';
                    } else {
                        $status = 'Terpenuhi';
                    }

                    return [
                        'id' => $kriteria->id_kriteria,
                        'dokumen' => $kriteria->nama_kriteria,
                        'status' => $status,
                    ];
                });

                return view('dashboard.kriteria', compact(
                    'breadcrumb', 'activeMenu', 'activeSubmenu',
                    'jumlah_tervalidasi', 'jumlah_revisi', 'menunggu_validasi',
                    'data', 'roleKode'
                ));
            }

            // Arahkan ke dashboard sesuai role_kode
            switch ($roleKode) {
                case 'KRIT1':
                    return view('dashboard.kriteria', compact('breadcrumb', 'activeMenu', 'activeSubmenu', 'jumlah_tervalidasi', 'jumlah_revisi', 'menunggu_validasi'));
                case 'KRIT2':
                    return view('dashboard.kriteria', compact('breadcrumb', 'activeMenu', 'activeSubmenu', 'jumlah_tervalidasi', 'jumlah_revisi', 'menunggu_validasi'));
                case 'DIR':
                case 'KPSKJR':
                    return view('dashboard.kds', compact('breadcrumb', 'activeMenu', 'activeSubmenu', 'jumlah_tervalidasi', 'jumlah_revisi', 'menunggu_validasi'));
                default:
                    abort(403, 'Role tidak dikenali: ' . $roleKode);
            }
        }

        // Jika tidak login
        return redirect('/login');
    }
}
