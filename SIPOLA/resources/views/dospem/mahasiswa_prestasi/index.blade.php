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
                                <h5 class="card-title text-primary fs-3 m-0">Daftar Prestasi Mahasiswa Bimbingan</h5>
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
                                <table class="table w-100" id="table_mahasiswa_prestasi">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>NIM</th>
                                            <th>Program Studi</th>
                                            <th>Jumlah Prestasi</th>
                                            <th>Detail Prestasi</th>
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

    {{-- Modal untuk detail prestasi --}}
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
    div.dataTables_wrapper div.dataTables_length,
    div.dataTables_wrapper div.dataTables_filter {
        margin-top: 1rem;
    }
</style>
@endpush 

@push('js')
<script>
    // CSRF token untuk AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    // Menampilkan modal AJAX
    function modalAction(url = '') {
        $('#modalContent').html('<p class="text-center my-5">Loading...</p>');
        $('#myModal').modal('show');
        $.get(url, function (response) {
            $('#modalContent').html(response);
        });
    }

    // Inisialisasi DataTables
    var dataTable;
    $(document).ready(function () {
        dataTable = $('#table_mahasiswa_prestasi').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("dospem.mahasiswa_prestasi.list") }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                { data: 'nama', name: 'nama' },
                { data: 'nim', name: 'nim' },
                { data: 'program_studi', name: 'program_studi' },
                { data: 'jumlah_prestasi', name: 'jumlah_prestasi', className: 'text-center' },
                { data: 'detail_prestasi', name: 'detail_prestasi', orderable: false, searchable: false, className: 'text-center' },
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