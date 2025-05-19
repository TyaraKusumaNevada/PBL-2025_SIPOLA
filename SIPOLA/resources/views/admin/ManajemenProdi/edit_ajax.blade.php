@empty($prodi)
    <div id="modal-master" class="modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="bi bi-exclamation-triangle-fill"></i> Kesalahan!!!</h5>
                    Data program studi tidak ditemukan
                </div>
                <a href="{{ url('/admin/ManajemenProdi') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('admin/ManajemenProdi/' . $prodi->id_prodi . '/update_ajax') }}" method="POST" id="form-edit-prodi">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Program Studi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_prodi" class="form-label">Nama Prodi</label>
                        <input value="{{ $prodi->nama_prodi }}" type="text" name="nama_prodi" id="nama_prodi" class="form-control" required>
                        <div id="error-nama_prodi" class="form-text text-danger"></div>
                    </div>
                    <div class="mb-3">
                        <label for="jenjang" class="form-label">Jenjang</label>
                        <select name="jenjang" id="jenjang" class="form-select" required>
                            <option value="">-- Pilih Jenjang --</option>
                            <option value="D2" {{ $prodi->jenjang == 'D2' ? 'selected' : '' }}>D2</option>
                            <option value="D3" {{ $prodi->jenjang == 'D3' ? 'selected' : '' }}>D3</option>
                            <option value="D4" {{ $prodi->jenjang == 'D4' ? 'selected' : '' }}>D4</option>
                        </select>
                        <div id="error-jenjang" class="form-text text-danger"></div>
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
            $("#form-edit-prodi").validate({
                rules: {
                    nama_prodi: {
                        required: true,
                        minlength: 3,
                        maxlength: 100
                    },
                    jenjang: {
                        required: true
                    }
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function (response) {
                            if (response.status) {
                                const modalElement = document.getElementById('modal-master').closest('.modal');
                                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                                modalInstance.hide();

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message || 'Data berhasil diupdate.'
                                });
                                dataProdi.ajax.reload();
                            } else {
                                $('.form-text.text-danger').text('');
                                $.each(response.msgField, function (field, messages) {
                                    $('#error-' + field).text(messages[0]);
                                });

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message || 'Validasi gagal. Cek input Anda.'
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