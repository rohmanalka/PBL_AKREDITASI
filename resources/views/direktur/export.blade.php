<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Export PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
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
