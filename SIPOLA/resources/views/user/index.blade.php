@extends('layouts.template')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-xxl-12 mb-6 order-0">
            <div class="card">
                <div class="d-flex align-items-start row">
                    <div class="col-sm-12">
                        <div class="card-body min-vh-50">
                            <h5 class="card-title text-primary mb-3 fs-3">User Terdaftar</h5>
                            <div class="row">
                                <div class="col-md-8 mt-4 mb-5">
                                    <div class="form-group row">
                                        <label class="col-1 control-label col-form-label">Filter:</label>
                                        <div class="col-3">
                                            <select class="form-control" id="level_id" name="level_id" required>
                                                <option value="">- Semua - </option>
                                                <option value="1">Dosen Pembimbing</option>
                                                <option value="2">Mahasiswa</option>
                                            </select>
                                            <small class="form-text text-muted">Role User</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-end mb-5">
                                    <a href="javascript:void(0);"
                                        onclick="modalAction('{{ url('/user/create_ajax') }}')"
                                        class="btn btn-sm btn-outline-primary mt-3 mb-5 fs-6"> + Tambah User</a>
                                </div>
                                <div class="w-100 mt-5">
                                    <table class="table w-100 mt-5" id="userTable">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>NIM / NIDN</th>
                                                <th>NAMA</th>
                                                <th>ROLE USER</th>
                                                <th>AKSI</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            <tr>
                                                <td>1</td>
                                                <td>2341720056</td>
                                                <td>Rizkya Salsabila</td>
                                                <td>Mahasiswa</td>
                                                <td>
                                                    <a href="detail_ajax" class="btn btn-sm btn-info text-white"><i
                                                            class="bi bi-eye"></i><span class="ms-2">Lihat</span></a>
                                                    <a href="edit_ajax" class="btn btn-sm btn-warning text-white"><i
                                                            class="bi bi-pencil-square"></i><span
                                                            class="ms-2">Edit</span></a>
                                                    {{-- <a href="delete_ajax" class="btn btn-sm btn-danger text-white"><i
                                                            class="bi bi-trash"></i><span
                                                            class="ms-2">Hapus</span></a> --}}
                                                    <a href="javascript:void(0);" onclick="modalAction('{{ url('/confirm_ajax') }}')" class="btn btn-sm btn-danger text-white">
                                                        <i class="bi bi-trash"></i><span class="ms-2">Hapus</span>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>0120048501</td>
                                                <td>Yan Daffa Putra Liandhie, S.Kom., M.Kom</td>
                                                <td>Dosen Pembimbing</td>
                                                <td>
                                                    <a href="detail_ajax" class="btn btn-sm btn-info text-white"><i
                                                            class="bi bi-eye"></i><span class="ms-2">Lihat</span></a>
                                                    <a href="detail_ajax" class="btn btn-sm btn-warning text-white"><i
                                                            class="bi bi-pencil-square"></i><span
                                                            class="ms-2">Edit</span></a>
                                                    <a href="detail_ajax" class="btn btn-sm btn-danger text-white"><i
                                                            class="bi bi-trash"></i><span
                                                            class="ms-2">Hapus</span></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>2341720019</td>
                                                <td>Tyara Kusuma Nevada</td>
                                                <td>Mahasiswa</td>
                                                <td>
                                                    <a href="detail_ajax" class="btn btn-sm btn-info text-white"><i
                                                            class="bi bi-eye"></i><span class="ms-2">Lihat</span></a>
                                                    <a href="detail_ajax" class="btn btn-sm btn-warning text-white"><i
                                                            class="bi bi-pencil-square"></i><span
                                                            class="ms-2">Edit</span></a>
                                                    <a href="detail_ajax" class="btn btn-sm btn-danger text-white"><i
                                                            class="bi bi-trash"></i><span
                                                            class="ms-2">Hapus</span></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>0126038205</td>
                                                <td>Vanessa Cristin Natalia, S.Tr.Kom., M.Kom</td>
                                                <td>Dosen Pembimbing</td>
                                                <td>
                                                    <a href="detail_ajax" class="btn btn-sm btn-info text-white"><i
                                                            class="bi bi-eye"></i><span class="ms-2">Lihat</span></a>
                                                    <a href="detail_ajax" class="btn btn-sm btn-warning text-white"><i
                                                            class="bi bi-pencil-square"></i><span
                                                            class="ms-2">Edit</span></a>
                                                    <a href="detail_ajax" class="btn btn-sm btn-danger text-white"><i
                                                            class="bi bi-trash"></i><span
                                                            class="ms-2">Hapus</span></a>
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
        </div>
    </div>
    <div id="myModal" class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
@endpush

@push('js')
  <script>
      function modalAction(url = '') {
          $('#myModal').load(url, function() {
              const modalElement = document.getElementById('myModal');
              if (modalElement) {
                  const modalInstance = new bootstrap.Modal(modalElement);
                  modalInstance.show();
              } else {
                  console.error('Modal element not found!');
              }
          });
      }

      $(document).ready(function() {
          $('#userTable').DataTable({
              language: {
                  search: "Search:",
                  lengthMenu: "Show _MENU_ entries",
                  info: "Showing _START_ to _END_ of _TOTAL_ entries",
              }
          });
      });
  </script>
@endpush