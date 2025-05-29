<!-- Menu -->
<div class="menu-divider mt-0"></div>


<div class="menu-inner-shadow"></div>


<ul class="menu-inner py-1">
{{-- User Profile --}}
<div class="user-panel d-flex align-items-center mb-3 px-3">
    <a href="{{ route('profil.index') }}" class="d-flex align-items-center text-white text-decoration-none">
        @php
            $userId = Auth::id();
            $userImagePath = 'storage/foto_profil/user_' . $userId . '.jpg';
            $defaultImage = 'storage/foto_profil/user_.jpg';
            $imagePath = file_exists(public_path($userImagePath)) ? asset($userImagePath) : asset($defaultImage);
           
            // Fungsi untuk menyingkat nama - cek berbagai kemungkinan field nama
            $user = Auth::user();
            $fullName = $user->name ?? $user->nama ?? $user->full_name ?? $user->username ?? 'Guest';
           
            // Debug - hapus setelah selesai
            // dd($user->toArray()); // Uncomment ini untuk melihat semua field user
           
            $nameParts = explode(' ', trim($fullName));
           
            if (count($nameParts) <= 2) {
                $displayName = $fullName;
            } else {
                // Ambil nama depan dan inisial nama belakang
                $firstName = $nameParts[0];
                $lastInitial = strtoupper(substr(end($nameParts), 0, 1));
                $displayName = $firstName . ' ' . $lastInitial . '.';
            }
        @endphp
        <img id="sidebar-foto-profil" src="{{ $imagePath }}"
             class="rounded-circle" alt="User Image"
             style="width:40px; height:40px; object-fit:cover;">
     <span id="sidebar-nama-user" class="ms-2 text-dark fw-semibold" title="{{ $fullName }}">
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


<script>
// Fungsi untuk menyingkat nama - cek berbagai kemungkinan field
function formatDisplayName(userData) {
    const fullName = userData.name || userData.nama || userData.full_name || userData.username || 'Guest';
    const nameParts = fullName.trim().split(' ');
   
    if (nameParts.length <= 2) {
        return fullName;
    } else {
        // Ambil nama depan dan inisial nama belakang
        const firstName = nameParts[0];
        const lastInitial = nameParts[nameParts.length - 1].charAt(0).toUpperCase();
        return firstName + ' ' + lastInitial + '.';
    }
}


$.ajax({
    type: "POST",
    url: "/profil/update",
    data: formData,
    contentType: false,
    processData: false,
    success: function(response) {
        if (response.success) {
            // Format nama untuk display
            const displayName = formatDisplayName(response.user);
            const fullName = response.user.name || response.user.nama || response.user.full_name || response.user.username || 'Guest';
           
            // Update nama di sidebar dengan nama yang disingkat
            $('#sidebar-nama-user').text(displayName);
           
            // Update tooltip dengan nama lengkap
            $('#sidebar-nama-user').attr('title', fullName);


            // Update foto profil di sidebar
            $('#sidebar-foto-profil').attr('src', response.fotoPath + '?' + new Date().getTime());


            // Tampilkan notifikasi sukses (opsional)
            alert('Profil berhasil diperbarui');
        }
    },
    error: function(xhr) {
        alert('Gagal memperbarui profil');
    }
});
</script>


</ul>
<!-- / Menu -->

