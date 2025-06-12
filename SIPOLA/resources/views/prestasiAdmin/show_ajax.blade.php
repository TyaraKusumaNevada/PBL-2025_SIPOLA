@empty($prestasi)
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Kesalahan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-ban"></i> Kesalahan!</strong> Data prestasi tidak ditemukan.
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" data-bs-dismiss="modal" class="btn btn-warning">Tutup</button>
        </div>
    </div>
@else
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Data Prestasi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table class="table table-hover table-sm">
                <tr>
                    <th>Nama Mahasiswa</th>
                    <td>{{ $prestasi->mahasiswa->nama }}</td>
                </tr>
                <tr>
                    <th>Nama Prestasi</th>
                    <td>{{ $prestasi->nama_prestasi }}</td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td>{{ ucfirst($prestasi->kategori_prestasi) }}</td>
                </tr>
                <tr>
                    <th>Tingkat</th>
                    <td>{{ ucfirst($prestasi->tingkat_prestasi) }}</td>
                </tr>
                <tr>
                    <th>Juara</th>
                    <td>{{ $prestasi->juara }}</td>
                </tr>
                <tr>
                    <th>Penyelenggara</th>
                    <td>{{ $prestasi->penyelenggara }}</td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>{{ \Carbon\Carbon::parse($prestasi->tanggal)->translatedFormat('d F Y, H:i') }}</td>
                </tr>
                <tr>
                    <th>Bukti File</th>
                    <td>
                        <a href="{{ asset('storage/' . $prestasi->bukti_file) }}" target="_blank"
                            class="btn btn-sm btn-outline-primary">
                            Lihat File
                        </a>
                    </td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if ($prestasi->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif($prestasi->status == 'divalidasi')
                            <span class="badge bg-success">Divalidasi</span>
                        @elseif($prestasi->status == 'ditolak')
                            <span class="badge bg-danger">Ditolak</span>
                        @else
                            <span class="badge bg-secondary">{{ ucfirst($prestasi->status) }}</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Catatan</th>
                    <td>{{ $prestasi->catatan }}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" data-bs-dismiss="modal" class="btn btn-warning">Tutup</button>
        </div>
    </div>
@endempty