@empty($lomba)
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
                <a href="{{ url('/lomba') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/lomba/' . $lomba->id_tambahLomba . '/update_ajax') }}" method="POST" enctype="multipart/form-data" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Lomba</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lomba</label>
                        <input type="text" name="nama_lomba" class="form-control" value="{{ $lomba->nama_lomba }}" required>
                        <div id="error-nama_lomba" class="form-text text-danger"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kategori_lomba" class="form-label">Kategori Lomba</label>
                            <select name="kategori_lomba" id="kategori_lomba" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="akademik" {{ $lomba->kategori_lomba == 'akademik' ? 'selected' : '' }}>
                                    Akademik</option>
                                <option value="non-akademik"
                                    {{ $lomba->kategori_lomba == 'non-akademik' ? 'selected' : '' }}>Non-Akademik
                                </option>
                            </select>
                            <div id="error-kategori_lomba" class="form-text text-danger"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tingkat Lomba</label>
                            <select name="tingkat_lomba" class="form-select" required>
                                <option value="">-- Pilih Tingkat --</option>
                                <option value="politeknik"
                                    {{ $lomba->tingkat_lomba == 'politeknik' ? 'selected' : '' }}>Politeknik
                                </option>
                                <option value="kota" 
                                    {{ $lomba->tingkat_lomba == 'kota' ? 'selected' : '' }}>Kota
                                </option>
                                <option value="provinsi" 
                                    {{ $lomba->tingkat_lomba == 'provinsi' ? 'selected' : '' }}>Provinsi
                                </option>
                                <option value="nasional" 
                                    {{ $lomba->tingkat_lomba == 'nasional' ? 'selected' : '' }}>Nasional
                                </option>
                                <option value="internasional"
                                    {{ $lomba->tingkat_lomba == 'internasional' ? 'selected' : '' }}>Internasional
                                </option>
                            </select>
                            <div id="error-tingkat_lomba" class="form-text text-danger"></div>
                        </div>
                    </div>

                     <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Penyelenggara</label>
                            <input type="text" name="penyelenggara_lomba" class="form-control" value="{{ $lomba->penyelenggara_lomba }}" required>
                            <div id="error-penyelenggara_lomba" class="form-text text-danger"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3" required>{{ $lomba->deskripsi }}</textarea>
                            <div id="error-deskripsi" class="form-text text-danger"></div>
                        </div>
                    </div>

                     <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control" value="{{ $lomba->tanggal_mulai }}" required>
                            <div id="error-tanggal_mulai" class="form-text text-danger"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control" value="{{ $lomba->tanggal_selesai }}" required>
                            <div id="error-tanggal_selesai" class="form-text text-danger"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="form-label" class="form-label">Upload Pamflet (Gambar) 
                            <small
                                class="text-muted">(Kosongkan jika tidak diubah)
                            </small>
                        </label>
                        <input type="file" name="pamflet_lomba" id="pamflet_lomba" class="form-control" accept="image/*">
                        <div id="error-pamflet_lomba" class="form-text text-danger"></div>
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
        $(document).ready(function () {
            $("#form-edit").validate({
                rules: {
                    nama_lomba: "required",
                    kategori_lomba: "required",
                    tingkat_lomba: "required",
                    penyelenggara_lomba: "required",
                    deskripsi: "required",
                    tanggal_mulai: "required",
                    tanggal_selesai: "required"
                    // pamflet_lomba: {
                    //     extension: "jpg|jpeg|png|gif" // validasi tipe file gambar
                    // }
                },
                messages: {
                    nama_lomba: "Nama lomba wajib diisi.",
                    kategori_lomba: "Kategori lomba wajib dipilih.",
                    tingkat_lomba: "Tingkat lomba wajib dipilih.",
                    penyelenggara_lomba: "Penyelenggara wajib diisi.",
                    deskripsi: "Deskripsi wajib diisi.",
                    tanggal_mulai: "Tanggal mulai wajib diisi.",
                    tanggal_selesai: "Tanggal selesai wajib diisi."
                    // pamflet_lomba: {
                    //     extension: "File harus berupa gambar (jpg, jpeg, png, gif)."
                    // }
                },
                submitHandler: function (form) {
                    let formData = new FormData(form);

                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: formData,
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
                                dataLomba.ajax.reload();
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