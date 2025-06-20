<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DetailKriteriaModel;
use App\Models\KriteriaModel;
use App\Models\UserModel;
use App\Models\RoleModel;

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
            $total_pengguna = UserModel::count();
            $total_role = RoleModel::count();
            $users = UserModel::with('role')->get();
            $roles = RoleModel::all()->map(function ($role) {
                $jumlah_pengguna = \App\Models\UserModel::where('id_role', $role->id_role)->count();
                $role->users_count = $jumlah_pengguna;
                return $role;
            });


            $jumlah_tervalidasi = DetailKriteriaModel::whereIn('status', ['acc1', 'acc2'])->count();
            $jumlah_revisi = DetailKriteriaModel::where('status', 'revisi')->count();
            $menunggu_validasi = DetailKriteriaModel::where('status', 'submit')->count();

            return view('dashboard.super', compact('breadcrumb', 'activeMenu', 'activeSubmenu', 'total_pengguna', 'total_role', 'users', 'roles'));
        }

        if (Auth::guard('web')->check()) {
            // Untuk user biasa
            /** @var \App\Models\UserModel $user */
            $user = Auth::guard('web')->user();

            $roleKode = $user->role->role_name ?? null;
            $username = $user->name ?? null;

            if (!$roleKode) {
                abort(403, 'User tidak memiliki role.');
            }

            $breadcrumb = (object) [
                'title' => 'Dashboard ' . ucfirst($username),
                'list' => ['Home', ucfirst($roleKode)]
            ];
            $activeMenu = 'dashboard';
            $activeSubmenu = null;

            if (!in_array($roleKode, ['KPSKJR', 'DIRKJM', 'USERSPI'])) {
                $nomorKriteria = null;
                if (preg_match('/^KRIT(\d)$/', $roleKode, $matches)) {
                    $nomorKriteria = (int) $matches[1];
                }

                $daftar_kriteria = KriteriaModel::with('detail')
                    ->when($nomorKriteria, function ($query) use ($nomorKriteria) {
                        return $query->where('id_kriteria', $nomorKriteria);
                    })
                    ->get();

                $jumlah_tervalidasi = DetailKriteriaModel::where('status', 'tervalidasi')
                    ->where('id_kriteria', $nomorKriteria)
                    ->count();
                $jumlah_revisi = DetailKriteriaModel::where('status', 'revisi')
                    ->where('id_kriteria', $nomorKriteria)
                    ->count();
                $menunggu_validasi = DetailKriteriaModel::whereIn('status', ['submitted', 'divalidasi_kajur'])
                    ->where('id_kriteria', $nomorKriteria)
                    ->count();

                $data = $daftar_kriteria->map(function ($kriteria) {
                    $semua_status = $kriteria->detail->pluck('status');

                    $status = 'belum terpenuhi'; // default

                    if ($semua_status->contains('revisi')) {
                        $status = 'revisi';
                    } elseif ($semua_status->contains('divalidasi_kajur')) {
                        $status = 'menunggu';
                    } elseif ($semua_status->contains('tervalidasi')) {
                        $status = 'terpenuhi';
                    }

                    return [
                        'id' => $kriteria->id_kriteria,
                        'dokumen' => $kriteria->nama_kriteria,
                        'status' => $status,
                        'kriteria' => 'kriteria' . $kriteria->id_kriteria,
                    ];
                });

                return view('dashboard.kriteria', compact(
                    'breadcrumb',
                    'activeMenu',
                    'activeSubmenu',
                    'jumlah_tervalidasi',
                    'jumlah_revisi',
                    'menunggu_validasi',
                    'data',
                    'roleKode'
                ));
            } else {
                $daftar_kriteria = KriteriaModel::with('detail')->get();

                $jumlah_tervalidasi = DetailKriteriaModel::where('status', 'tervalidasi')->count();
                $jumlah_revisi = DetailKriteriaModel::where('status', 'revisi')->count();
                $menunggu_validasi = DetailKriteriaModel::whereIn('status', ['submitted', 'divalidasi_kajur'])->count();


                $data = $daftar_kriteria->map(function ($kriteria) {
                    $semua_status = $kriteria->detail->pluck('status');

                    $status = 'belum terpenuhi'; // default

                    if ($semua_status->contains('revisi')) {
                        $status = 'revisi';
                    } elseif ($semua_status->contains('divalidasi_kajur')) {
                        $status = 'menunggu';
                    } elseif ($semua_status->contains('tervalidasi')) {
                        $status = 'terpenuhi';
                    }

                    return [
                        'id' => $kriteria->id_kriteria,
                        'dokumen' => $kriteria->nama_kriteria,
                        'status' => $status,
                        'kriteria' => 'kriteria' . $kriteria->id_kriteria,
                    ];
                });

                return view('dashboard.kriteria', compact(
                    'breadcrumb',
                    'activeMenu',
                    'activeSubmenu',
                    'jumlah_tervalidasi',
                    'jumlah_revisi',
                    'menunggu_validasi',
                    'data',
                    'roleKode'
                ));
            }

            // Arahkan ke dashboard sesuai role_kode
            switch (true) {
                case in_array($roleKode, ['KRIT1', 'KRIT2', 'KRIT3', 'KRIT4', 'KRIT5', 'KRIT6', 'KRIT7', 'KRIT8', 'KRIT9', 'DIRKJM', 'KPSKJR',]):
                    return view('dashboard.kriteria', compact(
                        'breadcrumb',
                        'activeMenu',
                        'activeSubmenu',
                        'jumlah_tervalidasi',
                        'jumlah_revisi',
                        'menunggu_validasi',
                        'data'
                    ));
                case in_array($roleKode, ['USERSPI']):
                    return view('dashboard.kds', compact(
                        'breadcrumb',
                        'activeMenu',
                        'activeSubmenu',
                        'jumlah_tervalidasi',
                        'jumlah_revisi',
                        'menunggu_validasi'
                    ));
                default:
                    abort(403, 'Role tidak dikenali: ' . $roleKode);
            }
        }

        // Jika tidak login
        return redirect('/login');
    }
}
