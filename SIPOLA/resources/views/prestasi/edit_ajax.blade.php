@empty($prestasi)
    <div id="modal-master" class="modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="bi bi-exclamation-triangle-fill"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/prestasi') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/prestasi/' . $prestasi->id_prestasi . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Prestasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->username }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="nama_prestasi" class="form-label">Nama Prestasi</label>
                        <input type="text" name="nama_prestasi" id="nama_prestasi" class="form-control"
                            value="{{ $prestasi->nama_prestasi }}" required>
                        <div id="error-nama_prestasi" class="form-text text-danger"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kategori_prestasi" class="form-label">Kategori Prestasi</label>
                            <select name="kategori_prestasi" id="kategori_prestasi" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="akademik" {{ $prestasi->kategori_prestasi == 'akademik' ? 'selected' : '' }}>
                                    Akademik</option>
                                <option value="non-akademik"
                                    {{ $prestasi->kategori_prestasi == 'non-akademik' ? 'selected' : '' }}>Non-Akademik
                                </option>
                            </select>
                            <div id="error-kategori_prestasi" class="form-text text-danger"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tingkat_prestasi" class="form-label">Tingkat Prestasi</label>
                            <select name="tingkat_prestasi" id="tingkat_prestasi" class="form-select" required>
                                <option value="">-- Pilih Tingkat --</option>
                                <option value="politeknik"
                                    {{ $prestasi->tingkat_prestasi == 'politeknik' ? 'selected' : '' }}>Politeknik</option>
                                <option value="kota" {{ $prestasi->tingkat_prestasi == 'kota' ? 'selected' : '' }}>Kota
                                </option>
                                <option value="nasional" {{ $prestasi->tingkat_prestasi == 'nasional' ? 'selected' : '' }}>
                                    Nasional</option>
                                <option value="internasional"
                                    {{ $prestasi->tingkat_prestasi == 'internasional' ? 'selected' : '' }}>Internasional
                                </option>
                            </select>
                            <div id="error-tingkat_prestasi" class="form-text text-danger"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="juara" class="form-label">Juara</label>
                            <input type="text" name="juara" id="juara" class="form-control"
                                value="{{ $prestasi->juara }}" required>
                            <div id="error-juara" class="form-text text-danger"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="penyelenggara" class="form-label">Penyelenggara</label>
                            <input type="text" name="penyelenggara" id="penyelenggara" class="form-control"
                                value="{{ $prestasi->penyelenggara }}" required>
                            <div id="error-penyelenggara" class="form-text text-danger"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal Prestasi</label>
                        <input type="datetime-local" name="tanggal" id="tanggal" class="form-control"
                            value="{{ \Carbon\Carbon::parse($prestasi->tanggal)->format('Y-m-d\TH:i') }}" required>
                        <div id="error-tanggal" class="form-text text-danger"></div>
                    </div>
                    <div class="mb-3">
                        <label for="bukti_file" class="form-label">Upload Bukti (PDF/Gambar) <small
                                class="text-muted">(Kosongkan jika tidak diubah)</small></label>
                        <input type="file" name="bukti_file" id="bukti_file" class="form-control"
                            accept="application/pdf,image/*">
                        <div id="error-bukti_file" class="form-text text-danger"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            $("#form-edit").validate({
                rules: {
                    nama_prestasi: "required",
                    kategori_prestasi: "required",
                    tingkat_prestasi: "required",
                    juara: "required",
                    penyelenggara: "required",
                    tanggal: "required"
                },
                submitHandler: function(form) {
                    let formData = new FormData(form); // penting untuk file upload
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: formData,
                        // data: $(form).serialize(),
                        contentType: false, // harus false untuk FormData
                        processData: false, // harus false agar jQuery tidak ubah data
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
                                dataPrestasi.ajax.reload();
                            } else {
                                $('.form-text.text-danger').text(''); // Clear all errors
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
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
                    return false;
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
@endempty