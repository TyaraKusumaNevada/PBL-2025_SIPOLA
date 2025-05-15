<!-- Menu -->
<div class="menu-divider mt-0"></div>

<div class="menu-inner-shadow"></div>

<ul class="menu-inner py-1">

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