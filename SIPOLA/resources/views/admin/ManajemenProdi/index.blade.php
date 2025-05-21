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
                                <h5 class="card-title text-primary fs-3 m-0">Program Studi Terdaftar</h5>
                                <a href="javascript:void(0);" onclick="modalAction('{{ url('admin/ManajemenProdi/create_ajax') }}')" class="btn btn-sm btn-outline-primary fs-6">+ Tambah Program Studi</a>
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

                            <div class="row mb-4">
                                <label class="col-auto col-form-label">Filter Jenjang:</label>
                                <div class="col-auto">
                                    <select class="form-select form-select-sm filter_jenjang">
                                        <option value="">- Semua -</option>
                                        <option>D4</option>
                                        <option>D3</option>
                                        <option>D2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="w-100 mt-3">
                                <table id="program_studi" class="table w-100 table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th>NAMA PRODI</th>
                                            <th>JENJANG</th>
                                            <th class="text-center">AKSI</th>
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

    <!-- Modal -->
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    function modalAction(url = '') {
        $('#modalContent').load(url, function () {
            const modal = new bootstrap.Modal(document.getElementById('myModal'), {
                backdrop: 'static',
                keyboard: false
            });
            modal.show();
        });
    }

    let dataProdi;
    $(document).ready(function () {
        dataProdi = $('#program_studi').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: "{{ url('admin/ManajemenProdi/list') }}",
                data: function (d) {
                    d.jenjang = $('.filter_jenjang').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', className: 'text-center', orderable: false, searchable: false },
                { data: 'nama_prodi', className: '', orderable: true, searchable: true },
                { data: 'jenjang', className: '', orderable: true, searchable: true },
                {
                    data: null,
                    className: 'text-center',
                    orderable: false,
                    render: function (_, __, row) {
                        const base = "{{ url('admin/ManajemenProdi') }}";
                        return `
                            <button onclick="modalAction('${base}/${row.id_prodi}/show_ajax')" class="btn btn-sm btn-info">Detail</button>
                            <button onclick="modalAction('${base}/${row.id_prodi}/edit_ajax')" class="btn btn-sm btn-warning">Edit</button>
                            <button onclick="modalAction('${base}/${row.id_prodi}/confirm_ajax')" class="btn btn-sm btn-danger">Delete</button>
                        `;
                    }
                }
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

        $('.filter_jenjang').on('change', function () {
            dataProdi.draw();
        });

        $('#program_studi_filter input').off('keyup').on('keyup', function (e) {
            if (e.keyCode === 13) dataProdi.search(e.target.value).draw();
        });
    });
</script>
@endpush
