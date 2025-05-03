<!-- Menu -->
<div class="menu-divider mt-0"></div>

<div class="menu-inner-shadow"></div>

<ul class="menu-inner py-1">
  <!-- ManajemenProfil -->
  <li class="menu-item {{ Request::is('mahasiswa/profil') ? 'active open' : '' }}">
    <a href="{{ url('/mahasiswa/profil') }}" class="menu-link">
      <i class="menu-icon tf-icons bx bx-user"></i>
      <div class="text-truncate" data-i18n="ManajemenProfil">Manajemen Profil</div>
    </a>
  </li>

  <!-- TambahPrestasi -->
  <li class="menu-item {{ Request::is('mahasiswa/prestasi*') ? 'active open' : '' }}">
    <a href="{{ url('/mahasiswa/prestasi') }}" class="menu-link">
      <i class="menu-icon tf-icons bx bx-medal"></i>
      <div class="text-truncate" data-i18n="TambahPrestasi">Tambah Prestasi</div>
    </a>
  </li>

  <!-- ListLomba -->
  <li class="menu-item {{ Request::is('mahasiswa/lomba') ? 'active open' : '' }}">
    <a href="{{ url('/mahasiswa/lomba') }}" class="menu-link">
      <i class="menu-icon tf-icons bx bx-trophy"></i>
      <div class="text-truncate" data-i18n="ListLomba">List Lomba</div>
    </a>
  </li>

  <div style="flex-grow: 1;"></div>

  <li class="menu-item">
    <a href="#" class="menu-link">
      <i class="menu-icon tf-icons bx bx-log-out"></i>
      <div class="text-truncate" data-i18n="Misc">Logout</div>
    </a>
  </li>
</ul>
<!-- / Menu -->