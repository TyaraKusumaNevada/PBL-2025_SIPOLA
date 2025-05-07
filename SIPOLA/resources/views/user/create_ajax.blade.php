<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <form action="{{ url('/user/ajax') }}" method="POST" id="form-tambah">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-3">
                <div class="form-group mb-3">
                    <label for="level_id_modal">Role User</label>
                    <select name="level_id" id="level_id_modal" class="form-control" required>
                        <option value="">-- Pilih -- </option>
                        <option value="1">Dosen Pembimbing</option>
                        <option value="2">Mahasiswa</option>
                    </select>
                    <span id="error-level_id" class="error-text text-danger"></span>
                </div>
                <div class="form-group mb-3">
                    <label for="username">NIM / NIDN</label>
                    <input type="text" name="nimnidn" id="nimnidn" class="form-control" required>
                    <span id="error-nimnidn" class="error-text text-danger"></span>
                </div>
                <div class="form-group mb-3">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                    <span id="error-nama" class="error-text text-danger"></span>
                </div>
                <div class="form-group mb-2">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    <span id="error-password" class="error-text text-danger"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i>
                    <span class="ms-2">Batal</span>
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i>
                    <span class="ms-2">Simpan</span>
                </button>
            </div>
        </form>
    </div>
</div>
</div>

<script>
    $(document).ready(function() {
        $('#form-tambah').validate({
            rules: {
                level_id: {
                    required: true,
                    number: true
                },
                nimnidn: {
                    required: true,
                    maxlength: 20
                },
                nama: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                },
                password: {
                    required: true,
                    minlength: 6,
                    maxlength: 20
                }
            },
            submitHandler: function(form) {
                let formData = $(form).serialize();

                $.ajax({
                    url: form.action,
                    method: form.method,
                    data: formData,
                    dataType: 'json',
                    beforeSend: function() {
                        $('button[type="submit"]').prop('disabled', true).text(
                            'Menyimpan...');
                    },
                    success: function(response) {
                        $('button[type="submit"]').prop('disabled', false).text(
                            'Simpan');
                        $('.error-text').text('');

                        if (response.status) {
                            // Tutup modal
                            const modalEl = document.getElementById('myModal');
                            const modalInstance = bootstrap.Modal.getInstance(modalEl);
                            if (modalInstance) {
                                modalInstance.hide();
                            }

                            // Alert sukses
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });

                            // Reload DataTable
                            $('#userTable').DataTable().ajax.reload();
                        } else {
                            // Tampilkan error per field
                            $.each(response.msgField, function(field, message) {
                                $('#error-' + field).text(message[0]);
                            });

                            Swal.fire({
                                icon: 'error',
                                title: 'Validasi Gagal',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        $('button[type="submit"]').prop('disabled', false).text(
                            'Simpan');
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Gagal menyimpan data. Coba lagi nanti.'
                        });
                        console.error(xhr.responseText);
                    }
                });

                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('text-danger');
                element.closest('.form-group').append(error);
            },
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>