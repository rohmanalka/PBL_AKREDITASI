<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\RoleModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Role',
            'list' => ['Home', 'Role'],
        ];

        $page = (object) [
            'title' => 'Daftar role yang terdaftar dalam sistem',
        ];

        $activeMenu = 'role';
        $role = RoleModel::all();

        return view('superadmin.role.index', ['breadcrumb' => $breadcrumb,  'page' => $page, 'activeMenu' => $activeMenu, 'role' => $role]);
    }
    // Ambil data role dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $roles = RoleModel::select('id_role', 'role_kode', 'role_name');

        //Filter data berdasarkan id_role
        if ($request->id_role) {
            $roles->where('id_role', $request->id_role);
        }

        return DataTables::of($roles)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->make(true);
    }

    public function create()
    {
        return view('superadmin.role.create');
    }

    public function store(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'role_kode' => 'required|string|max:100|unique:m_role,role_kode',
                'role_name' => 'required|string|max:100',
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }

            RoleModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data role berhasil disimpan',
            ]);
        }
        return redirect('superadmin/role');
    }

    public function show(string $id)
    {
        $role = RoleModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Role',
            'list' => ['Home', 'Role', 'Detail'],
        ];

        $page = (object) [
            'title' => 'Detail role',
        ];

        $activeMenu = 'role';

        return view('superadmin.role.show', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'page' => $page, 'role' => $role]);
    }

    public function edit (string $id)
    {
        $role = RoleModel::find($id);
        return view('superadmin.role.edit', ['role' => $role]);
    }


    public function update (Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'role_kode' => 'required|string|max:10',
                'role_name' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }
            $check = RoleModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data role berhasil diubah',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data role tidak ditemukan',
                ]);
            }
        }
        return redirect('superadmin/role');
    }

    public function confirm (string $id)
    {
        $role = RoleModel::find($id);
        return view('superadmin.role.confirm', ['role' => $role]);
    }

    public function delete (Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $role = RoleModel::find($id);

            if ($role) {
                $role->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('superadmin/role');
    }
}
