@empty($lomba)
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Kesalahan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                Data yang anda cari tidak ditemukan
            </div>
            <a href="{{ url('/lomba') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
@else
    <form action="{{ url('/lomba/' . $lomba->id_tambahLomba . '/delete_ajax') }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Data Lomba</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <h5><i class="icon fas fa-ban"></i> Konfirmasi!!!</h5>
                    Apakah Anda yakin ingin menghapus data berikut?
                </div>
                <table class="table table-sm table-bordered">
                    <tr><th class="text-end col-4">Nama Lomba:</th><td>{{ $lomba->nama_lomba }}</td></tr>
                    <tr><th class="text-end">Kategori Lomba:</th><td>{{ $lomba->kategori_lomba }}</td></tr>
                    <tr><th class="text-end">Tingkat:</th><td>{{ ucfirst($lomba->tingkat_lomba) }}</td></tr>
                    <tr><th class="text-end">Penyelenggara:</th><td>{{ $lomba->penyelenggara_lomba }}</td></tr>
                    <tr><th class="text-end">Tanggal Mulai:</th><td>{{ $lomba->tanggal_mulai }}</td></tr>
                    <tr><th class="text-end">Tanggal Selesai:</th><td>{{ $lomba->tanggal_selesai }}</td></tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            $("#form-delete").validate({
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                $('#myModal').modal('hide'); // pastikan ID modal sesuai
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                dataLomba.ajax.reload();
                            } else {
                                $('.error-text').text('');
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
                                title: 'Gagal',
                                text: 'Terjadi kesalahan saat menghapus data.'
                            });
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
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