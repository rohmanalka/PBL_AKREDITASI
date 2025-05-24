@extends('layouts.template')

@section('content')
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

    <!-- Menunggu Validasi -->
    <div class="col-xl-4 col-sm-8 mb-xl-0 mb-4">
        <div class="card border-0 shadow" style="background-color: #7e7e7e;">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers text-white">
                            <p class="text-sm mb-0 text-uppercase font-weight-bolder">Menunggu Validasi</p>
                            <h5 class="text-white" id="jumlah-revisi">
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

<div class="row mt-4">
    <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card">
            <div class="card-header pb-0 p-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0">DAFTAR DOKUMEN KRITERIA</h6>
                <select class="form-select w-auto" style="border-radius: 20px;">
                    <option selected>Filter ...</option>
                    <option value="terpenuhi">Terpenuhi</option>
                    <option value="belum">Belum Terpenuhi</option>
                </select>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Dokumen</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                        <tbody>
                            @foreach ($data as $i => $item)
                                <tr>
                                    <td class="text-center">{{ $i + 1 }}</td>
                                    <td class="text">{{ $item['dokumen'] }}</td>
                                    <td class="text-center">
                                        <span class="badge {{ $item['status'] === 'Terpenuhi' ? 'bg-success' : 'bg-warning text-dark' }}">
                                            {{ $item['status'] }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ url('/' . strtolower($roleKode)) }}" class="btn btn-sm btn-primary">Lihat</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection