@extends('layouts.template')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <!-- Kartu Tervalidasi -->
            <div class="col-xl-4 col-sm-8 mb-xl-0 mb-4">
                <div class="card border-0 shadow" style="background-color: #4CAF50;">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers text-white">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bolder">Tervalidasi</p>
                                    <h5 class="text-white" id="jumlah-tervalidasi">
                                        {{ $jumlah_tervalidasi }}
                                        <span style="font-size: 15px;">Kriteria Tervalidasi</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape shadow-primary text-center rounded-circle">
                                    <i class="ni ni-bullet-list-67 text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu Revisi -->
            <div class="col-xl-4 col-sm-8 mb-xl-0 mb-4">
                <div class="card border-0 shadow" style="background-color: #e3c542;">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers text-white">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bolder">Revisi</p>
                                    <h5 class="text-white" id="jumlah-revisi">
                                        {{ $jumlah_revisi }}
                                        <span style="font-size: 15px;">Kriteria Memerlukan Revisi</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape shadow-danger text-center rounded-circle">
                                    <i class="ni ni-single-copy-04 text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu Menunggu Validasi -->
            <div class="col-xl-4 col-sm-8 mb-xl-0 mb-4">
                <div class="card border-0 shadow" style="background-color: #7e7e7e;">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers text-white">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bolder">Menunggu Validasi</p>
                                    <h5 class="text-white" id="jumlah-menunggu-validasi">
                                        {{ $menunggu_validasi }}
                                        <span style="font-size: 15px;">Kriteria Menunggu Validasi</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape shadow-danger text-center rounded-circle">
                                    <i class="ni ni-time-alarm text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Kriteria -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>{{ $page->title ?? 'DAFTAR DOKUMEN KRITERIA' }}</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="px-3 mt-3">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                        </div>
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0" id="table_detail_kriteria">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">
                                            ID</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            {{ __('kriteria.nmkrit') }}</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Status</th>
                                        <th
                                            class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $i => $item)
                                        <tr>
                                            <td class="text-center">{{ $i + 1 }}</td>
                                            <td>{{ $item['dokumen'] }}</td>
                                            <td>
                                                @php
                                                    $badgeClass = 'bg-secondary';
                                                    $badgeText = ucfirst($item['status']);

                                                    switch ($item['status']) {
                                                        case 'terpenuhi':
                                                            $badgeClass = 'bg-success';
                                                            $badgeText = 'Terpenuhi';
                                                            break;
                                                        case 'revisi':
                                                            $badgeClass = 'bg-danger';
                                                            $badgeText = 'Revisi';
                                                            break;
                                                        case 'menunggu':
                                                            $badgeClass = 'bg-warning text-dark';
                                                            $badgeText = 'Menunggu Validasi';
                                                            break;
                                                        case 'belum terpenuhi':
                                                        default:
                                                            $badgeClass = 'bg-secondary';
                                                            $badgeText = 'Belum Terpenuhi';
                                                            break;
                                                    }
                                                @endphp

                                                <span class="badge {{ $badgeClass }}">
                                                    {{ $badgeText }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ url('/' . strtolower($roleKode)) }}"
                                                    class="btn btn-sm btn-primary">Lihat</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection