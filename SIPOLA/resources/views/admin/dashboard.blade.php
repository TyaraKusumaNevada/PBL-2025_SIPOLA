@extends('layouts.template') 
@section('title', 'Dashboard Admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold">Dashboard Admin</h4>

    <div class="row mt-4">
        {{-- Kartu ringkasan --}}
        @php
            $cards = [
                ['label' => 'Mahasiswa', 'value' => $jumlah_mahasiswa, 'icon' => 'users'],
                ['label' => 'Dosen Pembimbing', 'value' => $jumlah_dospem, 'icon' => 'user-check'],
                ['label' => 'Prestasi', 'value' => $jumlah_prestasi, 'icon' => 'award'],
                ['label' => 'Lomba Aktif', 'value' => $lomba_aktif_diikuti, 'icon' => 'calendar-check'],
            ];
        @endphp

        @foreach($cards as $card)
        <div class="col-md-4 col-lg-3 mb-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="fas fa-{{ $card['icon'] }} fa-2x text-primary mb-2"></i>
                    <h5>{{ $card['label'] }}</h5>
                    <h3 class="fw-bold">{{ $card['value'] }}</h3>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Tabel Prestasi Terbaru --}}
    <div class="card mt-4">
        <div class="card-header">Prestasi Terbaru</div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Mahasiswa</th>
                        <th>Judul</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($prestasi_terbaru as $p)
                        <tr>
                            <td>{{ $p->mahasiswa->nama ?? '-' }}</td>
                            <td>{{ $p->judul }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3">Tidak ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Tabel Lomba Terbaru --}}
    <div class="card mt-4">
        <div class="card-header">Lomba Terbaru Diikuti</div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Mahasiswa</th>
                        <th>Nama Lomba</th>
                        <th>Tanggal Mulai</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lomba_terbaru as $l)
                        <tr>
                            <td>{{ $l->mahasiswa->nama ?? '-' }}</td>
                            <td>{{ $l->info_lomba->nama_lomba ?? '-' }}</td>
                            <td>{{ optional($l->infoLomba)->tanggal_mulai ? \Carbon\Carbon::parse($l->infoLomba->tanggal_mulai)->format('d M Y') : '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3">Tidak ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
