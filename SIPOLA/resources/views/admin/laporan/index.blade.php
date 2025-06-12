@extends('layouts.template')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-xxl-12 mb-6 order-0">
            <div class="card">
                <div class="d-flex align-items-start row">
                    <div class="col-sm-12">
                        <div class="card-body min-vh-50 mb-5">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="card-title text-primary fs-3 m-0">Laporan & Analisis Prestasi</h5>
                                <a href="{{ route('laporan.exportPdf') }}" class="btn btn-danger">
                                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                                </a>
                            </div>

                            <div class="mb-4 d-flex justify-content-center">
                                <canvas id="grafikPrestasi" class="grafik-pie"></canvas>
                            </div>

                            <div class="row mb-4">
                                <label class="col-form-label col-1">Filter:</label>
                                <div class="col-3">
                                    <select class="form-control" id="status" name="status">
                                        <option value="">- Semua -</option>
                                        @foreach($verifikasiStatus as $status)
                                            <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Status</small>
                                </div>
                            </div>

                            <div class="w-100 mt-4">
                                <table id="tabelLaporan" class="table w-100">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>
@endsection

@push('css')
    <style>
        div.dataTables_wrapper div.dataTables_length,
        div.dataTables_wrapper div.dataTables_filter {
            margin-top: 1rem;
        }

        .grafik-pie {
        max-width: 300px !important;
        max-height: 300px !important;
    }
    </style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function () {
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        var tabelLaporan = $('#tabelLaporan').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ url("laporanAdmin/list") }}',
                type: "POST",
                data: function (d) {
                    d.status = $('#status').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', className: 'text-center', orderable: false, searchable: false },
                { data: 'nama' },
                { data: 'nama_prestasi' },
                { data: 'kategori_prestasi' },
                { data: 'tingkat_prestasi' },
                { data: 'status', orderable: false, searchable: false },
                { data: 'catatan', orderable: false, searchable: false }
            ],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Berikutnya",
                    previous: "Sebelumnya"
                },
                processing: "Memuat..."
            }
        });

        $('#status').on('change', function () {
            tabelLaporan.ajax.reload();
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
