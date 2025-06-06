<!-- Sidebar -->
<div class="user-panel d-flex align-items-center px-3 py-3" style="border-bottom: 1px solid #d1d5db;">
    <a href="{{ route('profil.index') }}" class="d-flex align-items-center text-dark text-decoration-none">
        @php
            $userId = Auth::id();
            $userImagePath = 'storage/foto_profil/user_' . $userId . '.jpg';
            $defaultImage = 'storage/foto_profil/user_.jpg';
            $imagePath = file_exists(public_path($userImagePath)) ? asset($userImagePath) : asset($defaultImage);

            $user = Auth::user();
            $fullName = $user->name ?? ($user->nama ?? ($user->full_name ?? ($user->username ?? 'Guest')));
            $nameParts = explode(' ', trim($fullName));

            if (count($nameParts) <= 2) {
                $displayName = $fullName;
            } else {
                $firstName = $nameParts[0];
                $lastInitial = strtoupper(substr(end($nameParts), 0, 1));
                $displayName = $firstName . ' ' . $lastInitial . '.';
            }
        @endphp
        <img id="sidebar-foto-profil" src="{{ $imagePath }}" class="rounded-circle" alt="User Image"
            style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #d1d5db;">
        <span id="sidebar-nama-user" class="ms-2 fw-semibold text-dark" title="{{ $fullName }}">
            {{ $displayName }}
        </span>
    </a>
