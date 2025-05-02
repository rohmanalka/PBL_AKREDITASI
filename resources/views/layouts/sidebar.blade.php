<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 bg-slate-900 fixed-start" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand d-flex align-items-center m-0"
            href="https://demos.creative-tim.com/corporate-ui-dashboard/pages/dashboard.html" target="_blank">
            <span class="font-weight-bold text-lg">Corporate UI</span>
        </a>
    </div>
    <div class="collapse navbar-collapse px-4 w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="{{ url('/index') }}" class="nav-link {{ $activeMenu == 'dashboard' ? 'active' : '' }}">
                    <div
                        class="icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-house fa-2x text-white"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $activeMenu == 'kriteria' ? '' : 'collapsed' }}" data-bs-toggle="collapse"
                    href="#kriteriaMenu" role="button"
                    aria-expanded="{{ $activeMenu == 'kriteria' ? 'true' : 'false' }}" aria-controls="kriteriaMenu">
                    <div
                        class="icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-folder fa-2x text-white"></i>
                    </div>
                    <span class="nav-link-text ms-1">Kriteria</span>
                </a>
                <div class="collapse {{ $activeMenu == 'kriteria' ? 'show' : '' }}" id="kriteriaMenu">
                    <ul class="nav ms-4">
                        <li class="nav-item">
                            <a href="{{ url('/') }}"
                                class="nav-link text-white{{ $activeSubmenu == 'kriteria1' ? 'active' : '' }}">
                                <span class="sidenav-normal">Kriteria 1</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/') }}"
                                class="nav-link text-white{{ $activeSubmenu == 'kriteria2' ? 'active' : '' }}">
                                <span class="sidenav-normal">Kriteria 2</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    <div class="sidenav-footer mx-4">
        <div class="card border-radius-md" id="sidenavCard">
            <div class="card-body text-start p-3 w-100">
                <div class="mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="text-danger"
                        viewBox="0 0 24 24" fill="currentColor" id="sidenavCardIcon">
                        <path d="M16 13v-2H7V8l-5 4 5 4v-3z" />
                        <path
                            d="M20 3H10c-1.1 0-2 .9-2 2v3h2V5h10v14H10v-3H8v3c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z" />
                    </svg>
                </div>
                <div class="docs-info">
                    <h6 class="font-weight-bold up mb-2">Logout</h6>
                    <p class="text-sm font-weight-normal">Keluar dari akun Anda.</p>
                    <a href="/logout" class="btn btn-danger w-100">
                        Logout
                        <i class="fas fa-sign-out-alt text-sm ms-1" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

</aside>
