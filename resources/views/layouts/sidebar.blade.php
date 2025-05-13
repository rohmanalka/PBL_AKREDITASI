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
                        <span class="nav-link-text ms-1">Dashboard</span>
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
                            <span class="nav-link-text">Kelola User</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('/superadmin/role') }}"
                            class="nav-link {{ $activeMenu == 'suprole' ? 'active' : '' }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fas fa-user-cog text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Kelola Role</span>
                        </a>
                    </li>
                @endauth

                {{-- Jika yang login adalah user biasa --}}
                @auth('web')
                    <li class="nav-item">
                        <a class="nav-link {{ $activeMenu == 'kriteria' ? '' : 'collapsed' }}" data-bs-toggle="collapse"
                            href="#kriteriaMenu" role="button"
                            aria-expanded="{{ $activeMenu == 'kriteria' ? 'true' : 'false' }}" aria-controls="kriteriaMenu">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fas fa-folder-open text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Kriteria</span>
                        </a>
                        <div class="collapse {{ $activeMenu == 'kriteria' ? 'show' : '' }}" id="kriteriaMenu">
                            <ul class="nav ms-4 ps-3">
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeSubmenu == 'kriteria1' ? 'active' : '' }}"
                                        href="{{ url('/kriteria1') }}">
                                        <span class="sidenav-normal">Kriteria 1</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeSubmenu == 'kriteria2' ? 'active' : '' }}"
                                        href="{{ url('/kriteria2') }}">
                                        <span class="sidenav-normal">Kriteria 2</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeSubmenu == 'kriteria3' ? 'active' : '' }}"
                                        href="{{ url('/kriteria3') }}">
                                        <span class="sidenav-normal">Kriteria 3</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeSubmenu == 'kriteria4' ? 'active' : '' }}"
                                        href="{{ url('/kriteria4') }}">
                                        <span class="sidenav-normal">Kriteria 4</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeSubmenu == 'kriteria5' ? 'active' : '' }}"
                                        href="{{ url('/kriteria5') }}">
                                        <span class="sidenav-normal">Kriteria 5</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeSubmenu == 'kriteria6' ? 'active' : '' }}"
                                        href="{{ url('/kriteria6') }}">
                                        <span class="sidenav-normal">Kriteria 6</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeSubmenu == 'kriteria7' ? 'active' : '' }}"
                                        href="{{ url('/kriteria7') }}">
                                        <span class="sidenav-normal">Kriteria 7</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeSubmenu == 'kriteria8' ? 'active' : '' }}"
                                        href="{{ url('/kriteria8') }}">
                                        <span class="sidenav-normal">Kriteria 8</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeSubmenu == 'kriteria9' ? 'active' : '' }}"
                                        href="{{ url('/kriteria9') }}">
                                        <span class="sidenav-normal">Kriteria 9</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
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
                        <span class="nav-link-text ms-1">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

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
