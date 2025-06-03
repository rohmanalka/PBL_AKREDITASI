@php
    use App\Models\KomentarModel;
    use Illuminate\Support\Str;

    $komentarBaru = KomentarModel::latest()->take(10)->get(); // ambil 10 komentar terbaru
    $jumlahKomentar = $komentarBaru->count();
@endphp

<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur"
    data-scroll="false">
    <div class="container-fluid py-1 px-3">
        @include('layouts.breadcrumb')
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            </div>
            <ul class="navbar-nav justify-content-end">
                {{-- User Info Dropdown --}}
                <li class="nav-item dropdown d-flex align-items-center">
                    <a href="#" class="nav-link text-white p-0" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-user me-sm-1"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end px-2 py-2 me-sm-n4" aria-labelledby="userDropdown">
                        <li class="mb-2">
                            <span class="dropdown-item border-radius-md">
                                <div class="d-flex py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <span class="text-sm">
                                            Login sebagai:
                                            <strong>
                                                @if(session('id_kriteria'))
                                                    Kriteria {{ session('id_kriteria') }}
                                                @else
                                                    Tidak diketahui
                                                @endif
                                            </strong>
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
                    <a href="javascript:;" class="nav-link text-white p-0 position-relative" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell cursor-pointer"></i>
                        @if($jumlahKomentar > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $jumlahKomentar }}
                            </span>
                        @endif
                    </a>

                    {{-- Dropdown Notifikasi Komentar --}}
                    <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4"
                        aria-labelledby="dropdownMenuButton">
                        <li class="px-3 text-sm text-bold mb-2">
                            Komentar Baru
                        </li>
                        @forelse($komentarBaru as $komentar)
                            <li class="mb-2">
                                <a class="dropdown-item border-radius-md" href="javascript:;">
                                    <div class="d-flex py-1">
                                        <div class="my-auto">
                                            <i class="fa fa-comment text-primary me-3"></i>
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="text-sm font-weight-normal mb-1">
                                                {{ Str::limit($komentar->komentar, 40) }}
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
                            <li class="px-3 text-sm text-muted">Tidak ada komentar baru</li>
                        @endforelse
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
