<div class="modal-content">
  <div class="modal-header bg-primary text-white">
    <h5 class="modal-title">Tambah Lomba</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>

  <form action="{{ url('/lomba/store_ajax') }}" method="POST" id="form-tambah">    
    @csrf
    <div class="modal-body">
      <div class="mb-3">
        <label for="nama_lomba" class="form-label">Nama Lomba</label>
        <input type="text" class="form-control" name="nama_lomba" required>
        <div class="invalid-feedback" id="error-nama_lomba"></div>
      </div>

      <div class="mb-3">
        <label for="kategori_lomba" class="form-label">Kategori Lomba</label>
        <input type="text" class="form-control" name="kategori_lomba" required>
        <div class="invalid-feedback" id="error-kategori_lomba"></div>
      </div>

      <div class="mb-3">
        <label for="tingkat_lomba" class="form-label">Tingkat Lomba</label>
        <select class="form-select" name="tingkat_lomba" required>
          <option value="">-- Pilih Tingkat --</option>
          <option value="provinsi">Provinsi</option>
          <option value="nasional">Nasional</option>
          <option value="internasional">Internasional</option>
        </select>
        <div class="invalid-feedback" id="error-tingkat_lomba"></div>
      </div>

      <div class="mb-3">
        <label for="penyelenggara_lomba" class="form-label">Penyelenggara</label>
        <input type="text" class="form-control" name="penyelenggara_lomba" required>
        <div class="invalid-feedback" id="error-penyelenggara_lomba"></div>
      </div>

      <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea class="form-control" name="deskripsi" rows="3" required></textarea>
        <div class="invalid-feedback" id="error-deskripsi"></div>
      </div>

      <div class="mb-3">
        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
        <input type="date" class="form-control" name="tanggal_mulai" required>
        <div class="invalid-feedback" id="error-tanggal_mulai"></div>
      </div>

      <div class="mb-3">
        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
        <input type="date" class="form-control" name="tanggal_selesai" required>
        <div class="invalid-feedback" id="error-tanggal_selesai"></div>
      </div>

      <div class="mb-3">
        <label for="status_verifikasi" class="form-label">Status Verifikasi</label>
        <select class="form-select" name="status_verifikasi" required>
            <option value="">-- Pilih Status --</option>
            <option value="Pending">Pending</option>
            <option value="Disetujui">Disetujui</option>
            <option value="Ditolak">Ditolak</option>
        </select>
        <div class="invalid-feedback" id="error-status_verifikasi"></div>
        </div>

      <div class="mb-3">
        <label for="pamflet_lomba" class="form-label">Pamflet Lomba</label>
        <input type="file" class="form-control" name="pamflet_lomba" accept="image/*" required>
        <div class="invalid-feedback" id="error-pamflet_lomba"></div>
      </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
        Batal
      </button>
      <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
  </form>
</div>

<script>
    $(document).ready(function () {
        $('#form-tambah').on('submit', function (e) {
            e.preventDefault();

            // Hapus pesan error sebelumnya
            $('.invalid-feedback').text('');
            $('.form-control, .form-select').removeClass('is-invalid');

            let formData = new FormData(this); // FormData agar file bisa dikirim

            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: formData,
                processData: false, // penting untuk FormData
                contentType: false, // penting untuk FormData
                success: function (response) {
                    if (response.status) {
                        // Tutup modal
                        const modalElement = document.getElementById('modal-master').closest('.modal');
                        const modalInstance = bootstrap.Modal.getInstance(modalElement);
                        modalInstance.hide();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });

                        // Refresh tabel data jika ada
                        if (typeof dataLomba !== 'undefined') {
                            dataLomba.ajax.reload();
                        }
                    } else {
                        // Tampilkan validasi field dari backend
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
                error: function (xhr) {
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
