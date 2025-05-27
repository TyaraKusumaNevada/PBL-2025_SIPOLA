<form action="{{ url('/user/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="id_role" class="form-label">Role</label>
                    <select name="id_role" id="id_role" class="form-select" required>
                        <option value="">-- Pilih Role --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id_role }}">{{ $role->role_nama }}</option>
                        @endforeach
                    </select>
                    <div id="error-id_role" class="form-text text-danger"></div>
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                    <div id="error-nama" class="form-text text-danger"></div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                    <div id="error-email" class="form-text text-danger"></div>
                </div>

                <div class="mb-3">
                    <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                    <input type="nomor_telepon" name="nomor_telepon" id="nomor_telepon" class="form-control" required>
                    <div id="error-nomor_telepon" class="form-text text-danger"></div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" required>
                        <button class="btn" type="button" id="toggle-password" style="border: 0.10px solid rgb(214, 214, 214); border-radius: 4px; outline:none; box-shadow:none;">
                            <i class="bi bi-eye" id="icon-eye"></i>
                        </button>
                    </div>
                    <div id="error-password" class="form-text text-danger"></div>
                </div>

                <div class="mb-3" id="nim_nidn-section" style="display: none;">
                    <label for="nim_nidn" class="form-label">NIM / NIDN</label>
                    <input type="text" name="nim_nidn" id="nim_nidn" class="form-control">
                    <div id="error-nim_nidn" class="form-text text-danger"></div>
                </div>

                <div class="mb-3" id="prodi-section" style="display: none;">
                    <label for="id_prodi" class="form-label">Program Studi</label>
                    <select name="id_prodi" id="id_prodi" class="form-select">
                        <option value="">-- Pilih Prodi --</option>
                        @foreach ($prodis as $prodi)
                            <option value="{{ $prodi->id_prodi }}">{{ $prodi->nama_prodi }}</option>
                        @endforeach
                    </select>
                    <div id="error-id_prodi" class="form-text text-danger"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        $('#id_role').on('change', function () {
            const selected = $(this).val();

            // Tampilkan NIM/NIDN jika role adalah Mahasiswa (3) atau Dospem (2)
            if (selected == 2 || selected == 3) {
                $('#nim_nidn-section').show();
            } else {
                $('#nim_nidn-section').hide();
                $('#nim_nidn').val('');
            }

            // Tampilkan Prodi hanya jika role adalah Mahasiswa (3)
            if (selected == 3) {
                $('#prodi-section').show();
            } else {
                $('#prodi-section').hide();
                $('#id_prodi').val('');
            }
        });

        $("#form-tambah").on("submit", function (e) {
            e.preventDefault();
            const form = this;

            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function (response) {
                    if (response.status ?? false) {
                        const modalElement = document.getElementById('modal-master').closest('.modal');
                        const modalInstance = bootstrap.Modal.getInstance(modalElement);
                        modalInstance.hide();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });

                        // Reload datatable atau data
                        if (typeof dataUser !== 'undefined') dataUser.ajax.reload();
                    } else {
                        $('.form-text.text-danger').text('');
                        $.each(response.msgField, function (prefix, val) {
                            $('#error-' + prefix).text(val[0]);
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Validasi Gagal',
                            text: response.message
                        });
                    }
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Terjadi kesalahan pada server.'
                    });
                }
            });
        });

        $('#toggle-password').on('click', function() {
            const passwordInput = $('#password');
            const icon = $('#icon-eye');

            const isPassword = passwordInput.attr('type') === 'password';
            passwordInput.attr('type', isPassword ? 'text' : 'password');
            icon.toggleClass('bi-eye').toggleClass('bi-eye-slash');
        });
    });
</script>