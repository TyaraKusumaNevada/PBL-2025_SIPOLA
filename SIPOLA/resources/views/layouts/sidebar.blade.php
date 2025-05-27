<!-- Sidebar -->
<div class="user-panel d-flex align-items-center px-3 py-3" style="border-bottom: 1px solid #d1d5db;">
  <a href="{{ route('profil.index') }}" class="d-flex align-items-center text-dark text-decoration-none">
    @php
      $userId = Auth::id();
      $userImagePath = 'storage/foto_profil/user_' . $userId . '.jpg';
      $defaultImage = 'storage/foto_profil/user_.jpg';
      $imagePath = file_exists(public_path($userImagePath)) ? asset($userImagePath) : asset($defaultImage);

      $user = Auth::user();
      $fullName = $user->name ?? $user->nama ?? $user->full_name ?? $user->username ?? 'Guest';
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

  <!-- Dashboard Admin -->
  <li class="menu-item {{ Request::is('admin/dashboard') ? 'active open' : '' }}">
    <a href="{{ url('/admin/dashboard') }}" class="menu-link d-flex align-items-center">
      <i class="bi bi-house-door menu-icon fs-5"></i>
      <div class="text-truncate" data-i18n="Dashboard">Dashboard</div>
    </a>
  </li>

  <!-- Dashboard Dospem -->
  <li class="menu-item {{ Request::is('dospem/dashboard') ? 'active open' : '' }}">
    <a href="{{ url('/dospem/dashboard') }}" class="menu-link d-flex align-items-center">
      <i class="bi bi-house-door menu-icon fs-5"></i>
      <div class="text-truncate" data-i18n="Dashboard">Dashboard</div>
    </a>
  </li>

  <!-- Dashboard Mahasiswa -->
  <li class="menu-item {{ Request::is('mahasiswa/dashboard') ? 'active open' : '' }}">
    <a href="{{ url('/mahasiswa/dashboard') }}" class="menu-link d-flex align-items-center">
      <i class="bi bi-house-door menu-icon fs-5"></i>
      <div class="text-truncate" data-i18n="Dashboard">Dashboard</div>
    </a>
  </li>

  <!-- Profil Admin -->
  <li class="menu-item {{ Request::is('admin/profil') ? 'active open' : '' }}">
    <a href="{{ url('/admin/profil') }}" class="menu-link d-flex align-items-center">
      <i class="bi bi-person-circle menu-icon fs-5"></i>
      <div class="text-truncate" data-i18n="AdminProfil">Profil</div>
    </a>
  </li>

  <!-- Profil Dospem -->
  <li class="menu-item {{ Request::is('dospem/profil') ? 'active open' : '' }}">
    <a href="{{ url('/dospem/profil') }}" class="menu-link d-flex align-items-center">
      <i class="bi bi-person-circle menu-icon fs-5"></i>
      <div class="text-truncate" data-i18n="DospemProfil">Profil</div>
    </a>
  </li>

  <!-- Profil Mahasiswa -->
  <li class="menu-item {{ Request::is('mahasiswa/profil') ? 'active open' : '' }}">
    <a href="{{ url('/mahasiswa/profil') }}" class="menu-link d-flex align-items-center">
      <i class="bi bi-person-circle menu-icon fs-5"></i>
      <div class="text-truncate" data-i18n="MahasiswaProfil">Profil</div>
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
  <li class="menu-item {{ Request::is('admin/verifikasiprestasi*') ? 'active open' : '' }}">
    <a href="{{ url('admin/verifikasi') }}" class="menu-link d-flex align-items-center">
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
  
  <!-- Memberikan jarak, agar logout di bawah -->
  <div style="flex-grow: 1;"></div>

  {{-- Logout --}}
  <li class="menu-item">
    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
      @csrf
      <button type="submit" class="menu-link text-dark logout-btn"
        style="border: none; background: none; width: 100%; text-align: left; padding: 10px 16px; border-radius: 8px; cursor: pointer;">
        <i class="bi bi-box-arrow-right menu-icon fs-5 me-2"></i>
        <div class="text-truncate">Logout</div>
      </button>
    </form>
  </li>
</ul>

<!-- Custom Sidebar Style -->
<style>
  .menu-inner {
    display: flex;
    flex-direction: column;
    height: calc(100vh - 68px); /* disesuaikan agar penuh setelah profil */
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

  .menu-item.active > a.menu-link {
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
    background-color: #dc2626 !important; /* merah */
    color: #ffffff !important;
  }
</style>
