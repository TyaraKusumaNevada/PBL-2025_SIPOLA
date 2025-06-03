<form action="{{ url('/prestasi/ajax') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Unggah Prestasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" name="nim" id="nim" class="form-control" value="{{ auth()->user()->username }}" disabled>
                    <div id="error-nim" class="form-text text-danger"></div>
                </div>
                <div class="mb-3">
                    <label for="nama_prestasi" class="form-label">Nama Prestasi</label>
                    <input type="text" name="nama_prestasi" id="nama_prestasi" class="form-control" required>
                    <div id="error-nama_prestasi" class="form-text text-danger"></div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="kategori_prestasi" class="form-label">Kategori Prestasi</label>
                        <select name="kategori_prestasi" id="kategori_prestasi" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="akademik">Akademik</option>
                            <option value="non-akademik">Non-Akademik</option>
                        </select>
                        <div id="error-kategori_prestasi" class="form-text text-danger"></div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tingkat_prestasi" class="form-label">Tingkat Prestasi</label>
                        <select name="tingkat_prestasi" id="tingkat_prestasi" class="form-select" required>
                            <option value="">-- Pilih Tingkat --</option>
                            <option value="politeknik">Politeknik</option>
                            <option value="kota">Kota</option>
                            <option value="provinsi">Provinsi</option>
                            <option value="nasional">Nasional</option>
                            <option value="internasional">Internasional</option>
                        </select>
                        <div id="error-tingkat_prestasi" class="form-text text-danger"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="juara" class="form-label">Juara</label>
                        <input type="text" name="juara" id="juara" class="form-control" required>
                        <div id="error-juara" class="form-text text-danger"></div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="penyelenggara" class="form-label">Penyelenggara</label>
                        <input type="text" name="penyelenggara" id="penyelenggara" class="form-control" required>
                        <div id="error-penyelenggara" class="form-text text-danger"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal Prestasi</label>
                    <input type="datetime-local" name="tanggal" id="tanggal" class="form-control" required>
                    <div id="error-tanggal" class="form-text text-danger"></div>
                </div>
                <div class="mb-3">
                    <label for="bukti_file" class="form-label">Upload Bukti (PDF/Gambar)</label>
                    <input type="file" name="bukti_file" id="bukti_file" class="form-control" accept="application/pdf,image/*" required>
                    <div id="error-bukti_file" class="form-text text-danger"></div>
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
    $("#form-tambah").validate({
        rules: {
            nama_prestasi: {
                required: true,
                minlength: 3,
                maxlength: 255
            },
            kategori_prestasi: {
                required: true
            },
            tingkat_prestasi: {
                required: true
            },
            juara: {
                required: true
            },
            penyelenggara: {
                required: true,
                minlength: 3,
                maxlength: 255
            },
            tanggal: {
                required: true,
                date: true
            },
            bukti_file: {
                required: true,
                extension: "pdf|jpg|jpeg|png"
            }
        },
        messages: {
            nama_prestasi: {
                required: "Nama prestasi wajib diisi",
                minlength: "Minimal 3 karakter",
                maxlength: "Maksimal 255 karakter"
            },
            kategori_prestasi: {
                required: "Pilih kategori prestasi"
            },
            tingkat_prestasi: {
                required: "Pilih tingkat prestasi"
            },
            juara: {
                required: "Juara wajib diisi"
            },
            penyelenggara: {
                required: "Penyelenggara wajib diisi",
                minlength: "Minimal 3 karakter",
                maxlength: "Maksimal 255 karakter"
            },
            tanggal: {
                required: "Tanggal wajib diisi",
                date: "Format tanggal tidak valid"
            },
            bukti_file: {
                required: "Bukti prestasi wajib diunggah",
                extension: "File harus berupa PDF atau gambar (jpg, jpeg, png)"
            }
        },
        submitHandler: function (form) {
            var formData = new FormData(form);

            $.ajax({
                url: form.action,
                type: form.method,
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.status) {
                        // Menutup modal Bootstrap 5
                        const modalElement = document.getElementById('modal-master').closest('.modal');
                        const modalInstance = bootstrap.Modal.getInstance(modalElement);
                        modalInstance.hide();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });

                        // Misal kamu menggunakan DataTable dan ada variabel dataPrestasi
                        if (typeof dataPrestasi !== 'undefined') {
                            dataPrestasi.ajax.reload();
                        }

                        // Reset form dan error
                        $('#form-tambah')[0].reset();
                        $('.form-text.text-danger').text('');
                        $('.is-invalid').removeClass('is-invalid');

                    } else {
                        $('.form-text.text-danger').text('');
                        $.each(response.msgField, function (field, messages) {
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
                error: function (xhr) {
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
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.mb-3').append(error);
        },
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        }
    });
});
</script>