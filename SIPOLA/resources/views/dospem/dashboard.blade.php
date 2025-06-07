@extends('layouts.template')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3">Dashboard Dosen Pembimbing</h4>

  {{-- Info Box --}}
  <div class="row">
    <div class="col-md-3">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Mahasiswa Bimbingan</h5>
          <h3>{{ $total_mahasiswa }}</h3>
        </div>
      </div>
    </div>
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
          <h5 class="card-title">Prestasi Disetujui</h5>
          <h3>{{ $prestasi_disetujui }}</h3>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Prestasi Pending</h5>
          <h3>{{ $prestasi_pending }}</h3>
        </div>
      </div>
    </div>
  </div>

  {{-- Prestasi Terbaru --}}
  <div class="card mt-4">
    <div class="card-header">
      <h5>Riwayat Prestasi Mahasiswa</h5>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Nama Mahasiswa</th>
            <th>Prestasi</th>
            <th>Kategori</th>
            <th>Tingkat</th>
            <th>Tanggal</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($recent_prestasi as $prestasi)
          <tr>
            <td>{{ $prestasi->mahasiswa->nama ?? '-' }}</td>
            <td>{{ $prestasi->nama_prestasi }}</td>
            <td>{{ $prestasi->kategori_prestasi }}</td>
            <td>{{ $prestasi->tingkat_prestasi }}</td>
            <td>{{ \Carbon\Carbon::parse($prestasi->tanggal)->format('d M Y') }}</td>
            <td>
              @if ($prestasi->status == 'Disetujui')
                <span class="badge bg-success">Disetujui</span>
              @elseif ($prestasi->status == 'Ditolak')
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
