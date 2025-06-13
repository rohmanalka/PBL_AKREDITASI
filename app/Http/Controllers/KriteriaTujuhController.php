<?php

namespace App\Http\Controllers;

use DOMDocument;
use Illuminate\Http\Request;
use App\Models\EvaluasiModel;
use App\Models\KriteriaModel;
use App\Models\PenetapanModel;
use App\Models\PengisianModel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PelaksanaanModel;
use App\Models\PeningkatanModel;
use App\Models\PengendalianModel;
use App\Models\DetailKriteriaModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class KriteriaTujuhController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => __('kriteria.kriteria.7.title'),
            'list' => __('kriteria.kriteria.7.list'),
        ];

        $page = (object) [
            'title' => __('kriteria.kriteria.7.page'),
        ];

        $activeMenu = 'riwayat7';

        return view('kriteria7.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $details = DetailKriteriaModel::with([
            'kriteria:id_kriteria,nama_kriteria',
            'pengisian:id_pengisian,nama_pengisian'
        ])
            ->select('id_detail_kriteria', 'id_kriteria', 'id_pengisian', 'status');

        $details->where('id_kriteria', 7);

        //Filter data berdasarkan id_detail_kriteria
        if ($request->id_detail_kriteria) {
            $details->where('id_detail_kriteria', $request->id_detail_kriteria);
        }

        return DataTables::of($details)
            ->addIndexColumn()
            ->make(true);
    }

    public function create()
    {
        $kriteria = KriteriaModel::select('id_kriteria', 'nama_kriteria')->get();

        $breadcrumb = (object) [
            'title' => __('kriteria.kriteria.7.titleinpt'),
            'list' => __('kriteria.kriteria.7.listinpt'),
        ];

        $page = (object) [
            'title' => __('kriteria.kriteria.7.pageinpt'),
        ];

        $activeMenu = 'input7';

        return view('kriteria7.input', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
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
            'status'              => 'required|in:save,submitted',
        ]);

        $user = Auth::user();

        if (!$user->role->id_kriteria) {
            return response()->json([
                'status' => false,
                'message' => 'Role Anda tidak diizinkan menginput data kriteria.',
            ]);
        }

        $availableBatch = null;

        $batches = PengisianModel::withCount('detail')
            ->having('detail_count', '<', 9)
            ->orderBy('id_pengisian', 'asc')
            ->get();

        foreach ($batches as $batch) {
            $exists = DetailKriteriaModel::where('id_pengisian', $batch->id_pengisian)
                ->where('id_kriteria', $request->id_kriteria)
                ->exists();

            if (!$exists) {
                $availableBatch = $batch;
                break;
            }
        }

        if (!$availableBatch) {
            $availableBatch = PengisianModel::create([
                'nama_pengisian' => '',
            ]);

            $availableBatch->update([
                'nama_pengisian' => 'Dokumen Bagian ' . $availableBatch->id_pengisian,
            ]);
        }

        $batch = $availableBatch;
        $idPengisian = $request->status === 'save' ? null : $batch->id_pengisian;

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
            'deskripsi'   => $request->penetapan,
            'pendukung'   => $path_penetapan,
        ]);

        $pelaksanaan = PelaksanaanModel::create([
            'id_kriteria'  => $request->id_kriteria,
            'deskripsi'  => $request->pelaksanaan,
            'pendukung'    => $path_pelaksanaan,
        ]);

        $evaluasi = EvaluasiModel::create([
            'id_kriteria' => $request->id_kriteria,
            'deskripsi'    => $request->evaluasi,
            'pendukung'   => $path_evaluasi,
        ]);

        $pengendalian = PengendalianModel::create([
            'id_kriteria'   => $request->id_kriteria,
            'deskripsi'  => $request->pengendalian,
            'pendukung'     => $path_pengendalian,
        ]);

        $peningkatan = PeningkatanModel::create([
            'id_kriteria'  => $request->id_kriteria,
            'deskripsi'  => $request->peningkatan,
            'pendukung'    => $path_peningkatan,
        ]);

        DetailKriteriaModel::create([
            'id_kriteria'     => $request->id_kriteria,
            'id_pengisian'    => $idPengisian,
            'id_komentar'     => null,
            'status'          => $request->status,
            'id_penetapan'    => $penetapan->id_penetapan,
            'id_pelaksanaan'  => $pelaksanaan->id_pelaksanaan,
            'id_evaluasi'     => $evaluasi->id_evaluasi,
            'id_pengendalian' => $pengendalian->id_pengendalian,
            'id_peningkatan'  => $peningkatan->id_peningkatan,
        ]);

        return response()->json([
            'status'  => true,
            'message' => __('kriteria.simpanberhasil'),
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

        $ppeppRelations = ['penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan'];
        foreach ($ppeppRelations as $relasi) {
            if ($detail->$relasi && $detail->$relasi->deskripsi) {
                $deskripsi = $detail->$relasi->deskripsi;

                libxml_use_internal_errors(true);
                $dom = new DOMDocument();
                $dom->loadHTML('<?xml encoding="utf-8" ?>' . $deskripsi, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

                $images = $dom->getElementsByTagName('img');
                foreach ($images as $img) {
                    $src = $img->getAttribute('src');
                    if (strpos($src, '../storage/') !== false || strpos($src, '/storage/') === 0) {
                        $absoluteUrl = url(ltrim(str_replace('../', '', $src), '/'));
                        $img->setAttribute('src', $absoluteUrl);
                    }
                }

                $detail->$relasi->deskripsi = $dom->saveHTML();
                libxml_clear_errors();
            }
        }

        $kriteria = KriteriaModel::select('id_kriteria', 'nama_kriteria')->get();

        $breadcrumb = (object) [
            'title' =>  __('kriteria.kriteria.7.titleedit'),
            'list' =>  __('kriteria.kriteria.7.listedit'),
        ];

        $page = (object) [
            'title' =>  __('kriteria.kriteria.7.pageedit'),
        ];

        $activeMenu = 'riwayat7';

        return view('kriteria7.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
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
            'status'              => 'required|in:save,submitted',
        ]);

        $detail = DetailKriteriaModel::findOrFail($id);

        if ($request->status === 'submitted' && $detail->id_pengisian === null) {
            $batch = PengisianModel::withCount('detail')
                ->having('detail_count', '<', 9)
                ->orderBy('id_pengisian', 'asc')
                ->get()
                ->first(function ($batch) use ($detail) {
                    return !DetailKriteriaModel::where('id_pengisian', $batch->id_pengisian)
                        ->where('id_kriteria', $detail->id_kriteria)
                        ->exists();
                });

            if (!$batch) {
                $batch = PengisianModel::create(['nama_pengisian' => '']);
                $batch->update([
                    'nama_pengisian' => 'Dokumen Bagian ' . $batch->id_pengisian,
                ]);
            }

            $detail->id_pengisian = $batch->id_pengisian;
        }
        // Penetapan
        $penetapan = PenetapanModel::find($detail->id_penetapan);
        if ($penetapan) {
            $penetapan->deskripsi = $request->penetapan;
            if ($request->hasFile('penetapan_file')) {
                $penetapan->pendukung = $request->file('penetapan_file')->store('pendukung/penetapan');
            }
            $penetapan->save();
        }

        // Pelaksanaan
        $pelaksanaan = PelaksanaanModel::find($detail->id_pelaksanaan);
        if ($pelaksanaan) {
            $pelaksanaan->deskripsi = $request->pelaksanaan;
            if ($request->hasFile('pelaksanaan_file')) {
                $pelaksanaan->pendukung = $request->file('pelaksanaan_file')->store('pendukung/pelaksanaan');
            }
            $pelaksanaan->save();
        }

        // Evaluasi
        $evaluasi = EvaluasiModel::find($detail->id_evaluasi);
        if ($evaluasi) {
            $evaluasi->deskripsi = $request->evaluasi;
            if ($request->hasFile('evaluasi_file')) {
                $evaluasi->pendukung = $request->file('evaluasi_file')->store('pendukung/evaluasi');
            }
            $evaluasi->save();
        }

        // Pengendalian
        $pengendalian = PengendalianModel::find($detail->id_pengendalian);
        if ($pengendalian) {
            $pengendalian->deskripsi = $request->pengendalian;
            if ($request->hasFile('pengendalian_file')) {
                $pengendalian->pendukung = $request->file('pengendalian_file')->store('pendukung/pengendalian');
            }
            $pengendalian->save();
        }

        // Peningkatan
        $peningkatan = PeningkatanModel::find($detail->id_peningkatan);
        if ($peningkatan) {
            $peningkatan->deskripsi = $request->peningkatan;
            if ($request->hasFile('peningkatan_file')) {
                $peningkatan->pendukung = $request->file('peningkatan_file')->store('pendukung/peningkatan');
            }
            $peningkatan->save();
        }

        // Update status di DetailKriteria
        $detail->status = $request->status; // 'save' atau 'submitted'
        $detail->save();

        return response()->json([
            'status' => true,
            'message' => __('kriteria.editberhasil') . $request->status
        ]);
    }


    public function show(string $id)
    {
        $details = DetailKriteriaModel::with('kriteria')->find($id);
        return view('kriteria7.show', ['details' => $details, 'id' => $id]);
    }

    private function convertImagesToBase64($html)
    {
        libxml_use_internal_errors(true);
        $doc = new \DOMDocument();
        $doc->loadHTML('<?xml encoding="UTF-8">' . $html);
        $images = $doc->getElementsByTagName('img');

        foreach ($images as $img) {
            $src = $img->getAttribute('src');

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
            if ($details->$bagian && $details->$bagian->deskripsi) {
                $details->$bagian->deskripsi = $this->convertImagesToBase64($details->$bagian->deskripsi);
            }
        }

        $pdf = Pdf::loadView('kriteria7.export', compact('details'));
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
        return view('kriteria7.confirm', ['details' => $details, 'id' => $id]);
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

        $penetapan    = $detail->penetapan;
        $pelaksanaan  = $detail->pelaksanaan;
        $evaluasi     = $detail->evaluasi;
        $pengendalian = $detail->pengendalian;
        $peningkatan  = $detail->peningkatan;

        $detail->delete();

        $deleteFile = function ($model) {
            if ($model && $model->pendukung) {
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

        $deleteImageFilesFromHtml = function ($html) {
            if (!$html) return;

            preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/', $html, $matches);

            foreach ($matches[1] as $src) {
                $relativePath = ltrim(str_replace(['../../storage/', '../storage/', 'storage/'], '', $src), '/');
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

        $deleteImageFilesFromHtml($penetapan->deskripsi ?? '');
        $deleteImageFilesFromHtml($pelaksanaan->deskripsi ?? '');
        $deleteImageFilesFromHtml($evaluasi->deskripsi ?? '');
        $deleteImageFilesFromHtml($pengendalian->deskripsi ?? '');
        $deleteImageFilesFromHtml($peningkatan->deskripsi ?? '');

        $penetapan?->delete();
        $pelaksanaan?->delete();
        $evaluasi?->delete();
        $pengendalian?->delete();
        $peningkatan?->delete();

        return response()->json([
            'status' => true,
            'message' => __('kriteria.berhasil'),
        ]);
    }
}
