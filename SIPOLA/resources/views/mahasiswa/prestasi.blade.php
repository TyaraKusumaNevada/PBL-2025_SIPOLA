@extends('layouts.template')

@section('content')
<style>
    table.table thead th {
        text-transform: none !important;
        color: white;
    }
</style>
<div class="row">
    <div class="col-12">
        <div class="card p-4 min-vh-100">
            <div class="col-md-12 d-flex justify-content-end align-items-center">
                <img src="{{ asset('template/assets/img/avatars/1.png') }}" alt="Foto Mahasiswa" 
                     class="rounded-circle me-3" 
                     style="width: 60px; height: 60px; object-fit: cover;">
                <p class="text-muted fs-4 mb-0">Rizkya Salsabila</p>
            </div>
            <div class="container my-5">
                <h2 class="mb-4" style="color: #8B5CF6">Daftar Prestasi Anda</h2>
              
                <div class="d-flex justify-content-end mb-3">
                  <a href="#" class="btn" style="background-color: #8B5CF6; color: white">+ Tambah Prestasi</a>
                </div>
              
                <table class="table table-bordered table-striped">
                  <thead class="text-center" style="background-color: #8B5CF6;">
                    <tr>
                      <th class="fs-6">No</th>
                      <th class="fs-6">Nama Prestasi</th>
                      <th class="fs-6">Kategori</th>
                      <th class="fs-6">Tanggal</th>
                      <th class="fs-6">Status</th>
                      <th class="fs-6">Aksi</th>
                    </tr>
                  </thead>
                  <tbody class="fs-6">
                    <tr>
                      <td>1</td>
                      <td>Juara 1 Lomba Debat</td>
                      <td>Non-Akademik</td>
                      <td>12 Maret 2025</td>
                      <td><span class="badge bg-success">Diverifikasi</span></td>
                      <td>
                        <a href="#" class="btn btn-sm btn-info text-white">Lihat</a>
                      </td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>IPK Semester 1: 3.90</td>
                      <td>Akademik</td>
                      <td>10 Februari 2025</td>
                      <td><span class="badge bg-warning text-dark">Diproses</span></td>
                      <td>
                        <a href="#" class="btn btn-sm btn-info text-white">Lihat</a>
                      </td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td>Finalis Olimpiade Matematika</td>
                      <td>Akademik</td>
                      <td>3 Januari 2025</td>
                      <td><span class="badge bg-danger">Ditolak</span></td>
                      <td>
                        <a href="#" class="btn btn-sm btn-info text-white">Lihat</a>
                      </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Juara 1 Lomba Programming</td>
                        <td>Akademik</td>
                        <td>10 Februari 2025</td>
                        <td><span class="badge bg-success">Diterima</span></td>
                        <td>
                          <a href="#" class="btn btn-sm btn-info text-white">Lihat</a>
                        </td>
                      </tr>
                      <tr>
                        <td>5</td>
                        <td>Finalis Hackathon Nasional</td>
                        <td>Non-Akademik</td>
                        <td>20 Maret 2025</td>
                        <td><span class="badge bg-warning text-dark">Diproses</span></td>
                        <td>
                          <a href="#" class="btn btn-sm btn-info text-white">Lihat</a>
                        </td>
                      </tr>
                      <tr>
                        <td>6</td>
                        <td>Peserta Workshop Cyber Security</td>
                        <td>Akademik</td>
                        <td>5 April 2025</td>
                        <td><span class="badge bg-success">Diterima</span></td>
                        <td>
                          <a href="#" class="btn btn-sm btn-info text-white">Lihat</a>
                        </td>
                      </tr>
                  </tbody>
                </table>
              </div>
        </div>
    </div>
</div>

@endsection