<form action="{{ url('/lomba/verifikasi/' . $lomba->id_tambahLomba . '/ubahStatus') }}" method="POST" id="formUbahStatus">
    @csrf
    <div id="modalUbahStatus" class="modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Status Info Lomba</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="status_verifikasi" class="form-label">Status</label>
                    <select name="status_verifikasi" id="status_verifikasi" class="form-control" required>
                        <option value="Pending" {{ $lomba->status_verifikasi == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Disetujui" {{ $lomba->status_verifikasi == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="Ditolak" {{ $lomba->status_verifikasi == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    <div id="error-status_verifikasi" class="form-text text-danger"></div>
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
                status_verifikasi: {
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
                            const modalElement = document.getElementById('modalUbahStatus').closest('.modal');
                            const modalInstance = bootstrap.Modal.getInstance(modalElement);
                            modalInstance.hide();

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });

                            // $('#table-verifikasiTable').DataTable().ajax.reload(null, false);
                            dataVerifikasiLomba.ajax.reload();
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