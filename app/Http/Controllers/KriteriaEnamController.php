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
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class KriteriaEnamController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Criterion Six',
            'list' => ['Criterion', 'Criterion6']
        ];

        $page = (object) [
            'title' => 'Criterion 6 - SIB Polinema',
        ];

        $activeMenu = 'kriteria';
        $activeSubmenu = 'kriteria6';

        return view('kriteria6.index', [
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

        $details->where('id_kriteria', 6);

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
            'title' => ('Criterion Six'),
            'list' => ['Criterion', 'Criterion6']
        ];

        $page = (object) [
            'title' => ('Criterion 6 - SIB Polinema'),
        ];

        $activeMenu = 'kriteria';
        $activeSubmenu = 'kriteria6';

        return view(view: 'kriteria6.input', data: [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'activeSubmenu' => $activeSubmenu
        ])->with(key: 'kriteria', value: $kriteria);;
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
        $file ? $file->store("storage/pendukung/{$folder}", 'public') : null;

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

        // Konversi path relatif ke absolut
        if ($detail->penetapan && $detail->penetapan->penetapan) {
            $detail->penetapan->penetapan = str_replace(
                '../storage/',
                rtrim(url('storage'), '/') . '/', // Gunakan url() helper bukan asset()
                $detail->penetapan->penetapan
            );
        }

        $kriteria = KriteriaModel::select('id_kriteria', 'nama_kriteria')->get();

        $breadcrumb = (object) [
            'title' => 'Edit Kriteria Enam',
            'list' => ['Kriteria', 'Kriteria6', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Kriteria 6 - Statuta Polinema',
        ];

        $activeMenu = 'kriteria';
        $activeSubmenu = 'kriteria6';

        return view('kriteria6.edit', [
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
            'status'              => 'required|in:save,submit',
        ]);

        $detail = DetailKriteriaModel::findOrFail($id);

        // Penetapan
        $penetapan = PenetapanModel::find($detail->id_penetapan);
        if ($penetapan) {
            $penetapan->penetapan = $request->penetapan;
            if ($request->hasFile('penetapan_file')) {
                $penetapan->pendukung = $request->file('penetapan_file')->store('pendukung/penetapan');
            }
            $penetapan->save();
        }

        // Pelaksanaan
        $pelaksanaan = PelaksanaanModel::find($detail->id_pelaksanaan);
        if ($pelaksanaan) {
            $pelaksanaan->pelaksanaan = $request->pelaksanaan;
            if ($request->hasFile('pelaksanaan_file')) {
                $pelaksanaan->pendukung = $request->file('pelaksanaan_file')->store('pendukung/pelaksanaan');
            }
            $pelaksanaan->save();
        }

        // Evaluasi
        $evaluasi = EvaluasiModel::find($detail->id_evaluasi);
        if ($evaluasi) {
            $evaluasi->evaluasi = $request->evaluasi;
            if ($request->hasFile('evaluasi_file')) {
                $evaluasi->pendukung = $request->file('evaluasi_file')->store('pendukung/evaluasi');
            }
            $evaluasi->save();
        }

        // Pengendalian
        $pengendalian = PengendalianModel::find($detail->id_pengendalian);
        if ($pengendalian) {
            $pengendalian->pengendalian = $request->pengendalian;
            if ($request->hasFile('pengendalian_file')) {
                $pengendalian->pendukung = $request->file('pengendalian_file')->store('pendukung/pengendalian');
            }
            $pengendalian->save();
        }

        // Peningkatan
        $peningkatan = PeningkatanModel::find($detail->id_peningkatan);
        if ($peningkatan) {
            $peningkatan->peningkatan = $request->peningkatan;
            if ($request->hasFile('peningkatan_file')) {
                $peningkatan->pendukung = $request->file('peningkatan_file')->store('pendukung/peningkatan');
            }
            $peningkatan->save();
        }

        // Update status di DetailKriteria
        $detail->status = $request->status; // 'save' atau 'submit'
        $detail->save();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diupdate dengan status ' . $request->status
        ]);
    }


    public function show(string $id)
    {
        $details = DetailKriteriaModel::with('kriteria')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Kriteria 6',
            'list' => ['Home', 'Detail'],
        ];

        $page = (object) [
            'title' => 'Detail',
        ];

        return view('kriteria6.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'details' => $details, 'id' => $id]);
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

        $pdf = Pdf::loadView('kriteria6.export', compact('details'));
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

    public function confirm(string $id)
    {
        $details = DetailKriteriaModel::with('kriteria')->find($id);

        $breadcrumb = (object) [
            'title' => 'Data Kriteria 6',
            'list' => ['Home', 'Hapus'],
        ];

        $page = (object) [
            'title' => 'Hapus',
        ];

        return view('kriteria6.confirm', ['breadcrumb' => $breadcrumb, 'page' => $page, 'details' => $details, 'id' => $id]);
    }

    public function delete(Request $request, $id)
    {
        $detail = DetailKriteriaModel::with([
            'penetapan',
            'pelaksanaan',
            'evaluasi',
            'pengendalian',
            'peningkatan'
        ])->findOrFail($id);

        // Simpan relasi sebelum hapus detail
        $penetapan    = $detail->penetapan;
        $pelaksanaan  = $detail->pelaksanaan;
        $evaluasi     = $detail->evaluasi;
        $pengendalian = $detail->pengendalian;
        $peningkatan  = $detail->peningkatan;

        // Hapus dulu data utama yang punya foreign key
        $detail->delete();

        // Hapus file dari storage jika ada
        $deleteFile = function ($model) {
            if ($model && $model->pendukung) {
                // Ubah ke path relatif dari storage/app/public
                $relativePath = ltrim(str_replace('../storage/', '', $model->pendukung), '/');

                Log::info("Cek file: " . $relativePath);

                if (Storage::disk('public')->exists($relativePath)) {
                    Log::info("File ditemukan, menghapus: " . $relativePath);
                    Storage::disk('public')->delete($relativePath);
                } else {
                    Log::warning("File tidak ditemukan: " . $relativePath);
                }
            }
        };

        // Hapus semua <img src="..."> di dalam HTML
        $deleteImageFilesFromHtml = function ($html) {
            if (!$html) return;

            // Ambil semua <img src="..."> dari konten
            preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/', $html, $matches);

            foreach ($matches[1] as $src) {
                // Hapus prefix "../storage/" atau "storage/"
                $relativePath = ltrim(str_replace(['../storage/', 'storage/'], '', $src), '/');

                // Full path di public
                $fullPath = public_path('storage/' . $relativePath);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }
        };

        $deleteFile($penetapan);
        $deleteFile($pelaksanaan);
        $deleteFile($evaluasi);
        $deleteFile($pengendalian);
        $deleteFile($peningkatan);

        // Hapus juga semua file di dalam isi HTML
        $deleteImageFilesFromHtml($penetapan->penetapan ?? '');
        $deleteImageFilesFromHtml($pelaksanaan->pelaksanaan ?? '');
        $deleteImageFilesFromHtml($evaluasi->evaluasi ?? '');
        $deleteImageFilesFromHtml($pengendalian->pengendalian ?? '');
        $deleteImageFilesFromHtml($peningkatan->peningkatan ?? '');

        // Hapus relasi setelah detail dihapus
        $penetapan?->delete();
        $pelaksanaan?->delete();
        $evaluasi?->delete();
        $pengendalian?->delete();
        $peningkatan?->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus.',
        ]);
    }
}
