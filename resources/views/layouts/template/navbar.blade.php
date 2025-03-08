<!-- filepath: /c:/laragon/www/pengajuan-cuti/resources/views/layouts/nav.blade.php -->
@if(!request()->routeIs('karyawan.profile'))
<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

        <a href="#" class="logo d-flex align-items-center me-auto me-xl-0">
            <h1 class="sitename">Sistem Cuti</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                @if(auth()->user()->isAdmin())
                <li><a href="{{ route('admin.dashboard') }}" class="{{ Request::is('admin/dashboard', 'admin/cuti/*', 'admin/cuti',) ? 'active' : '' }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.karyawan.index') }}" class="{{ Request::is('admin/karyawan', 'admin/karyawan/*') ? 'active' : '' }}">Karyawan</a></li>
                    <li><a href="{{ route('admin.jabatan.index') }}" class="{{ Request::is('admin/jabatan') ? 'active' : '' }}">Jabatan</a></li>
                    <li><a href="{{ route('admin.calendar') }}" class="{{ Request::is('admin/admin/calendar') ? 'active' : '' }}">Kalender</a></li>
                @else
                    <li><a href="{{ route('karyawan.dashboard') }}" class="{{ Request::is('karyawan/dashboard', 'cuti/view/*') ? 'active' : '' }}">Dashboard</a></li>
                    <li><a href="{{ route('cuti.create') }}" class="{{ Request::is('cuti/create') ? 'active' : '' }}">Ajukan Cuti</a></li>
                    <li><a href="{{ route('karyawan.calendar') }}" class="{{ Request::is('karyawan/calendar') ? 'active' : '' }}">Kalender</a></li>
                @endif
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <!-- Update the dropdown button section -->
        <div class="nav-account">
            <div class="dropdown">
                <button class="btn-getstarted dropdown-toggle d-flex align-items-center" 
                        type="button" 
                        id="accountDropdown">
                    <i class="bi bi-person-circle me-2"></i>
                    <span>{{ auth()->user()->nama_karyawan ?? auth()->user()->email }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="accountDropdown">
                    <li>
                        <a class="dropdown-item" href="{{ route('karyawan.profile') }}">
                            <i class="bi bi-person"></i> Profile
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
@endif