<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EvaluasiModel;
use App\Models\KriteriaModel;
use App\Models\PenetapanModel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PelaksanaanModel;
use App\Models\PeningkatanModel;
use App\Models\PengendalianModel;
use App\Models\DetailKriteriaModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class KriteriaSatuController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => __('messages.krit1_title'),
            'list' => __('messages.krit1_list'),
        ];

        $page = (object) [
            'title' => __('messages.krit1_page'),
        ];

        $activeMenu = 'kriteria';
        $activeSubmenu = 'kriteria1';

        return view('kriteria1.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'activeSubmenu' => $activeSubmenu
        ]);
    }

    public function list(Request $request)
    {
        $details = DetailKriteriaModel::with('kriteria:id_kriteria,nama_kriteria')
            ->select('id_detail_kriteria', 'id_kriteria', 'status');

        $details->where('id_kriteria', 1);

        //Filter data berdasarkan id_detail_kriteria
        if ($request->id_detail_kriteria) {
            $details->where('id_detail_kriteria', $request->id_detail_kriteria);
        }

        return DataTables::of($details)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->make(true);
    }

    public function create()
    {
        $kriteria = KriteriaModel::select('id_kriteria', 'nama_kriteria')->get();

        $breadcrumb = (object) [
            'title' => __('messages.krit1_title'),
            'list' => __('messages.krit1_list')
        ];

        $page = (object) [
            'title' => __('messages.krit1_page'),
        ];

        $activeMenu = 'kriteria';
        $activeSubmenu = 'kriteria1';

        return view('kriteria1.input', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'activeSubmenu' => $activeSubmenu
        ])->with('kriteria', $kriteria);;
    }

    public function store(Request $request)
    {
        $request->validate([
            'penetapan'           => 'nullable|string',
            'pelaksanaan'         => 'nullable|string',
            'evaluasi'            => 'nullable|string',
            'pengendalian'        => 'nullable|string',
            'peningkatan'         => 'nullable|string',
            'penetapan_file'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pelaksanaan_file'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'evaluasi_file'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pengendalian_file'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'peningkatan_file'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_kriteria'         => 'required|exists:m_kriteria,id_kriteria',
            'status'              => 'required|in:save,submit',
        ]);

        $user = Auth::user();

        if (!$user->role->id_kriteria) {
            return response()->json([
                'status' => false,
                'message' => 'Role Anda tidak diizinkan menginput data kriteria.',
            ]);
        }

        // Upload helper
        $uploadFile = fn($file, $folder) =>
        $file ? $file->store("pendukung/{$folder}", 'public') : null;

        $path_penetapan    = $uploadFile($request->file('penetapan_file'), 'penetapan');
        $path_pelaksanaan  = $uploadFile($request->file('pelaksanaan_file'), 'pelaksanaan');
        $path_evaluasi     = $uploadFile($request->file('evaluasi_file'), 'evaluasi');
        $path_pengendalian = $uploadFile($request->file('pengendalian_file'), 'pengendalian');
        $path_peningkatan  = $uploadFile($request->file('peningkatan_file'), 'peningkatan');

        // Simpan data ke masing-masing model
        $penetapan = PenetapanModel::create([
            'id_kriteria' => $request->id_kriteria,
            'penetapan'   => $request->penetapan,
            'pendukung'   => $path_penetapan,
        ]);

        $pelaksanaan = PelaksanaanModel::create([
            'id_kriteria'  => $request->id_kriteria,
            'pelaksanaan'  => $request->pelaksanaan,
            'pendukung'    => $path_pelaksanaan,
        ]);

        $evaluasi = EvaluasiModel::create([
            'id_kriteria' => $request->id_kriteria,
            'evaluasi'    => $request->evaluasi,
            'pendukung'   => $path_evaluasi,
        ]);

        $pengendalian = PengendalianModel::create([
            'id_kriteria'   => $request->id_kriteria,
            'pengendalian'  => $request->pengendalian,
            'pendukung'     => $path_pengendalian,
        ]);

        $peningkatan = PeningkatanModel::create([
            'id_kriteria'  => $request->id_kriteria,
            'peningkatan'  => $request->peningkatan,
            'pendukung'    => $path_peningkatan,
        ]);

        DetailKriteriaModel::create([
            'id_kriteria'     => $request->id_kriteria,
            'id_komentar'     => null,
            'status'          => $request->status, // 'save' atau 'submit'
            'id_penetapan'    => $penetapan->id_penetapan,
            'id_pelaksanaan'  => $pelaksanaan->id_pelaksanaan,
            'id_evaluasi'     => $evaluasi->id_evaluasi,
            'id_pengendalian' => $pengendalian->id_pengendalian,
            'id_peningkatan'  => $peningkatan->id_peningkatan,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil disimpan.',
        ]);
    }

    public function edit($id)
    {
        $detail = DetailKriteriaModel::with([
            'penetapan',
            'pelaksanaan',
            'evaluasi',
            'pengendalian',
            'peningkatan'
        ])->findOrFail($id);

        $kriteria = KriteriaModel::select('id_kriteria', 'nama_kriteria')->get();

        $breadcrumb = (object) [
            'title' => 'Edit Kriteria Satu',
            'list' => ['Kriteria', 'Kriteria1', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Kriteria 1 - Statuta Polinema',
        ];

        $activeMenu = 'kriteria';
        $activeSubmenu = 'kriteria1';

        return view('kriteria1.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'activeSubmenu' => $activeSubmenu,
            'detail' => $detail,
            'kriteria' => $kriteria
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'penetapan'           => 'nullable|string',
            'pelaksanaan'         => 'nullable|string',
            'evaluasi'            => 'nullable|string',
            'pengendalian'        => 'nullable|string',
            'peningkatan'         => 'nullable|string',
            'penetapan_file'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pelaksanaan_file'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'evaluasi_file'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pengendalian_file'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'peningkatan_file'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status'              => 'sometimes|required|in:save,submit',
        ]);

        $detail = DetailKriteriaModel::findOrFail($id);

        // Update file jika ada
        $penetapan_file = $request->file('penetapan_file');
        $pelaksanaan_file = $request->file('pelaksanaan_file');
        $evaluasi_file = $request->file('evaluasi_file');
        $pengendalian_file = $request->file('pengendalian_file');
        $peningkatan_file = $request->file('peningkatan_file');

        // Update masing-masing model
        $penetapan = \App\Models\PenetapanModel::findOrFail($detail->id_penetapan);
        $penetapan->penetapan = $request->penetapan;
        if ($penetapan_file) {
            $penetapan->pendukung = $penetapan_file->store('pendukung/penetapan', 'public');
        }
        $penetapan->save();

        $pelaksanaan = \App\Models\PelaksanaanModel::findOrFail($detail->id_pelaksanaan);
        $pelaksanaan->pelaksanaan = $request->pelaksanaan;
        if ($pelaksanaan_file) {
            $pelaksanaan->pendukung = $pelaksanaan_file->store('pendukung/pelaksanaan', 'public');
        }
        $pelaksanaan->save();

        $evaluasi = \App\Models\EvaluasiModel::findOrFail($detail->id_evaluasi);
        $evaluasi->evaluasi = $request->evaluasi;
        if ($evaluasi_file) {
            $evaluasi->pendukung = $evaluasi_file->store('pendukung/evaluasi', 'public');
        }
        $evaluasi->save();

        $pengendalian = \App\Models\PengendalianModel::findOrFail($detail->id_pengendalian);
        $pengendalian->pengendalian = $request->pengendalian;
        if ($pengendalian_file) {
            $pengendalian->pendukung = $pengendalian_file->store('pendukung/pengendalian', 'public');
        }
        $pengendalian->save();

        $peningkatan = \App\Models\PeningkatanModel::findOrFail($detail->id_peningkatan);
        $peningkatan->peningkatan = $request->peningkatan;
        if ($peningkatan_file) {
            $peningkatan->pendukung = $peningkatan_file->store('pendukung/peningkatan', 'public');
        }
        $peningkatan->save();

        // Update status di detail
        $detail->status = $request->status;
        $detail->save();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diperbarui',
        ]);
    }

    public function show(string $id)
    {
        $details = DetailKriteriaModel::with('kriteria')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Kriteria 1',
            'list' => ['Home', 'Detail'],
        ];

        $page = (object) [
            'title' => 'Detail',
        ];

        return view('kriteria1.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'details' => $details, 'id' => $id]);
    }

    private function convertImagesToBase64($html)
    {
        libxml_use_internal_errors(true);
        $doc = new \DOMDocument();
        $doc->loadHTML('<?xml encoding="UTF-8">' . $html);
        $images = $doc->getElementsByTagName('img');

        foreach ($images as $img) {
            $src = $img->getAttribute('src');

            // Bersihkan path agar sesuai dengan public_path
            $src = str_replace(['../', '/storage'], ['', 'storage'], $src);
            $fullPath = public_path($src);

            if (file_exists($fullPath)) {
                $type = pathinfo($fullPath, PATHINFO_EXTENSION);
                $data = base64_encode(file_get_contents($fullPath));
                $img->setAttribute('src', 'data:image/' . $type . ';base64,' . $data);
            }
        }

        return $doc->saveHTML($doc->documentElement);
    }

    public function preview($id)
    {
        $details = DetailKriteriaModel::with(['penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan', 'kriteria'])->findOrFail($id);

        foreach (['penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan'] as $bagian) {
            if ($details->$bagian && $details->$bagian->$bagian) {
                $details->$bagian->$bagian = $this->convertImagesToBase64($details->$bagian->$bagian);
            }
        }

        $pdf = Pdf::loadView('kriteria1.export', compact('details'));
        return $pdf->stream('preview.pdf');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'section' => 'required|string'
        ]);

        try {
            $section = $request->input('section');

            // Simpan ke folder "pendukung/{section}"
            $path = $request->file('image')->store("pendukung/{$section}", 'public');
            $url = asset("storage/{$path}"); // Gunakan URL publik

            return response()->json([
                'status' => true,
                'url' => $url
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
