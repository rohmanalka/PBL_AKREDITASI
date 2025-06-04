<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dokumen PPEPP</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }

        .header {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #333;
        }

        .header-table {
            width: 100%;
        }

        .header-left {
            width: 15%;
            text-align: center;
            vertical-align: top;
        }

        .header-right {
            width: 85%;
            text-align: center;
        }

        .header-right span {
            line-height: 1.2;
            display: block;
        }

        .image {
            width: auto;
            height: 120px;
            max-width: 150px;
            max-height: 150px;
        }

        .font-10 {
            font-size: 10pt;
        }

        .font-11 {
            font-size: 11pt;
        }

        .font-13 {
            font-size: 13pt;
        }

        .font-bold {
            font-weight: bold;
        }

        .mb-1 {
            margin-bottom: 3px;
            display: block;
        }

        .document-title {
            font-size: 16px;
            text-align: center;
            margin: 20px 0 10px 0;
            font-weight: bold;
        }

        .criteria-title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin: 15px 0;
        }

        .ppepp-section {
            margin-bottom: 15px;
            page-break-inside: avoid;
        }

        .ppepp-number {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .ppepp-content {
            text-align: justify;
            margin-left: 20px;
            margin-bottom: 10px;
        }

        .supporting-image {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
            border: 1px solid #ddd;
            padding: 5px;
        }

        .image-container {
            text-align: center;
            margin: 10px 0;
        }

        .image-caption {
            font-style: italic;
            font-size: 11px;
            margin-top: 5px;
        }
        .header-left {
            width: 20%;
            text-align: center;
            vertical-align: middle;
        }
        .header-right {
            width: 80%;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="header">
        <table class="header-table">
            <tr>
                <td class="header-left">
                    <img src="{{ public_path('images/screenshots/Logo-Polinema.png') }}" class="image">
                </td>
                <td class="header-right">
                    <span class="font-10 mb-1">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</span>
                    <span class="font-13 font-bold mb-1">POLITEKNIK NEGERI MALANG</span>
                    <span class="font-9 mb-1">Jl. Soekarno-Hatta No. 9 Malang 65141</span>
                    <span class="font-9 mb-1">Telepon (0341) 404424 Pes. 101-105, 0341-404420, Fax. (0341) 404420</span>
                    <span class="font-9">Laman: www.polinema.ac.id</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="criteria-title">{{ $details->kriteria->nama_kriteria ?? 'Tanpa Kriteria' }}</div>

    <div class="ppepp-section">
        <div class="ppepp-number">1. Penetapan</div>
        <div class="ppepp-content">
            {!! $details->penetapan->deskripsi ?? '<i>Tidak ada data</i>' !!}
            {{-- @if ($details->penetapan && $details->penetapan->pendukung)
                <div class="image-container">
                    <img src="{{ storage_path('app/public/' . $details->penetapan->pendukung) }}"
                        class="supporting-image">
                    <div class="image-caption">Dokumen Pendukung Penetapan</div>
                </div>
            @endif --}}
        </div>
    </div>

    <div class="ppepp-section">
        <div class="ppepp-number">2. Pelaksanaan</div>
        <div class="ppepp-content">
            {!! $details->pelaksanaan->deskripsi ?? '<i>Tidak ada data</i>' !!}
            {{-- @if ($details->pelaksanaan && $details->pelaksanaan->pendukung)
                <div class="image-container">
                    <img src="{{ storage_path('app/public/' . $details->pelaksanaan->pendukung) }}"
                        class="supporting-image">
                    <div class="image-caption">Dokumen Pendukung Pelaksanaan</div>
                </div>
            @endif --}}
        </div>
    </div>

    <div class="ppepp-section">
        <div class="ppepp-number">3. Evaluasi</div>
        <div class="ppepp-content">
            {!! $details->evaluasi->deskripsi ?? '<i>Tidak ada data</i>' !!}
            {{-- @if ($details->evaluasi && $details->evaluasi->pendukung)
                <div class="image-container">
                    <img src="{{ storage_path('app/public/' . $details->evaluasi->pendukung) }}"
                        class="supporting-image">
                    <div class="image-caption">Dokumen Pendukung Evaluasi</div>
                </div>
            @endif --}}
        </div>
    </div>

    <div class="ppepp-section">
        <div class="ppepp-number">4. Pengendalian</div>
        <div class="ppepp-content">
            {!! $details->pengendalian->deskripsi ?? '<i>Tidak ada data</i>' !!}
            {{-- @if ($details->pengendalian && $details->pengendalian->pendukung)
                <div class="image-container">
                    <img src="{{ storage_path('app/public/' . $details->pengendalian->pendukung) }}"
                        class="supporting-image">
                    <div class="image-caption">Dokumen Pendukung Pengendalian</div>
                </div>
            @endif --}}
        </div>
    </div>

    <div class="ppepp-section">
        <div class="ppepp-number">5. Peningkatan</div>
        <div class="ppepp-content">
            {!! $details->peningkatan->deskripsi ?? '<i>Tidak ada data</i>' !!}
            {{-- @if ($details->peningkatan && $details->peningkatan->pendukung)
                <div class="image-container">
                    <img src="{{ storage_path('app/public/' . $details->peningkatan->pendukung) }}"
                        class="supporting-image">
                    <div class="image-caption">Dokumen Pendukung Peningkatan</div>
                </div>
            @endif --}}
        </div>
    </div>

</body>

</html>