</div>
{{-- @if(role == mahasiswa)
<div class="user-panel d-flex align-items-center px-3 py-3" style="border-bottom: 1px solid #d1d5db;">
    <a href="{{ route('profil.index') }}" class="d-flex align-items-center text-dark text-decoration-none">
        @php
            $userId = Auth::id();
            $userImagePath = 'storage/foto_profil/user_' . $userId . '.jpg';
            $defaultImage = 'storage/foto_profil/user_.jpg';
            $imagePath = file_exists(public_path($userImagePath)) ? asset($userImagePath) : asset($defaultImage);

            $user = Auth::user();
            $fullName = $user->name ?? ($user->nama ?? ($user->full_name ?? ($user->username ?? 'Guest')));
            $nameParts = explode(' ', trim($fullName));

            if (count($nameParts) <= 2) {
                $displayName = $fullName;
            } else {
                $firstName = $nameParts[0];
                $lastInitial = strtoupper(substr(end($nameParts), 0, 1));
                $displayName = $firstName . ' ' . $lastInitial . '.';
            }
        @endphp
        <img id="sidebar-foto-profil" src="{{ $imagePath }}" class="rounded-circle" alt="User Image"
            style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #d1d5db;">
        <span id="sidebar-nama-user" class="ms-2 fw-semibold text-dark" title="{{ $fullName }}">
            {{ $displayName }}
        </span>
    </a>
</div>
@elseif(role == admin)
    <div class="user-panel d-flex align-items-center px-3 py-3" style="border-bottom: 1px solid #d1d5db;">
    <a href="{{ route('profilAdmin.index') }}" class="d-flex align-items-center text-dark text-decoration-none">
        @php
            $userId = Auth::id();
            $userImagePath = 'storage/foto_profil/user_' . $userId . '.jpg';
            $defaultImage = 'storage/foto_profil/user_.jpg';
            $imagePath = file_exists(public_path($userImagePath)) ? asset($userImagePath) : asset($defaultImage);

            $user = Auth::user();
            $fullName = $user->name ?? ($user->nama ?? ($user->full_name ?? ($user->username ?? 'Guest')));
            $nameParts = explode(' ', trim($fullName));

            if (count($nameParts) <= 2) {
                $displayName = $fullName;
            } else {
                $firstName = $nameParts[0];
                $lastInitial = strtoupper(substr(end($nameParts), 0, 1));
                $displayName = $firstName . ' ' . $lastInitial . '.';
            }
        @endphp
        <img id="sidebar-foto-profil" src="{{ $imagePath }}" class="rounded-circle" alt="User Image"
            style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #d1d5db;">
        <span id="sidebar-nama-user" class="ms-2 fw-semibold text-dark" title="{{ $fullName }}">
            {{ $displayName }}
        </span>
    </a>
</div>
@elseif(role == dosen)
<div class="user-panel d-flex align-items-center px-3 py-3" style="border-bottom: 1px solid #d1d5db;">
    <a href="{{ route('profilDosen.index') }}" class="d-flex align-items-center text-dark text-decoration-none">
        @php
            $userId = Auth::id();
            $userImagePath = 'storage/foto_profil/user_' . $userId . '.jpg';
            $defaultImage = 'storage/foto_profil/user_.jpg';
            $imagePath = file_exists(public_path($userImagePath)) ? asset($userImagePath) : asset($defaultImage);

            $user = Auth::user();
            $fullName = $user->name ?? ($user->nama ?? ($user->full_name ?? ($user->username ?? 'Guest')));
            $nameParts = explode(' ', trim($fullName));

            if (count($nameParts) <= 2) {
                $displayName = $fullName;
            } else {
                $firstName = $nameParts[0];
                $lastInitial = strtoupper(substr(end($nameParts), 0, 1));
                $displayName = $firstName . ' ' . $lastInitial . '.';
            }
        @endphp
        <img id="sidebar-foto-profil" src="{{ $imagePath }}" class="rounded-circle" alt="User Image"
            style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #d1d5db;">
        <span id="sidebar-nama-user" class="ms-2 fw-semibold text-dark" title="{{ $fullName }}">
            {{ $displayName }}
        </span>
    </a>
</div>
@endif --}}
<!-- Menu Items -->
<ul class="menu-inner">
    <!-- Dashboard Admin -->
    <li class="menu-item {{ Request::is('admin/dashboard') ? 'active open' : '' }}">
        <a href="{{ url('/admin/dashboard') }}" class="menu-link d-flex align-items-center">
            <i class="bi bi-house-door menu-icon fs-5"></i>
            <div class="text-truncate" data-i18n="Dashboard">Dashboard Admin</div>
        </a>
    </li>

    <!-- Dashboard Dospem -->
    <li class="menu-item {{ Request::is('dospem/dashboard') ? 'active open' : '' }}">
        <a href="{{ url('/dospem/dashboard') }}" class="menu-link d-flex align-items-center">
            <i class="bi bi-house-door menu-icon fs-5"></i>
            <div class="text-truncate" data-i18n="Dashboard">Dashboard Dosen</div>
        </a>
    </li>

    <!-- Dashboard Mahasiswa -->
    <li class="menu-item {{ Request::is('mahasiswa/dashboard') ? 'active open' : '' }}">
        <a href="{{ url('/mahasiswa/dashboard') }}" class="menu-link d-flex align-items-center">
            <i class="bi bi-house-door menu-icon fs-5"></i>
            <div class="text-truncate" data-i18n="Dashboard">Dashboard Mahasiswa</div>
        </a>
    </li>

    

    <!-- Unggah Prestasi -->
    <li class="menu-item {{ Request::is('prestasi') ? 'active open' : '' }}">
        <a href="{{ url('/prestasi') }}" class="menu-link d-flex align-items-center">
            <i class="bi bi-file-earmark-text menu-icon fs-5"></i>
            <div class="text-truncate" data-i18n="ManajemenLomba">Unggah Prestasi</div>
        </a>
    </li>

    <!-- Manajemen Lomba -->
    <li class="menu-item {{ Request::is('lomba*') ? 'active open' : '' }}">
        <a href="{{ url('/lomba') }}" class="menu-link d-flex align-items-center">
            <i class="bi bi-trophy menu-icon fs-5"></i>
            <div class="text-truncate" data-i18n="ManajemenLomba">Manajemen Lomba</div>
        </a>
    </li>

    <!-- Manajemen Pengguna -->
    <li class="menu-item {{ Request::is('user*') ? 'active open' : '' }}">
        <a href="{{ url('/user') }}" class="menu-link d-flex align-items-center">
            <i class="bi bi-person-gear menu-icon fs-5"></i>
            <span class="text-truncate" data-i18n="ManajemenPengguna">Manajemen Pengguna</span>
        </a>
    </li>

    <!-- Manajemen Periode/Angkatan -->
    <li class="menu-item {{ Request::is('periode*') ? 'active open' : '' }}">
        <a href="{{ url('/periode') }}" class="menu-link d-flex align-items-center">
            <i class="bi bi-calendar2-week menu-icon fs-5"></i>
            <span class="text-truncate" data-i18n="ManajemenProdi">Manajemen Periode</span>
        </a>
    </li>

    <!-- Manajemen Prodi -->
    <li class="menu-item {{ Request::is('admin*') ? 'active open' : '' }}">
        <a href="{{ url('/admin/ManajemenProdi') }}" class="menu-link d-flex align-items-center">
            <i class="bi bi-diagram-3 menu-icon fs-5"></i>
            <div class="text-truncate" data-i18n="ManajemenProdi">Manajemen Prodi</div>
        </a>
    </li>

    <!-- Verifikasi Prestasi -->
    <li class="menu-item {{ Request::is('prestasiAdmin*') ? 'active open' : '' }}">
        <a href="{{ url('/prestasiAdmin') }}" class="menu-link d-flex align-items-center">
            <i class="bi bi-patch-check menu-icon fs-5"></i>
            <div class="text-truncate" data-i18n="VerifikasiPrestasi">Verifikasi Prestasi</div>
        </a>
    </li>

    <!-- Verifikasi Info Lomba -->
    <li class="menu-item {{ Request::is('admin/verifikasilomba*') ? 'active open' : '' }}">
        <a href="{{ url('admin/verifikasilomba') }}" class="menu-link d-flex align-items-center">
            <i class="bi bi-file-earmark-check menu-icon fs-5"></i>
            <div class="text-truncate" data-i18n="VerifikasiLomba">Verifikasi Info Lomba</div>
        </a>
    </li>

    <!-- Spacer supaya tombol logout di bawah -->
    <li style="flex-grow: 1;"></li>

    <!-- Logout -->
    <li class="menu-item">
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <button type="button" class="menu-link text-dark logout-btn" onclick="confirmLogout()"
            style="border: none; background: none; width: 100%; text-align: left; padding: 10px 16px; border-radius: 8px; cursor: pointer;">
            <i class="bi bi-box-arrow-right menu-icon fs-5 me-2"></i>
            <div class="text-truncate">Logout</div>
        </button>
    </li>
