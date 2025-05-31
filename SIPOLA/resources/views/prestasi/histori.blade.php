@extends('layouts.template')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xxl-12 mb-6 order-0">
                <div class="card">
                    <div class="d-flex align-items-start row">
                        <div class="col-sm-12">
                            <div class="card-body min-vh-50">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title text-primary fs-3 mb-5">{{ $breadcrumb->title }}</h5>
                                    <a href="javascript:void(0);" onclick="modalAction('{{ url('/prestasi/create_ajax') }}')"
                                        class="btn btn-sm btn-outline-primary fs-6 mb-5">+ Tambah</a>
                                </div>

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

                                <div class="w-100 mt-5">
                                    <table class="table w-100 mt-5" id="table-prestasi">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>NAMA PRESTASI</th>
                                                <th>KATEGORI</th>
                                                <th>TINGKAT</th>
                                                <th>PENYELENGGARA</th>
                                                <th>TANGGAL</th>
                                                <th>STATUS</th>
                                                <th>AKSI</th>
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

        <!-- Modal Container -->
        <div id="myModal" class="modal fade" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content" id="modalContent">
                    {{-- Konten AJAX akan dimuat di sini --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // CSRF untuk semua request AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        // Menampilkan modal AJAX
        function modalAction(url = '') {
            $('#modalContent').load(url, function() {
                const modal = new bootstrap.Modal(document.getElementById('myModal'), {
                    backdrop: 'static',
                    keyboard: false
                });
                modal.show();
            });
        }

        // Inisialisasi DataTable
        var dataPrestasi;
        $(document).ready(function() {
            dataPrestasi = $('#table-prestasi').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ url('prestasi/list') }}",
                    type: "POST",
                    dataType: "json"
                },
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex", // ini penting untuk server-side
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "nama_prestasi",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "kategori_prestasi",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "tingkat_prestasi",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "penyelenggara",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "tanggal",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "status",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "aksi",
                        className: "",
                        orderable: false,
                        searchable: false
                    },
                ],
                columnDefs: [{
                        width: "5%",
                        targets: 0
                    }, // No
                    {
                        width: "16%",
                        targets: 1
                    }, // Nama Prestasi
                    {
                        width: "10%",
                        targets: 2
                    }, // Kategori
                    {
                        width: "10%",
                        targets: 3
                    }, // Tingkat
                    {
                        width: "17%",
                        targets: 4
                    }, // Penyelenggara
                    {
                        width: "12%",
                        targets: 5
                    }, // Tanggal
                    {
                        width: "10%",
                        targets: 6
                    }, // Status
                    {
                        width: "20%",
                        targets: 7
                    } // Aksi
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
        });
    </script>
@endpush