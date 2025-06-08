@empty($lomba)
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Kesalahan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-ban"></i> Kesalahan!</strong> Data yang Anda cari tidak ditemukan.
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" data-bs-dismiss="modal" class="btn btn-warning">Tutup</button>
        </div>
    </div>
@else
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Data Lomba</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table class="table table-hover table-sm">
                <tr>
                    <th>Nama Lomba</th>
                    <td>{{ $lomba->nama_lomba }}</td>
                </tr>
                <tr>
                    <th>Kategori Lomba</th>
                    <td>{{ $lomba->kategori_lomba }}</td>
                </tr>
                <tr>
                    <th>Tingkat Lomba</th>
                    <td>{{ ucfirst($lomba->tingkat_lomba) }}</td>
                </tr>
                <tr>
                    <th>Penyelenggara</th>
                    <td>{{ $lomba->penyelenggara_lomba }}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>{{ $lomba->deskripsi }}</td>
                </tr>
                <tr>
                    <th>Tanggal Mulai</th>
                    <td>{{ \Carbon\Carbon::parse($lomba->tanggal_mulai)->translatedFormat('d F Y, H:i') }}</td>
                </tr>
                <tr>
                    <th>Tanggal Selesai</th>
                    <td>{{ \Carbon\Carbon::parse($lomba->tanggal_selesai)->translatedFormat('d F Y, H:i') }}</td>
                </tr>
                <tr>
                    <th>Pamflet</th>
                    <td>
                        <a href="{{ asset('storage/' . $lomba->pamflet_lomba) }}" target="_blank"
                            class="btn btn-sm btn-outline-primary">
                            Lihat File
                        </a>
                    </td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" data-bs-dismiss="modal" class="btn btn-warning">Tutup</button>
        </div>
    </div>
@endempty