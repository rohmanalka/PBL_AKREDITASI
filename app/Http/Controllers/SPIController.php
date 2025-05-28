<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KomentarModel;
use App\Models\KriteriaModel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\DetailKriteriaModel;
use Yajra\DataTables\Facades\DataTables;

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

        return view('spi.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'activeSubmenu' => $activeSubmenu,
            'kriteria' => $kriteria,
            'details' => $details
        ]);
    }

    public function list(Request $request)
    {
        $details = DetailKriteriaModel::with('kriteria:id_kriteria,nama_kriteria')
            ->select('id_detail_kriteria', 'id_kriteria', 'status')
            ->whereNotIn('status', ['save', 'submitted', 'divalidasi_kajur', 'revisi'])
            ->get();


        // Jika ada filter id_kriteria dari request
        if ($request->id_kriteria) {
            $details->where('id_kriteria', $request->id_kriteria);
        }

        return DataTables::of($details)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->make(true);
    }

    public function show(string $id)
    {
        $details = DetailKriteriaModel::with('kriteria')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Kriteria',
            'list' => ['Home', 'Detail'],
        ];

        $page = (object) [
            'title' => 'Detail',
        ];

        return view('spi.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'details' => $details, 'id' => $id]);
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

        $pdf = Pdf::loadView('spi.export', compact('details'));
        return $pdf->stream('preview.pdf');
    }
}
