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

                    <div class="mb-3">
                        <label class="form-label">Kategori Lomba</label>
                        <input type="text" name="kategori_lomba" class="form-control" value="{{ $lomba->kategori_lomba }}" required>
                        <div id="error-kategori_lomba" class="form-text text-danger"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tingkat Lomba</label>
                        <select name="tingkat_lomba" class="form-select" required>
                            <option value="">-- Pilih Tingkat --</option>
                            <option value="provinsi" {{ $lomba->tingkat_lomba == 'provinsi' ? 'selected' : '' }}>Provinsi</option>
                            <option value="nasional" {{ $lomba->tingkat_lomba == 'nasional' ? 'selected' : '' }}>Nasional</option>
                            <option value="internasional" {{ $lomba->tingkat_lomba == 'internasional' ? 'selected' : '' }}>Internasional</option>
                        </select>
                        <div id="error-tingkat_lomba" class="form-text text-danger"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Penyelenggara</label>
                        <input type="text" name="penyelenggara_lomba" class="form-control" value="{{ $lomba->penyelenggara_lomba }}" required>
                        <div id="error-penyelenggara_lomba" class="form-text text-danger"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3" required>{{ $lomba->deskripsi }}</textarea>
                        <div id="error-deskripsi" class="form-text text-danger"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control" value="{{ $lomba->tanggal_mulai }}" required>
                        <div id="error-tanggal_mulai" class="form-text text-danger"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control" value="{{ $lomba->tanggal_selesai }}" required>
                        <div id="error-tanggal_selesai" class="form-text text-danger"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pamflet Saat Ini</label><br>
                        <img src="{{ asset('storage/pamflet_lomba/' . $lomba->pamflet_lomba) }}" alt="Pamflet" class="img-thumbnail" width="250">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ganti Pamflet (opsional)</label>
                        <input type="file" name="pamflet_lomba" class="form-control" accept="image/*">
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
            $("#form-edit").validate({
                submitHandler: function (form) {
                    let formData = new FormData(form);

                    $.ajax({
                        url: form.action,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-HTTP-Method-Override': 'PUT'
                        },
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

                                $('#lombaTable').DataTable().ajax.reload();
                            } else {
                                $('.form-text.text-danger').text('');
                                $.each(response.msgField, function (prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
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
                                text: 'Terjadi kesalahan pada server:\n' + xhr.status + ' - ' + xhr.statusText
                            });
                        }
                    });

                    return false;
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
@endempty
