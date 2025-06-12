@extends('layouts.template')

@section('content')
<div class="container py-4">
    <h4 class="mb-3">Laporan & Analisis Prestasi</h4>

    <div class="mb-4">
        <canvas id="grafikPrestasi" height="100"></canvas>
    </div>

    <div class="mb-3 text-end">
        <a href="{{ route('laporan.exportPdf') }}" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i> Export PDF
        </a>
    </div>

    <table id="tabelLaporan" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mahasiswa</th>
                <th>Nama Prestasi</th>
                <th>Kategori</th>
                <th>Tingkat</th>
                <th>Status</th>
                <th>Catatan</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function () {
    $('#tabelLaporan').DataTable({
        processing: true,
        serverSide: true,
ajax: '{{ url("laporanAdmin/list") }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'nama', name: 'nama' },
            { data: 'nama_prestasi', name: 'nama_prestasi' },
            { data: 'kategori_prestasi', name: 'kategori_prestasi' },
            { data: 'tingkat_prestasi', name: 'tingkat_prestasi' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'catatan', name: 'catatan' }
        ]

        
    });

    // Grafik Prestasi
    $.get('{{ route("laporan.grafik") }}', function (data) {
        const ctx = document.getElementById('grafikPrestasi');
        const chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: Object.keys(data),
                datasets: [{
                    label: 'Total Prestasi',
                    data: Object.values(data),
                    backgroundColor: ['#ffc107', '#28a745', '#dc3545'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });
    });
});
</script>
@endpush
