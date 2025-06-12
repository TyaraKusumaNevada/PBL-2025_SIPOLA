{{-- <div class="lh-sm">
    <strong>{{ $row->nama_prestasi }}</strong><br>
    Kategori: {{ $row->kategori_prestasi }}<br>
    Tingkat: {{ $row->tingkat_prestasi }}<br>
    Juara: {{ $row->juara }}<br>
    Penyelenggara: {{ $row->penyelenggara }}<br>
    Tanggal: {{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}
</div> --}}

<div class="modal-header">
    <h5 class="modal-title">Detail Prestasi {{ $mahasiswa->user->name }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    @if ($mahasiswa->prestasi->count())
        <ul class="list-group list-group-flush">
            @foreach ($mahasiswa->prestasi as $prestasi)
                <li class="list-group-item">
                    <strong>{{ $prestasi->nama_prestasi }}</strong><br>
                    Kategori: {{ $prestasi->kategori_prestasi }}<br>
                    Tingkat: {{ $prestasi->tingkat_prestasi }}<br>
                    Juara: {{ $prestasi->juara }}<br>
                    Penyelenggara: {{ $prestasi->penyelenggara }}<br>
                    Tanggal: {{ \Carbon\Carbon::parse($prestasi->tanggal)->translatedFormat('d F Y') }}
                </li>
            @endforeach
        </ul>
    @else
        <p>Tidak ada data prestasi.</p>
    @endif
</div>
