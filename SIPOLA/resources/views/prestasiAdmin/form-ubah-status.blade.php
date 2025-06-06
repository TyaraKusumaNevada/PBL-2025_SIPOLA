<form action="{{ url('/prestasiAdmin/' . $data->id_prestasi . '/ubahStatus') }}" method="POST" id="formUbahStatus">
    @csrf
    <div id="modalUbahStatus" class="modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Status Prestasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="pending" {{ $data->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="divalidasi" {{ $data->status == 'divalidasi' ? 'selected' : '' }}>Divalidasi</option>
                        <option value="ditolak" {{ $data->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    <div id="error-status" class="form-text text-danger"></div>
                </div>
                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan</label>
                    <textarea name="catatan" id="catatan" class="form-control">{{ $data->catatan }}</textarea>
                    <div id="error-catatan" class="form-text text-danger"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        $("#formUbahStatus").validate({
            rules: {
                status: {
                    required: true
                },
                catatan: {
                    maxlength: 255
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function (response) {
                        if (response.status) {
                            const modalElement = document.getElementById('modalUbahStatus').closest('.modal');
                            const modalInstance = bootstrap.Modal.getInstance(modalElement);
                            modalInstance.hide();

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });

                            // $('#table-verifikasiTable').DataTable().ajax.reload(null, false);
                            dataVerifikasiPrestasi.ajax.reload();
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