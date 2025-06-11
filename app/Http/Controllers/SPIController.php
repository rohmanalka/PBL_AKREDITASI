<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KomentarModel;
use App\Models\KriteriaModel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\DetailKriteriaModel;
use Yajra\DataTables\Facades\DataTables;
use App\Models\PengisianModel;

class SPIController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'SPI',
            'list' => ['SPI', 'Preview'],
        ];

        $page = (object) [
            'title' => 'SPI - Preview Kriteria',
        ];

        $activeMenu = 'preview';
        $activeSubmenu = 'null';

        $details = DetailKriteriaModel::all();
        $kriteria = KriteriaModel::all();
        $pengisian = PengisianModel::all();

        return view('spi.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'activeSubmenu' => $activeSubmenu,
            'kriteria' => $kriteria,
            'details' => $details,
            'pengisian' => $pengisian,
        ]);
    }

    public function list(Request $request)
    {
        $pengisian = PengisianModel::whereHas('detail', function ($query) {
            $query->whereIn('status', ['divalidasi_kajur', 'revisi', 'tervalidasi']);
        })
            ->with(['detail' => function ($query) {
                $query->whereIn('id_kriteria', range(1, 9))
                    ->select('id_detail_kriteria', 'id_pengisian', 'id_kriteria', 'status');
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

        return view('spi.show', [
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
}
