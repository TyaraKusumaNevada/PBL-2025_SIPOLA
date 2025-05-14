@extends('layouts.template')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>User Terdaftar</h4>
            <button id="btnTambahUser" class="btn btn-primary">+ Tambah User</button>
            
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3">
                    <select id="roleFilter" class="form-select">
                        <option value="">-Semua-</option>
                        <option value="mahasiswa">Mahasiswa</option>
                        <option value="dospem">Dosen Pembimbing</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>

            <table class="table table-bordered table-striped" id="userTable">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NIM / NIDN</th>
                        <th>NAMA</th>
                        <th>ROLE USER</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp

                    @foreach($mahasiswa as $data)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $data->nim }}</td>
                            <td>{{ $data->nama }}</td>
                            <td>Mahasiswa</td>
                            <td>
                                <button class="btn btn-info btn-sm">👁️ Lihat</button>
                                <button class="btn btn-warning btn-sm">✏️ Edit</button>
                                <button class="btn btn-danger btn-sm">🗑️ Hapus</button>
                            </td>
                        </tr>
                    @endforeach

                    @foreach($dospem as $data)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $data->nidn }}</td>
                            <td>{{ $data->nama }}</td>
                            <td>Dosen Pembimbing</td>
                            <td>
                                <button class="btn btn-info btn-sm">👁️ Lihat</button>
                                <button class="btn btn-warning btn-sm">✏️ Edit</button>
                                <button class="btn btn-danger btn-sm">🗑️ Hapus</button>
                            </td>
                        </tr>
                    @endforeach

                    @foreach($admin as $data)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $data->nip ?? '-' }}</td>
                            <td>{{ $data->nama }}</td>
                            <td>Admin</td>
                            <td>
                                <button class="btn btn-info btn-sm">👁️ Lihat</button>
                                <button class="btn btn-warning btn-sm">✏️ Edit</button>
                                <button class="btn btn-danger btn-sm">🗑️ Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


{{-- Optional: filter pakai jQuery --}}
<script>
    // Filter role (yang sudah ada)
    document.getElementById('roleFilter').addEventListener('change', function () {
        const filter = this.value.toLowerCase();
        document.querySelectorAll('#userTable tbody tr').forEach(function (row) {
            const role = row.children[3].textContent.toLowerCase();
            row.style.display = (filter === "" || filter === role) ? "" : "none";
        });
    });

    // Tombol Tambah User (baru)
    $('#btnTambahUser').on('click', function () {
        $.get("{{ route('user.create_ajax') }}", function (res) {
            $('#modalUser .modal-body').html(res);
            $('#modalUser').modal('show');
        });
    });
</script>
<!-- Modal Tambah User -->
<div class="modal fade" id="modalUser" tabindex="-1" aria-labelledby="modalUserLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- form akan dimuat via AJAX -->
      </div>
    </div>
  </div>
</div>
@endsection
