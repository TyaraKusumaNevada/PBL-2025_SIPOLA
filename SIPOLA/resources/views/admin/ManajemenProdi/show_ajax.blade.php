@empty($prodi)
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Kesalahan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-ban"></i> Kesalahan!</strong> Data Program Studi tidak ditemukan.
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" data-bs-dismiss="modal" class="btn btn-warning">Tutup</button>
        </div>
    </div>
@else
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Program Studi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table class="table table-hover table-sm">
                <tr>
                    <th>Nama Prodi</th>
                    <td>{{ $prodi->nama_prodi }}</td>
                </tr>
                <tr>
                    <th>Jenjang</th>
                    <td>{{ $prodi->jenjang }}</td>
                </tr>
                <tr>
                    <th>Dibuat pada</th>
                    <td>{{ $prodi->created_at->translatedFormat('d F Y H:i') }}</td>
                </tr>
                <tr>
                    <th>Diubah pada</th>
                    <td>{{ $prodi->updated_at->translatedFormat('d F Y H:i') }}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" data-bs-dismiss="modal" class="btn btn-warning">Tutup</button>
        </div>
    </div>
@endempty