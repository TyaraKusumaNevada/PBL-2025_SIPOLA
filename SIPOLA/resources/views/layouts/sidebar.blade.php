<!-- Menu -->
<div class="menu-divider mt-0"></div>

<div class="menu-inner-shadow"></div>

<ul class="menu-inner py-1">

 {{-- User Profile --}}
@php
    $userId = Auth::id();
    $userImagePath = 'storage/foto_profil/user_' . $userId . '.jpg';
    $defaultImage = 'storage/foto_profil/user_.jpg';
    $imagePath = file_exists(public_path($userImagePath)) ? asset($userImagePath) : asset($defaultImage);

    $fullName = Auth::user()->name ?? 'Guest';

    $nameParts = explode(' ', trim($fullName));
    $shortName = $nameParts[0];
    if (count($nameParts) > 1) {
        $shortName .= ' ' . strtoupper(substr($nameParts[1], 0, 1)) . '.';
    }
@endphp

<div class="user-panel d-flex align-items-center mb-3 px-3">
    <a href="{{ route('profil.index') }}" class="d-flex align-items-center text-white text-decoration-none">
        <img src="{{ $imagePath }}" class="rounded-circle" alt="User Image"
             style="width:40px; height:40px; object-fit:cover;">
        <span class="ms-2 text-dark" id="display-nama" title="{{ $fullName }}">{{ $shortName }}</span>
    </a>
</div>

<!-- Dashboard untuk setiap role -->
<li class="menu-item {{ Request::is('admin/dashboard') ? 'active open' : '' }}">
  <a href="{{ url('/admin/dashboard') }}" class="menu-link d-flex align-items-center">
    <i class="bi bi-house-door menu-icon fs-5"></i>
    <div class="text-truncate" data-i18n="Dashboard">Dashboard</div>
  </a>
</li>

<li class="menu-item {{ Request::is('dospem/dashboard') ? 'active open' : '' }}">
  <a href="{{ url('/dospem/dashboard') }}" class="menu-link d-flex align-items-center">
    <i class="bi bi-house-door menu-icon fs-5"></i>
    <div class="text-truncate" data-i18n="Dashboard">Dashboard</div>
  </a>
</li>

<li class="menu-item {{ Request::is('mahasiswa/dashboard') ? 'active open' : '' }}">
  <a href="{{ url('/mahasiswa/dashboard') }}" class="menu-link d-flex align-items-center">
    <i class="bi bi-house-door menu-icon fs-5"></i>
    <div class="text-truncate" data-i18n="Dashboard">Dashboard</div>
  </a>
</li>

<!-- Profil untuk setiap role -->
<li class="menu-item {{ Request::is('admin/profil') ? 'active open' : '' }}">
  <a href="{{ url('/admin/profil') }}" class="menu-link d-flex align-items-center">
    <i class="bi bi-person-circle menu-icon fs-5"></i>
    <div class="text-truncate" data-i18n="AdminProfil">Profil</div>
  </a>
</li>

<li class="menu-item {{ Request::is('dospem/profil') ? 'active open' : '' }}">
  <a href="{{ url('/dospem/profil') }}" class="menu-link d-flex align-items-center">
    <i class="bi bi-person-circle menu-icon fs-5"></i>
    <div class="text-truncate" data-i18n="DospemProfil">Profil</div>
  </a>
</li>

<li class="menu-item {{ Request::is('mahasiswa/profil') ? 'active open' : '' }}">
  <a href="{{ url('/mahasiswa/profil') }}" class="menu-link d-flex align-items-center">
    <i class="bi bi-person-circle menu-icon fs-5"></i>
    <div class="text-truncate" data-i18n="MahasiswaProfil">Profil</div>
  </a>
</li>

<!-- Menu khusus Admin -->
<li class="menu-item {{ Request::is('user*') ? 'active open' : '' }}">
  <a href="{{ url('/user') }}" class="menu-link">
    <i class="bi bi-people menu-icon"></i>
    <div class="text-truncate" data-i18n="ManajemenUser">Manajemen User</div>
  </a>
</li>

<li class="menu-item {{ Request::is('lomba*') ? 'active open' : '' }}">
  <a href="{{ url('/lomba') }}" class="menu-link">
    <i class="bi bi-trophy menu-icon"></i>
    <div class="text-truncate" data-i18n="ManajemenLomba">Manajemen Lomba</div>
  </a>
</li>

<li class="menu-item {{ Request::is('periode*') ? 'active open' : '' }}">
  <a href="{{ url('/periode') }}" class="menu-link d-flex align-items-center">
    <i class="bi bi-calendar2-week menu-icon fs-5"></i>
    <span class="text-truncate" data-i18n="ManajemenProdi">Manajemen Periode</span>
  </a>
</li>

<li class="menu-item {{ Request::is('admin/ManajemenProdi') ? 'active open' : '' }}">
  <a href="{{ url('/admin/ManajemenProdi') }}" class="menu-link d-flex align-items-center">
    <i class="bi bi-diagram-3 menu-icon fs-5"></i>
    <div class="text-truncate" data-i18n="ManajemenProdi">Manajemen Prodi</div>
  </a>
</li>

<li class="menu-item {{ Request::is('admin/verifikasiprestasi*') ? 'active open' : '' }}">
  <a href="{{ url('admin/verifikasi') }}" class="menu-link d-flex align-items-center">
    <i class="bi bi-patch-check menu-icon fs-5"></i>
    <div class="text-truncate" data-i18n="VerifikasiPrestasi">Verifikasi Prestasi</div>
  </a>
</li>

<li class="menu-item {{ Request::is('admin/verifikasilomba*') ? 'active open' : '' }}">
  <a href="{{ url('admin/verifikasilomba') }}" class="menu-link d-flex align-items-center">
    <i class="bi bi-file-earmark-check menu-icon fs-5"></i>
    <div class="text-truncate" data-i18n="VerifikasiLomba">Verifikasi Info Lomba</div>
  </a>
</li>

<!-- Spacer agar logout di bawah -->
<div style="flex-grow: 1;"></div>

<!-- Logout -->
<li class="menu-item">
  <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
    @csrf
    <button type="submit" class="menu-link" style="border: none; background: none; width: 100%; text-align: left;">
      <i class="bi bi-box-arrow-right menu-icon fs-5"></i>
      <div class="text-truncate" data-i18n="Misc">Logout</div>
    </button>
  </form>
</li>

</ul>
<!-- / Menu -->
