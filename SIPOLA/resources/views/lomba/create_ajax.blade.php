<form action="{{ url('/lomba/store_ajax') }}" method="POST" enctype="multipart/form-data" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg modal-dialog-centered" role="document">
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

                <div class="mb-3">
                    <label for="kategori_lomba" class="form-label">Kategori Lomba</label>
                    <input type="text" class="form-control" name="kategori_lomba" required>
                    <div id="error-kategori_lomba" class="form-text text-danger"></div>
                </div>

                <div class="mb-3">
                    <label for="tingkat_lomba" class="form-label">Tingkat Lomba</label>
                    <select class="form-select" name="tingkat_lomba" required>
                        <option value="">-- Pilih Tingkat --</option>
                        <option value="provinsi">Provinsi</option>
                        <option value="nasional">Nasional</option>
                        <option value="internasional">Internasional</option>
                    </select>
                    <div id="error-tingkat_lomba" class="form-text text-danger"></div>
                </div>

                <div class="mb-3">
                    <label for="penyelenggara_lomba" class="form-label">Penyelenggara</label>
                    <input type="text" class="form-control" name="penyelenggara_lomba" required>
                    <div id="error-penyelenggara_lomba" class="form-text text-danger"></div>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" rows="3" required></textarea>
                    <div id="error-deskripsi" class="form-text text-danger"></div>
                </div>

                <div class="mb-3">
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" name="tanggal_mulai" required>
                    <div id="error-tanggal_mulai" class="form-text text-danger"></div>
                </div>

                <div class="mb-3">
                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                    <input type="date" class="form-control" name="tanggal_selesai" required>
                    <div id="error-tanggal_selesai" class="form-text text-danger"></div>
                </div>

                <div class="mb-3">
                    <label for="status_verifikasi" class="form-label">Status Verifikasi</label>
                    <select class="form-select" name="status_verifikasi" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="Pending">Pending</option>
                        <option value="Disetujui">Disetujui</option>
                        <option value="Ditolak">Ditolak</option>
                    </select>
                    <div id="error-status_verifikasi" class="form-text text-danger"></div>
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
    $(document).ready(function () {
        $('#form-tambah').on('submit', function (e) {
            e.preventDefault();

            $('.form-text.text-danger').text('');
            $('.form-control, .form-select').removeClass('is-invalid');

            let formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status) {
                        const modalElement = document.getElementById('modal-master').closest('.modal');
                        const modalInstance = bootstrap.Modal.getInstance(modalElement);
                        modalInstance.hide();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });

                        if (typeof dataLomba !== 'undefined') {
                            dataLomba.ajax.reload();
                        }
                    } else {
                        $.each(response.msgField, function (field, messages) {
                            let input = $('[name="' + field + '"]');
                            input.addClass('is-invalid');
                            $('#error-' + field).text(messages[0]);
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Validasi Gagal',
                            text: response.message || 'Silakan cek kembali input Anda.'
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Terjadi kesalahan pada server. Silakan coba lagi.'
                    });
                }
            });
        });
    });
</script>
