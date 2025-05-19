@empty($user)
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Kesalahan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-ban"></i> Kesalahan!</strong> Data yang Anda cari tidak ditemukan.
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" data-bs-dismiss="modal" class="btn btn-warning">Tutup</button>
        </div>
    </div>
@else
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Data Pengguna</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table class="table table-hover table-sm">
                @if ($role === 'mahasiswa')
                    <tr><th>ID</th><td>{{ $user->id_mahasiswa }}</td></tr>
                    <tr><th>Nama</th><td>{{ $user->nama }}</td></tr>
                    <tr><th>Email</th><td>{{ $user->email }}</td></tr>
                    <tr><th>Nomor Induk</th><td>{{ $user->nim }}</td></tr>
                @elseif ($role === 'dosen')
                    <tr><th>ID</th><td>{{ $user->id_dosen }}</td></tr>
                    <tr><th>Nama</th><td>{{ $user->nama }}</td></tr>
                    <tr><th>Email</th><td>{{ $user->email }}</td></tr>
                    <tr><th>Nomor Induk</th><td>{{ $user->nidn }}</td></tr>
                @elseif ($role === 'admin')
                    <tr><th>ID</th><td>{{ $user->id_admin }}</td></tr>
                    <tr><th>Nama</th><td>{{ $user->nama }}</td></tr>
                    <tr><th>Email</th><td>{{ $user->email }}</td></tr>
                    <tr><th>Nomor Induk</th><td>-</td></tr>
                @endif
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" data-bs-dismiss="modal" class="btn btn-warning">Tutup</button>
        </div>
    </div>
@endempty