<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KomentarModel;
use App\Models\KriteriaModel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\DetailKriteriaModel;
use App\Models\PengisianModel;
use Yajra\DataTables\Facades\DataTables;

class DirekturController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Direktur',
            'list' => ['Direktur', 'Validasi'],
        ];

        $page = (object) [
            'title' => 'Direktur - Validasi Kriteria',
        ];

        $activeMenu = 'validasi';
        $activeSubmenu = 'null';

        $details = DetailKriteriaModel::all();
        $kriteria = KriteriaModel::all();
        $pengisian = PengisianModel::all();

        return view('direktur.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'activeSubmenu' => $activeSubmenu,
            'kriteria' => $kriteria,
            'details' => $details,
            'pengisian' => $pengisian
        ]);
    }

    public function list(Request $request)
    {
        $pengisian = PengisianModel::whereHas('detail', function ($query) {
            $query->where('status', '=', 'divalidasi_kajur');
        })
            ->with(['detail' => function ($query) {
                $query->select('id_detail_kriteria', 'id_pengisian', 'status');
            }])
            ->select('id_pengisian', 'nama_pengisian');

        if ($request->id_pengisian) {
            $pengisian->where('id_pengisian', $request->id_pengisian);
        }

        return DataTables::of($pengisian)
            ->addIndexColumn()
            ->make(true);
    }

    public function show(string $id_pengisian)
    {
        $pengisian = PengisianModel::where('id_pengisian', $id_pengisian)->first();

        $breadcrumb = (object) [
            'title' => 'Detail Kriteria',
            'list' => ['Home', 'Detail'],
        ];

        $page = (object) [
            'title' => 'Detail',
        ];

        return view('direktur.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'pengisian' => $pengisian,
            'id_pengisian' => $id_pengisian
        ]);
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

    // public function preview($id)
    // {
    //     $details = DetailKriteriaModel::with(['penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan', 'kriteria'])->findOrFail($id);

    //     foreach (['penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan'] as $bagian) {
    //         if ($details->$bagian && $details->$bagian->deskripsi) {
    //             $details->$bagian->deskripsi = $this->convertImagesToBase64($details->$bagian->deskripsi);
    //         }
    //     }

    //     $pdf = Pdf::loadView('direktur.export', compact('details'));
    //     return $pdf->stream('preview.pdf');
    // }

    public function exportMergedPdf($id_pengisian)
    {
        $details = DetailKriteriaModel::with(['penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan', 'kriteria'])
            ->where('id_pengisian', $id_pengisian)
            ->orderBy('id_kriteria')
            ->get();

        foreach ($details as $detail) {
            foreach (['penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan'] as $bagian) {
                if ($detail->$bagian && $detail->$bagian->deskripsi) {
                    $detail->$bagian->deskripsi = $this->convertImagesToBase64($detail->$bagian->deskripsi);
                }
            }
        }

        $pdf = Pdf::loadView('direktur.export', compact('details'));
        return $pdf->stream("validasi_kriteria_batch_{$id_pengisian}.pdf");
    }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'status' => 'required|in:tervalidasi,revisi',
    //         'komentar' => 'nullable|string',
    //     ]);

    //     $detail = DetailKriteriaModel::with('kriteria')->findOrFail($id);

    //     $komentar = KomentarModel::create([
    //         'komentar' => $request->komentar
    //     ]);

    //     $detail->status = $request->status;
    //     $detail->id_komentar = $komentar->id_komentar;
    //     $detail->save();

    //     return redirect('validasi-dir')->with('success', 'Validasi berhasil disimpan.');
    // }

    public function update(Request $request, $id_pengisian)
    {
        $pengisian = PengisianModel::with('detail')->findOrFail($id_pengisian);

        $detailInput = $request->input('detail', []); // ambil semua kriteria revisi dari form

        foreach ($pengisian->detail as $detail) {
            $id_detail = $detail->id_detail_kriteria;

            if (isset($detailInput[$id_detail]['revisi'])) {
                // Revisi dipilih
                $komentarText = $detailInput[$id_detail]['komentar'] ?? '';

                // Simpan komentar
                $komentar = KomentarModel::create([
                    'komentar' => $komentarText
                ]);

                $detail->status = 'revisi';
                $detail->id_komentar = $komentar->id_komentar;
                $detail->save();
            } else {
                // Tidak direvisi, maka divalidasi_kajur
                $detail->status = 'divalidasi_kajur';
                $detail->save();
            }
        }

        // Jika status validasi adalah "tervalidasi", maka ubah semua ke tervalidasi
        if ($request->status_validasi === 'tervalidasi') {
            foreach ($pengisian->detail as $detail) {
                $detail->status = 'tervalidasi';
                $detail->save();
            }
        }

        return redirect('validasi-dir')->with('success', 'Validasi berhasil disimpan.');
    }
}
