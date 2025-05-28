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
            <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Tutup</button>
        </div>
    </div>
@else
    <form action="{{ url('/user/' . ($user->id_mahasiswa ?? $user->id_dosen ?? $user->id_admin) . '/' . $role . '/delete_ajax') }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Data Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <h5><i class="fas fa-exclamation-triangle"></i>Konfirmasi!!!</h5>
                    Apakah Anda ingin menghapus data seperti di bawah ini?
                </div>
                <table class="table table-sm table-bordered">
                    @if ($role === 'mahasiswa')
                        
                        <tr><th>Nama</th><td>{{ $user->nama }}</td></tr>
                        <tr><th>Email</th><td>{{ $user->email }}</td></tr>
                        <tr><th>NIM</th><td>{{ $user->nim }}</td></tr>
                        <tr><th>Nomor Telepon</th><td>{{ $user->nomor_telepon }}</td></tr>
                    @elseif ($role === 'dosen')
                        
                        <tr><th>Nama</th><td>{{ $user->nama }}</td></tr>
                        <tr><th>Email</th><td>{{ $user->email }}</td></tr>
                        <tr><th>NIDN</th><td>{{ $user->nidn }}</td></tr>
                        <tr><th>Nomor Telepon</th><td>{{ $user->nomor_telepon }}</td></tr>
                    @elseif ($role === 'admin')
                        
                        <tr><th>Nama</th><td>{{ $user->nama }}</td></tr>
                        <tr><th>Email</th><td>{{ $user->email }}</td></tr>
                        <tr><th>Nomor Telepon</th><td>{{ $user->nomor_telepon }}</td></tr>
                    @endif
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function () {
            $("#form-delete").submit(function (e) {
                e.preventDefault();
                const form = this;
                $.ajax({
                    url: form.action,
                    method: form.method,
                    data: $(form).serialize(),
                    success: function (response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire('Berhasil!', response.message, 'success');
                            dataUser.ajax.reload(); // Pastikan nama DataTable sesuai
                        } else {
                            Swal.fire('Gagal!', response.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error');
                    }
                });
            });
        });
    </script>
@endempty