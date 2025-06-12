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
                                    <h5 class="card-title text-primary fs-3 m-0">Filter Prestasi Mahasiswa</h5>
                                </div>

                                {{-- Alert --}}
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                {{-- Filter --}}
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <label for="kategori_prestasi" class="form-label">Kategori Prestasi</label>
                                        <select id="kategori_prestasi" class="form-select">
                                            <option value="">Semua</option>
                                            @foreach ($kategori_prestasi as $kat)
                                                <option value="{{ $kat }}">{{ $kat }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="tahun" class="form-label">Tahun</label>
                                        <select id="tahun" class="form-select">
                                            <option value="">Semua</option>
                                            @foreach ($tahun as $th)
                                                <option value="{{ $th }}">{{ $th }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Tabel Prestasi --}}
                                <div class="table-responsive w-100 mt-4">
                                    <table class="table table-bordered" id="prestasiTable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Mahasiswa</th>
                                                <th>NIM</th>
                                                <th>Nama Prestasi</th>
                                                <th>Kategori</th>
                                                <th>Tanggal</th>
                                                <th>Tingkat</th>
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
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            var table = $('#prestasiTable').DataTable({
                responsive: true,
                scrollX: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('prestasi.filter.data') }}',
                    data: function(d) {
                        d.kategori = $('#kategori').val();
                        d.tahun = $('#tahun').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'nama',
                        name: 'mahasiswa.nama'
                    },
                    {
                        data: 'nim',
                        name: 'mahasiswa.nim'
                    },
                    {
                        data: 'nama_prestasi',
                        name: 'nama_prestasi'
                    },
                    {
                        data: 'kategori_prestasi',
                        name: 'kategori_prestasi'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'tingkat_prestasi',
                        name: 'tingkat_prestasi'
                    },
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

            $('#kategori_prestasi, #tahun').change(function() {
                table.draw();
            });
        });
    </script>
@endpush