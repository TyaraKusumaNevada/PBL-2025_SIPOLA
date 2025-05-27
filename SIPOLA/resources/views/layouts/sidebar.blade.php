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

<!-- Menu -->
<ul class="menu-inner" style="background-color: #ffffff; color: #1f2937; border-right: 1px solid #d1d5db;">

  {{-- Menu Items --}}
  @php
    $menus = [
      ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'url' => '/admin/dashboard', 'check' => 'admin/dashboard'],
      ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'url' => '/dospem/dashboard', 'check' => 'dospem/dashboard'],
      ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'url' => '/mahasiswa/dashboard', 'check' => 'mahasiswa/dashboard'],
      ['label' => 'Profil', 'icon' => 'bi-person-circle', 'url' => '/admin/profil', 'check' => 'admin/profil'],
      ['label' => 'Profil', 'icon' => 'bi-person-circle', 'url' => '/dospem/profil', 'check' => 'dospem/profil'],
      ['label' => 'Profil', 'icon' => 'bi-person-circle', 'url' => '/mahasiswa/profil', 'check' => 'mahasiswa/profil'],
      ['label' => 'Manajemen Lomba', 'icon' => 'bi-trophy', 'url' => '/lomba', 'check' => 'lomba*'],
      ['label' => 'Manajemen Pengguna', 'icon' => 'bi-person-gear', 'url' => '/user', 'check' => 'user*'],
      ['label' => 'Manajemen Periode', 'icon' => 'bi-calendar2-week', 'url' => '/periode', 'check' => 'periode*'],
      ['label' => 'Manajemen Prodi', 'icon' => 'bi-diagram-3', 'url' => '/admin/ManajemenProdi', 'check' => 'admin*'],
      ['label' => 'Verifikasi Prestasi', 'icon' => 'bi-patch-check', 'url' => '/admin/verifikasi', 'check' => 'admin/verifikasiprestasi*'],
      ['label' => 'Verifikasi Info Lomba', 'icon' => 'bi-file-earmark-check', 'url' => '/admin/verifikasilomba', 'check' => 'admin/verifikasilomba*'],
    ];
  @endphp

  @foreach ($menus as $menu)
    <li class="menu-item {{ Request::is($menu['check']) ? 'active open' : '' }}">
      <a href="{{ url($menu['url']) }}" class="menu-link d-flex align-items-center text-dark">
        <i class="bi {{ $menu['icon'] }} menu-icon fs-5 me-2"></i>
        <div class="text-truncate">{{ $menu['label'] }}</div>
      </a>
    </li>
  @endforeach

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
