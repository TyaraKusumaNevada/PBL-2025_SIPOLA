@empty($lomba)
    <div class="modal-content">
        <div class="modal-header bg-danger text-white" style="padding-top:1rem; padding-bottom:1rem;">
            <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Kesalahan</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="fas fa-ban fs-3 me-3"></i>
                <div>
                    <strong>Data tidak ditemukan!</strong><br>
                    Mohon periksa kembali data yang ingin Anda akses.
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" data-bs-dismiss="modal" class="btn btn-outline-light btn-sm">Tutup</button>
        </div>
    </div>
@else
    <div class="modal-content" style="max-height: 80vh; display: flex; flex-direction: column;">
        <div class="modal-header bg-primary text-white" style="padding-top:1rem; padding-bottom:1rem;">
            <h5 class="modal-title"><i class="bi bi-info-circle-fill me-2"></i>Detail Data Lomba</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="overflow-y: auto; flex-grow: 1; padding-right: 1rem; padding-left: 1rem;">
            <div class="mb-3 text-center">
                <img src="{{ asset('storage/' . $lomba->pamflet_lomba) }}" alt="Pamflet {{ $lomba->nama_lomba }}"
                    class="img-fluid rounded shadow" style="max-height: 200px; object-fit: contain; max-width: 100%;">
            </div>
            <table class="table table-borderless table-sm">
                <tbody>
                    <tr>
                        <th scope="row" style="width: 30%;">Nama Lomba</th>
                        <td>{{ $lomba->nama_lomba }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Kategori Lomba</th>
                        <td>{{ $lomba->kategori_lomba }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Tingkat Lomba</th>
                        <td>{{ ucfirst($lomba->tingkat_lomba) }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Penyelenggara</th>
                        <td>{{ $lomba->penyelenggara_lomba }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Deskripsi</th>
                        <td style="white-space: pre-line;">{{ $lomba->deskripsi }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Tanggal Mulai</th>
                        <td>{{ \Carbon\Carbon::parse($lomba->tanggal_mulai)->translatedFormat('d F Y, H:i') }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Tanggal Selesai</th>
                        <td>{{ \Carbon\Carbon::parse($lomba->tanggal_selesai)->translatedFormat('d F Y, H:i') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <a href="{{ asset('storage/' . $lomba->pamflet_lomba) }}" target="_blank"
                class="btn btn-outline-primary me-auto">
                <i class="bi bi-file-earmark-image"></i> Lihat Pamflet
            </a>
            <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Tutup</button>
        </div>
    </div>
@endempty

<style>
    .modal-header.bg-primary {
        padding-top: 1rem;
        padding-bottom: 1rem;
    }
</style>