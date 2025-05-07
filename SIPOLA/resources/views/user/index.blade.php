@extends('layouts.template')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-xxl-12 mb-6 order-0">
      <div class="card">
        <div class="card-body min-vh-50">
          <h5 class="card-title text-primary mb-3 fs-3">User Terdaftar</h5>
          <a href="{{ url('/user/create_ajax') }}"
             class="btn btn-sm btn-outline-primary mt-3 mb-4 fs-6">
            + Tambah Prestasi
          </a>

          {{-- Filter --}}
          <div class="row mb-4">
            <div class="col-md-4">
              <label for="level_id" class="form-label">Filter:</label>
              <select class="form-control" id="level_id" name="level_id" required>
                <option value="">- Semua -</option>
                <option value="1">Dosen Pembimbing</option>
                <option value="2">Mahasiswa</option>
              </select>
              <small class="form-text text-muted">Role User</small>
            </div>
          </div>

          {{-- Tabel dengan padding --}}
          <div class="table-responsive px-3 pb-3">
            <table class="table table-bordered table-hover mb-0" id="userTable">
              <thead>
                <tr>
                  <th>NO</th>
                  <th>USERNAME</th>
                  <th>NAMA</th>
                  <th>ROLE USER</th>
                  <th>AKSI</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-1">
                <tr>
                  <td>1</td>
                  <td>2341720056</td>
                  <td>Rizkya Salsabila</td>
                  <td>Mahasiswa</td>
                  <td>
                    <a href="detail_ajax" class="btn btn-sm btn-info text-white">
                      <i class="bi bi-eye"></i> Lihat
                    </a>
                    <a href="detail_ajax" class="btn btn-sm btn-warning text-white">
                      <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <a href="detail_ajax" class="btn btn-sm btn-danger text-white">
                      <i class="bi bi-trash"></i> Hapus
                    </a>
                  </td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>2341720050</td>
                  <td>nepa</td>
                  <td>Dosen</td>
                  <td>
                    <a href="detail_ajax" class="btn btn-sm btn-info text-white">
                      <i class="bi bi-eye"></i> Lihat
                    </a>
                    <a href="detail_ajax" class="btn btn-sm btn-warning text-white">
                      <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <a href="detail_ajax" class="btn btn-sm btn-danger text-white">
                      <i class="bi bi-trash"></i> Hapus
                    </a>
                  </td>
                </tr>
                
                
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script>
  $(document).ready(function () {
    $('#userTable').DataTable({
      // custom DOM untuk memberi jarak antara length menu dan search
      dom:
        '<\"row mb-3\"<\"col-sm-6\"l><\"col-sm-6 text-end\"f>>' + 
        'rtip',
      language: {
        search: "Search:",
        lengthMenu: "Show _MENU_ entries",
        info: "Showing _START_ to _END_ of _TOTAL_ entries",
      }
    });
  });
</script>
@endpush