</ul>

<!-- Custom Sidebar Style -->
<style>
    .menu-inner {
        display: flex;
        flex-direction: column;
        height: calc(100vh - 68px);
        /* Sesuaikan tinggi agar penuh setelah profil */
        padding-top: 0.25rem;
        margin: 0;
    }

    .menu-inner a.menu-link,
    .menu-inner button.menu-link {
        padding: 10px 16px;
        border-radius: 8px;
        transition: background-color 0.2s ease, color 0.2s ease;
        color: #1f2937;
        display: flex;
        align-items: center;
        text-decoration: none;
    }

    .menu-inner a.menu-link:hover,
    .menu-inner button.menu-link:hover {
        background-color: #2b3ea0 !important;
        color: #ffffff !important;
    }

    .menu-item.active>a.menu-link {
        background-color: #2b3ea0 !important;
        color: #ffffff !important;
        font-weight: 600;
    }

    .menu-icon {
        color: inherit;
    }

    .menu-inner li {
        list-style: none;
    }

    .user-panel {
        margin: 0;
        padding: 12px 16px;
        background-color: #fff;
    }

    .menu-item form button.logout-btn:hover {
        background-color: #dc2626 !important;
        /* merah */
        color: #ffffff !important;
    }
</style>

<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Yakin ingin logout?',
            text: "Anda akan keluar dari sesi saat ini.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Logout',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>