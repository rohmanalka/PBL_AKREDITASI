<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Export PDF</title>
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
            width: 20%;
            text-align: center;
            vertical-align: middle;
        }

        .header-right {
            width: 80%;
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

        .font-9 {
            font-size: 9pt;
        }

        .font-10 {
            font-size: 10pt;
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

        h2,
        h3 {
            margin: 0;
            padding: 5px 0;
        }

        .section {
            page-break-after: always;
        }

        .section:last-child {
            page-break-after: avoid;
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
    @foreach ($details as $detail)
        <div class="section">
            <h2>Kriteria {{ $detail->kriteria->nama_kriteria }}</h2>
            @foreach (['penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan'] as $bagian)
                @php
                    $bagianData = $detail->$bagian;
                @endphp

                @if ($bagianData)
                    <h3>{{ ucfirst($bagian) }}</h3>
                    {!! $bagianData->deskripsi !!}
                    <br><br>
                @endif
            @endforeach
        </div>
    @endforeach
</body>

</html>
