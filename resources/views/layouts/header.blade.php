@php
    use App\Models\KomentarModel;
    use App\Models\DetailKriteriaModel;

    $roleKode = auth('web')->user()?->role?->role_kode ?? 'KRIT0';
    $idKriteria = (int) filter_var($roleKode, FILTER_SANITIZE_NUMBER_INT);

    $revisiKomentarQuery = KomentarModel::whereHas('details', function ($query) use ($idKriteria, $roleKode) {
        $query->where('status', 'revisi');

        if (str_starts_with($roleKode, 'KRIT')) {
            $query->where('id_kriteria', $idKriteria);
        }
    });
    //Notifikasi revisi sesuai penerima
    if (str_starts_with($roleKode, 'KRIT')) {
        // KRIT menerima dari KPSKJR dan DIRKJM
        $revisiKomentarQuery->whereIn('id_user', [10, 11]);
    } elseif ($roleKode === 'KPSKJR') {
        // KPSKJR menerima dari DIRKJM
        $revisiKomentarQuery->where('id_user', 11);
    } else {
        // Role lain tidak terima revisi
        $revisiKomentarQuery->whereRaw('0 = 1');
    }

    $revisiKomentar = $revisiKomentarQuery
        ->with([
            'user',
            'details' => function ($query) use ($idKriteria, $roleKode) {
                $query->where('status', 'revisi');
                if (str_starts_with($roleKode, 'KRIT')) {
                    $query->where('id_kriteria', $idKriteria);
                }
            },
        ])
        ->latest()
        ->take(5)
        ->get();

    $jumlahRevisi = $revisiKomentar->count();

    //kajur
    $isKajur = $roleKode === 'KPSKJR';
    $validasiKriteria = collect();
    if ($isKajur) {
        $validasiKriteria = DetailKriteriaModel::where('status', 'submitted')
            ->whereBetween('id_kriteria', [1, 9])
            ->latest()
            ->get()
            ->groupBy('id_kriteria')
            ->map(fn($items) => $items->first());
    }

    $jumlahValidasi = $validasiKriteria->count();

    //direktur
    $isDirkjm = $roleKode === 'DIRKJM';
    $pengisianSiapValidasi = collect();

    if ($isDirkjm) {
        $pengisianSiapValidasi = \App\Models\PengisianModel::whereHas('detail', function ($query) {
            $query->where('status', 'divalidasi_kajur');
        })
            ->withCount([
                'detail as jumlah_divalidasi_kajur' => function ($query) {
                    $query->where('status', 'divalidasi_kajur');
                },
            ])
            ->having('jumlah_divalidasi_kajur', '=', 1)
            ->get();
    }

@endphp

<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
    data-scroll="false">
    <div class="container-fluid py-1 px-3">
        @include('layouts.breadcrumb')
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center"></div>
            <ul class="navbar-nav justify-content-end">
                {{-- User Info --}}
                <li class="nav-item dropdown d-flex align-items-center">
                    <a href="#" class="nav-link text-white p-0" id="userDropdown" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa fa-user me-sm-1"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end px-2 py-2 me-sm-n4" aria-labelledby="userDropdown">
                        <li class="mb-2">
                            <span class="dropdown-item border-radius-md">
                                <div class="d-flex py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <span class="text-sm">
                                            Nama:
                                            <strong>{{ auth('web')->user()->name ?? 'Tidak diketahui' }}</strong>
                                        </span>
                                    </div>
                                </div>
                            </span>
                        </li>
                    </ul>
                </li>
                <li class="mx-2"></li>

                {{-- Bell Icon --}}
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="#" class="nav-link text-white p-0 position-relative" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell cursor-pointer"></i>
                        @if ($jumlahRevisi + $jumlahValidasi > 0)
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $jumlahRevisi + $jumlahValidasi }}
                            </span>
                        @endif
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                        {{-- Revisi --}}
                        <li class="px-3 text-sm text-bold mb-2">Revisi Baru</li>
                        @forelse($revisiKomentar as $komentar)
                            @php
                                $detail = $komentar->details
                                    ->where('status', 'revisi')
                                    ->where('id_kriteria', $idKriteria)
                                    ->first();
                                $url = $detail ? url("/kriteria{$idKriteria}") : '#';
                            @endphp
                            <li class="mb-2">
                                <a class="dropdown-item border-radius-md" href="{{ $url }}">
                                    <div class="d-flex py-1">
                                        <div class="avatar avatar-sm bg-gradient-warning me-3 my-auto">
                                            <i class="fa fa-exclamation text-white"></i>
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="text-sm font-weight-normal mb-1">
                                                Revisi dari <strong>{{ $komentar->user->name ?? 'Pengguna' }}</strong>
                                            </h6>
                                            <p class="text-xs text-secondary mb-0">
                                                <i class="fa fa-clock me-1"></i>
                                                {{ $komentar->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <li class="px-3 text-sm text-muted">Tidak ada revisi baru</li>
                        @endforelse

                        {{-- Validasi --}}
                        @if ($isKajur && $jumlahValidasi > 0)
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li class="px-3 text-sm text-bold mb-2">Butuh Validasi</li>
                            @foreach ($validasiKriteria as $id_kriteria => $detail)
                                @php
                                    $url = url("/kriteria{$id_kriteria}/{$detail->id_pengisian}/show");
                                @endphp
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="{{ $url }}">
                                        <div class="d-flex py-1">
                                            <div class="avatar avatar-sm bg-gradient-info me-3 my-auto">
                                                <i class="fa fa-check text-white"></i>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    Validasi Kriteria <strong>{{ $id_kriteria }}</strong>
                                                </h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fa fa-clock me-1"></i>
                                                    {{ $detail->updated_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                        @if ($isDirkjm)
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li class="px-3 text-sm text-bold mb-2">Validasi Final</li>
                            @foreach ($pengisianSiapValidasi as $pengisian)
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md"
                                        href="{{ url("/validasi/{$pengisian->id_pengisian}") }}">
                                        <div class="d-flex py-1">
                                            <div class="avatar avatar-sm bg-gradient-success me-3 my-auto">
                                                <i class="fa fa-clipboard-check text-white"></i>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    Pengisian: <strong>{{ $pengisian->nama_pengisian }}</strong>
                                                </h6>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
