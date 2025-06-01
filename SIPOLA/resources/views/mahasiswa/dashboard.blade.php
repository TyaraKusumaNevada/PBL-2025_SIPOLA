@extends('layouts.template') 

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3">Dashboard Mahasiswa</h4>

  {{-- Info Boxes --}}
  <div class="row">
    <div class="col-md-3">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Total Prestasi</h5>
          <h3>{{ $total_prestasi }}</h3>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Prestasi Terverifikasi</h5>
          <h3>{{ $prestasi_verified }}</h3>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Lomba Diikuti</h5>
          <h3>{{ $total_lomba_diikuti }}</h3>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Lomba Aktif</h5>
          <h3>{{ $lomba_aktif }}</h3>
        </div>
      </div>
    </div>
  </div>

  {{-- Daftar Lomba Aktif --}}
  <div class="card mt-4">
    <div class="card-header">
      <h5>Lomba Aktif</h5>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Nama Lomba</th>
            <th>Deadline</th>
            <th>Penyelenggara</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($lomba_terbaru as $lomba)
          <tr>
            <td>{{ $lomba->nama_lomba }}</td>
            <td>{{ \Carbon\Carbon::parse($lomba->tanggal_selesai)->format('d M Y') }}</td>
            <td>{{ $lomba->penyelenggara_lomba }}</td>
            <td><span class="badge bg-success">Dibuka</span></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  {{-- Riwayat Prestasi --}}
  <div class="card mt-4">
    <div class="card-header">
      <h5>Riwayat Prestasi</h5>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Prestasi</th>
            <th>Kategori</th>
            <th>Tingkat</th>
            <th>Tanggal</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($riwayat_prestasi as $prestasi)
          <tr>
            <td>{{ $prestasi->nama_prestasi }}</td>
            <td>{{ $prestasi->kategori_prestasi }}</td>
            <td>{{ $prestasi->tingkat_prestasi }}</td>
            <td>{{ \Carbon\Carbon::parse($prestasi->tanggal)->format('d M Y') }}</td>
            <td>
              @php
                $verif = $prestasi->verifikasi ?? null;
              @endphp
              @if ($verif && $verif->status == 'Disetujui')
                <span class="badge bg-success">Terverifikasi</span>
              @elseif ($verif && $verif->status == 'Ditolak')
                <span class="badge bg-danger">Ditolak</span>
              @else
                <span class="badge bg-warning text-dark">Pending</span>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

</div>
@endsection
