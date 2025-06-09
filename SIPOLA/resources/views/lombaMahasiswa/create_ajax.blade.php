<form action="{{ url('/lombaMahasiswa/ajax') }}" method="POST" enctype="multipart/form-data" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Lomba</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label for="nama_lomba" class="form-label">Nama Lomba</label>
                    <input type="text" class="form-control" name="nama_lomba" required>
                    <div id="error-nama_lomba" class="form-text text-danger"></div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="kategori_lomba" class="form-label">Kategori Lomba</label>
                        <select name="kategori_lomba" id="kategori_lomba" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="akademik">Akademik</option>
                            <option value="non-akademik">Non-Akademik</option>
                        </select>
                        <div id="error-kategori_lomba" class="form-text text-danger"></div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tingkat_lomba" class="form-label">Tingkat Lomba</label>
                        <select class="form-select" name="tingkat_lomba" id="tingkat_lomba" required>
                            <option value="">-- Pilih Tingkat --</option>
                            <option value="politeknik">Politeknik</option>
                            <option value="kota">Kota</option>
                            <option value="provinsi">Provinsi</option>
                            <option value="nasional">Nasional</option>
                            <option value="internasional">Internasional</option>
                        </select>
                        <div id="error-tingkat_lomba" class="form-text text-danger"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="penyelenggara_lomba" class="form-label">Penyelenggara</label>
                        <input type="text" class="form-control" name="penyelenggara_lomba" required>
                        <div id="error-penyelenggara_lomba" class="form-text text-danger"></div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" rows="3" required></textarea>
                        <div id="error-deskripsi" class="form-text text-danger"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" name="tanggal_mulai" required>
                        <div id="error-tanggal_mulai" class="form-text text-danger"></div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" name="tanggal_selesai" required>
                        <div id="error-tanggal_selesai" class="form-text text-danger"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="pamflet_lomba" class="form-label">Pamflet Lomba</label>
                    <input type="file" class="form-control" name="pamflet_lomba" accept="image/*" required>
                    <div id="error-pamflet_lomba" class="form-text text-danger"></div>
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
    $(document).ready(function() {
        $("#form-tambah").validate({
            rules: {
                nama_lomba: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                kategori_lomba: {
                    required: true
                },
                tingkat_lomba: {
                    required: true
                },
                penyelenggara_lomba: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                tanggal_mulai: {
                    required: true,
                    date: true
                },
                tanggal_selesai: {
                    required: true,
                    date: true
                },
                pamflet_lomba: {
                    required: true,
                    extension: "jpg|jpeg|png"
                }
            },
            messages: {
                nama_lomba: {
                    required: "Nama lomba wajib diisi",
                    minlength: "Minimal 3 karakter",
                    maxlength: "Maksimal 255 karakter"
                },
                kategori_lomba: {
                    required: "Pilih kategori lomba"
                },
                tingkat_lomba: {
                    required: "Pilih tingkat lomba"
                },
                penyelenggara_lomba: {
                    required: "Penyelenggara wajib diisi",
                    minlength: "Minimal 3 karakter",
                    maxlength: "Maksimal 255 karakter"
                },
                tanggal_mulai: {
                    required: "Tanggal mulai wajib diisi",
                    date: "Format tanggal tidak valid"
                },
                tanggal_selesai: {
                    required: "Tanggal selesai wajib diisi",
                    date: "Format tanggal tidak valid"
                },
                pamflet_lomba: {
                    required: "Pamflet lomba wajib diunggah",
                    extension: "File harus berupa gambar (jpg, jpeg, png)"
                }
            },
            submitHandler: function(form) {
                var formData = new FormData(form);

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status) {
                            // Menutup modal Bootstrap 5
                            const modalElement = document.getElementById('modal-master')
                                .closest('.modal');
                            const modalInstance = bootstrap.Modal.getInstance(
                                modalElement);
                            modalInstance.hide();

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });

                            if (typeof dataHistoriMahasiswa !== 'undefined') {
                                dataHistoriMahasiswa.ajax.reload();
                            }

                            // Reset form dan error
                            $('#form-tambah')[0].reset();
                            $('.form-text.text-danger').text('');
                            $('.is-invalid').removeClass('is-invalid');

                        } else {
                            $('.form-text.text-danger').text('');
                            $.each(response.msgField, function(field, messages) {
                                $('#error-' + field).text(messages[0]);
                                $('#' + field).addClass('is-invalid');
                            });

                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error',
                            text: 'Terjadi kesalahan pada server. Silakan coba lagi.'
                        });
                    }
                });

                return false; // prevent default form submit
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.mb-3').append(error);
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