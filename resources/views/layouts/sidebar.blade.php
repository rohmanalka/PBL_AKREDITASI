<aside class="sidenav bg-default navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/argon-dashboard/pages/dashboard.html "
            target="_blank">
            <img src="{{ asset('argon/assets/img/logo-ct-dark.png') }}" width="26px" height="26px"
                class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">AKSIB</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="d-flex flex-column h-100">
        <div class="flex-grow-1 overflow-auto">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ url('/index') }}" class="nav-link {{ $activeMenu == 'dashboard' ? 'active' : '' }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-home text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">{{ __('sidebar.sidedash') }}</span>
                    </a>
                </li>

                {{-- Jika yang login adalah superadmin --}}
                @auth('superadmin')
                    <li class="nav-item">
                        <a href="{{ url('/superadmin/user') }}"
                            class="nav-link {{ $activeMenu == 'supuser' ? 'active' : '' }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fas fa-user-plus text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text">{{ __('sidebar.sideuser') }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('/superadmin/role') }}"
                            class="nav-link {{ $activeMenu == 'suprole' ? 'active' : '' }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fas fa-user-cog text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">{{ __('sidebar.siderole') }}</span>
                        </a>
                    </li>
                @endauth

                {{-- Jika yang login adalah user biasa --}}
                @auth('web')
                    @php
                        $user = auth('web')->user();
                        $roleKode = $user?->role?->role_kode ?? null;
                    @endphp
                    @if (!in_array($roleKode, ['KPSKJR', 'DIRKJM', 'USERSPI']))
                        @switch($roleKode)
                            @case('KRIT1')
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeMenu == 'input1' ? 'active' : '' }}"
                                        href="{{ url('kriteria1/input') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-pen-to-square text-sm opacity-10"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Input Kriteria 1</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeMenu == 'riwayat1' ? 'active' : '' }}"
                                        href="{{ url('/kriteria1') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-folder-open text-sm opacity-10"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Riwayat Kriteria 1</span>
                                    </a>
                                </li>
                            @break

                            @case('KRIT2')
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeMenu == 'input2' ? 'active' : '' }}"
                                        href="{{ url('kriteria2/input') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-pen-to-square text-sm opacity-10"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Input Kriteria 2</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeMenu == 'riwayat2' ? 'active' : '' }}"
                                        href="{{ url('/kriteria2') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-folder-open text-sm opacity-10"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Riwayat Kriteria 2</span>
                                    </a>
                                </li>
                            @break

                            @case('KRIT3')
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeMenu == 'input3' ? 'active' : '' }}"
                                        href="{{ url('kriteria3/input') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-pen-to-square text-sm opacity-10"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Input Kriteria 3</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeMenu == 'riwayat3' ? 'active' : '' }}"
                                        href="{{ url('/kriteria3') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-folder-open text-sm opacity-10"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Riwayat Kriteria 3</span>
                                    </a>
                                </li>
                            @break

                            @case('KRIT4')
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeMenu == 'input4' ? 'active' : '' }}"
                                        href="{{ url('kriteria4/input') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-pen-to-square text-sm opacity-10"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Input Kriteria 4</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeMenu == 'riwayat4' ? 'active' : '' }}"
                                        href="{{ url('/kriteria4') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-folder-open text-sm opacity-10"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Riwayat Kriteria 4</span>
                                    </a>
                                </li>
                            @break

                            @case('KRIT5')
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeMenu == 'input5' ? 'active' : '' }}"
                                        href="{{ url('kriteria5/input') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-pen-to-square text-sm opacity-10"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Input Kriteria 5</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeMenu == 'riwayat5' ? 'active' : '' }}"
                                        href="{{ url('/kriteria5') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-folder-open text-sm opacity-10"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Riwayat Kriteria 5</span>
                                    </a>
                                </li>
                            @break

                            @case('KRIT6')
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeMenu == 'input6' ? 'active' : '' }}"
                                        href="{{ url('kriteria6/input') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-pen-to-square text-sm opacity-10"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Input Kriteria 6</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeMenu == 'riwayat6' ? 'active' : '' }}"
                                        href="{{ url('/kriteria6') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-folder-open text-sm opacity-10"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Riwayat Kriteria 6</span>
                                    </a>
                                </li>
                            @break

                            @case('KRIT7')
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeMenu == 'input7' ? 'active' : '' }}"
                                        href="{{ url('kriteria7/input') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-pen-to-square text-sm opacity-10"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Input Kriteria 7</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeMenu == 'riwayat7' ? 'active' : '' }}"
                                        href="{{ url('/kriteria7') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-folder-open text-sm opacity-10"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Riwayat Kriteria 7</span>
                                    </a>
                                </li>
                            @break

                            @case('KRIT8')
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeMenu == 'input8' ? 'active' : '' }}"
                                        href="{{ url('kriteria8/input') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-pen-to-square text-sm opacity-10"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Input Kriteria 8</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeMenu == 'riwayat8' ? 'active' : '' }}"
                                        href="{{ url('/kriteria8') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-folder-open text-sm opacity-10"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Riwayat Kriteria 8</span>
                                    </a>
                                </li>
                            @break

                            @case('KRIT9')
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeMenu == 'input9' ? 'active' : '' }}"
                                        href="{{ url('kriteria9/input') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-pen-to-square text-sm opacity-10"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Input Kriteria 9</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeMenu == 'riwayat9' ? 'active' : '' }}"
                                        href="{{ url('/kriteria9') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-folder-open text-sm opacity-10"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Riwayat Kriteria 9</span>
                                    </a>
                                </li>
                            @break
                        @endswitch
                    @endif
                    {{-- Khusus untuk kpskajur atau direktur --}}
                    @php
                        $user = auth('web')->user();
                        $roleKode = $user?->role?->role_kode ?? null;
                    @endphp

                    @if (in_array($roleKode, ['KPSKJR', 'DIRKJM']))
                        <li class="nav-item">
                            <a href="{{ $roleKode === 'KPSKJR' ? url('/validasi-kpskjr') : url('/validasi-dir') }}"
                                class="nav-link {{ $activeMenu == 'validasi' ? 'active' : '' }}">
                                <div
                                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-chart-bar text-sm opacity-10"></i>
                                </div>
                                <span class="nav-link-text ms-1">{{ __('sidebar.sidevalid') }}</span>
                            </a>
                        </li>
                    @endif

                    @php
                        $user = auth('web')->user();
                        $roleKode = $user?->role?->role_kode ?? null;
                    @endphp

                    @if (in_array($roleKode, ['USERSPI']))
                        <li class="nav-item">
                            <a href="{{ url('/preview') }}"
                                class="nav-link {{ $activeMenu == 'preview' ? 'active' : '' }}">
                                <div
                                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-chart-bar text-sm opacity-10"></i>
                                </div>
                                <span class="nav-link-text ms-1">Preview</span>
                            </a>
                        </li>
                    @endif
                @endauth

                <li class="nav-item mt-3">
                    <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" class="nav-link text-danger d-flex align-items-center" id="logout">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-button-power text-danger text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">{{ __('sidebar.logout') }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <style>
        .nav .nav-link.active::before {
            content: "";
            position: absolute;
            left: 0;
            top: 8px;
            bottom: 8px;
            width: 4px;
            background-color: #5e72e4;
            border-radius: 2px;
        }
    </style>

    <script>
        // Initialize PerfectScrollbar
        document.addEventListener('DOMContentLoaded', function() {
            // Fix PerfectScrollbar
            if (document.querySelector('#sidenav-scrollbar')) {
                var scrollbar = new PerfectScrollbar('#sidenav-scrollbar');
            }

            // Logout Confirmation
            document.getElementById('logout')?.addEventListener('click', function(event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda akan keluar dari sistem!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Logout!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('logout-form').submit();
                    }
                });
            });
        });
    </script>
</aside>
