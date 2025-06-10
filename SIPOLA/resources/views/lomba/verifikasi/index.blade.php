@extends('layouts.template')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xxl-12 mb-6 order-0">
                <div class="card">
                    <div class="d-flex align-items-start row">
                        <div class="col-sm-12">
                            <div class="card-body min-vh-50 mb-5">
                                <div class="d-flex justify-content-between align-items-center mb-5">
                                    <h5 class="card-title text-primary fs-3 m-0">Verifikasi Info Lomba</h5>
                                </div>

                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                <div class="w-100 mt-5">
                                    <table class="table w-100" id="verifikasiTable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Lomba</th>
                                                <th>Penyelenggara</th>
                                                <th>Kategori</th>
                                                <th>Tingkat</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
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

@push('css')
    <style>
        /* Tambah margin atas pada bagian kontrol DataTable */
        div.dataTables_wrapper div.dataTables_length,
        div.dataTables_wrapper div.dataTables_filter {
            margin-top: 1rem;
        }
    </style>
@endpush

@push('js')
    <script>
        // CSRF Token untuk semua request AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        // Fungsi buka modal AJAX
        function modalAction(url = '') {
            $('#modalContent').load(url, function () {
                const modal = new bootstrap.Modal(document.getElementById('myModal'), {
                    backdrop: 'static',
                    keyboard: false
                });
                modal.show();
            });
        }

        // Inisialisasi DataTables
        var dataVerifikasiLomba;
        $(document).ready(function () {
            dataVerifikasiLomba = $('#verifikasiTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('lomba/verifikasi/list') }}",
                    type: "POST",
                    dataType: "json",
                },
                columns: [
                    { data: 'DT_RowIndex', className: 'text-center', orderable: false, searchable: false, width: "5%" },
                    { data: 'nama_lomba', width: "12%" },
                    { data: 'penyelenggara_lomba', width: "10%" },
                    { data: 'kategori_lomba', width: "10%" },
                    { data: 'tingkat_lomba', width: "10%" },
                    { data: 'status_verifikasi', orderable: false, searchable: false, width: "10%" },
                    { data: 'aksi', orderable: false, searchable: false, width: "33%" }
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