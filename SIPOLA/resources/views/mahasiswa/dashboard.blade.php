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
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0"> Lomba Aktif Terbaru</h5>
    </div>
    <div class="card-body px-0 position-relative" style="overflow-x: hidden;">
      <button class="scroll-btn scroll-left btn btn-outline-secondary"
        style="position:absolute; top:50%; left:0; transform:translateY(-50%); z-index:10;">
        <i class="bx bx-chevron-left"></i>
      </button>
      <button class="scroll-btn scroll-right btn btn-outline-secondary"
        style="position:absolute; top:50%; right:0; transform:translateY(-50%); z-index:10;">
        <i class="bx bx-chevron-right"></i>
      </button>

      <div class="scroll-wrapper">
        <div class="scroll-container px-4">
          @foreach ($lomba_terbaru as $lomba)
            <div class="lomba-card">
              <img src="{{ asset('storage/pamflet_lomba/' . $lomba->pamflet_lomba) }}" alt="{{ $lomba->nama_lomba }}">
              <div class="card-body">
                <div class="lomba-title">{{ $lomba->nama_lomba }}</div>
                <div><span class="badge badge-deadline">Sampai {{ \Carbon\Carbon::parse($lomba->tanggal_selesai)->translatedFormat('d M Y') }}</span></div>
                <div class="text-muted mt-1" style="font-size: 0.85rem">{{ $lomba->penyelenggara_lomba }}</div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
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

@push('css')
<style>
  .scroll-wrapper {
    overflow-x: auto;
    width: 100%;
    position: relative;
  }

  .scroll-wrapper::-webkit-scrollbar {
    display: none;
  }

  .scroll-container {
    display: flex;
    gap: 1rem;
    padding-bottom: 1rem;
    scroll-snap-type: x mandatory;
    scroll-behavior: smooth;
    min-height: 100%;
  }

  .lomba-card {
    flex: 0 0 auto;
    width: 250px;
    scroll-snap-align: start;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    background-color: #fff;
    transition: transform 0.2s;
  }

  .lomba-card:hover {
    transform: scale(1.05);
  }

  .lomba-card img {
    width: 100%;
    height: 180px;
    object-fit: contain;
    background-color: #f8f9fa;
  }

  .lomba-card .card-body {
    padding: 0.75rem;
  }

  .lomba-title {
    font-size: 1rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
  }

  .badge-deadline {
    font-size: 0.75rem;
    background-color: #ffc107;
    color: #000;
  }

  .scroll-btn {
    display: none;
  }

  @media (min-width: 768px) {
    .scroll-btn {
      display: inline-block;
    }
  }
</style>
@endpush

@push('js')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const scrollContainer = document.querySelector('.scroll-container');
    const scrollLeftBtn = document.querySelector('.scroll-left');
    const scrollRightBtn = document.querySelector('.scroll-right');
    let autoScrollInterval;
    let direction = 1; // 1: scroll right, -1: scroll left

    function startAutoScroll() {
      autoScrollInterval = setInterval(() => {
        if (scrollContainer.scrollLeft + scrollContainer.clientWidth >= scrollContainer.scrollWidth) {
          scrollContainer.scrollLeft = 0; // kembali ke awal
        } else {
          scrollContainer.scrollBy({
            left: 2,
            behavior: 'smooth'
          });
        }
      }, 50);
    }


    function stopAutoScroll() {
      clearInterval(autoScrollInterval);
    }

    scrollContainer.addEventListener('mouseenter', stopAutoScroll);
    scrollContainer.addEventListener('mouseleave', startAutoScroll);

    scrollLeftBtn.addEventListener('click', () => {
      scrollContainer.scrollBy({ left: -300, behavior: 'smooth' });
    });

    scrollRightBtn.addEventListener('click', () => {
      scrollContainer.scrollBy({ left: 300, behavior: 'smooth' });
    });

    function toggleScrollButtons() {
      const isOverflowing = scrollContainer.scrollWidth > scrollContainer.clientWidth;
      scrollLeftBtn.style.display = isOverflowing ? 'inline-block' : 'none';
      scrollRightBtn.style.display = isOverflowing ? 'inline-block' : 'none';
    }

    window.addEventListener('resize', toggleScrollButtons);
    toggleScrollButtons();
    startAutoScroll(); // aktif saat pertama
  });
</script>
@endpush
