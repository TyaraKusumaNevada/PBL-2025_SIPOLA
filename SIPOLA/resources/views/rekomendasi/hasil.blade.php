@extends('layouts.template')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Rekomendasi Lomba - Metode ARAS</h2>

    {{-- Tahap 1: Matriks Keputusan --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Tahap 1: Matriks Keputusan</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="table-secondary">
                        <tr>
                            <th>ALTERNATIF</th>
                            <th>C1 (Bidang)</th>
                            <th>C2 (Benefit)</th>
                            <th>C3 (Jenis)</th>
                            <th>C4 (Harga)</th>
                            <th>C5 (Syarat)</th>
                        </tr>
                        <tr class="table-light">
                            <th>Kriteria</th>
                            <th>Benefit</th>
                            <th>Benefit</th>
                            <th>Benefit</th>
                            <th>Cost</th>
                            <th>Benefit</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Iterasi data matriks keputusan --}}
                        @foreach($arasData['matriks_keputusan'] as $item)
                            <tr class="{{ $item['nama'] === 'A0' ? 'table-warning fw-bold' : '' }}">
                                <td>{{ $item['nama'] }}</td>
                                <td>{{ number_format($item['bidang'], 3) }}</td>
                                <td>{{ number_format($item['benefit'], 3) }}</td>
                                <td>{{ number_format($item['jenis'], 3) }}</td>
                                <td>{{ number_format($item['harga'], 3) }}</td>
                                <td>{{ number_format($item['syarat'], 3) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Tahap 2: Normalisasi Matriks --}}
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Tahap 2: Normalisasi Matriks</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="table-secondary">
                        <tr>
                            <th>ALTERNATIF</th>
                            <th>C1</th>
                            <th>C2</th>
                            <th>C3</th>
                            <th>C4 (Cost)</th>
                            <th>C5</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Iterasi data normalisasi --}}
                        @foreach($arasData['normalisasi'] as $item)
                            <tr class="{{ $item['nama'] === 'A0' ? 'table-warning fw-bold' : '' }}">
                                <td>{{ $item['nama'] }}</td>
                                <td>{{ number_format($item['bidang'], 3) }}</td>
                                <td>{{ number_format($item['benefit'], 3) }}</td>
                                <td>{{ number_format($item['jenis'], 3) }}</td>
                                <td class="bg-light">{{ number_format($item['harga'], 3) }}</td>
                                <td>{{ number_format($item['syarat'], 3) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Bobot Kriteria --}}
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <h4 class="mb-0">Bobot Kriteria</h4>
        </div>
        <div class="card-body">
            <div class="row">
                {{-- Iterasi bobot global --}}
                @foreach($arasData['bobot_global'] as $kriteria => $bobot)
                    <div class="col-md-2 text-center mb-2">
                        <div class="border p-2 rounded">
                            <strong>{{ strtoupper($kriteria) }}</strong><br>
                            @if($kriteria == 'harga')
                                <span class="badge bg-danger">{{ number_format($bobot, 3) }} (Cost)</span>
                            @else
                                <span class="badge bg-primary">{{ number_format($bobot, 3) }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Tahap 3: Normalisasi Terbobot --}}
    <div class="card mb-4">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">Tahap 3: Normalisasi Terbobot</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="table-secondary">
                        <tr>
                            <th>ALTERNATIF</th>
                            <th>C1 (×0.4)</th>
                            <th>C2 (×0.2)</th>
                            <th>C3 (×0.15)</th>
                            <th>C4 (×0.15)</th>
                            <th>C5 (×0.1)</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Iterasi data normalisasi terbobot --}}
                        @foreach($arasData['normalisasi_terbobot'] as $item)
                            <tr class="{{ $item['nama'] === 'A0' ? 'table-warning fw-bold' : '' }}">
                                <td>{{ $item['nama'] }}</td>
                                <td>{{ number_format($item['bidang'], 3) }}</td>
                                <td>{{ number_format($item['benefit'], 3) }}</td>
                                <td>{{ number_format($item['jenis'], 3) }}</td>
                                <td class="bg-light">{{ number_format($item['harga'], 3) }}</td>
                                <td>{{ number_format($item['syarat'], 3) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Tahap 4: Menghitung Nilai Utilitas --}}
    <div class="card mb-4">
        <div class="card-header bg-danger text-white">
            <h4 class="mb-0">Tahap 4: Menghitung Nilai Utilitas</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="table-secondary">
                        <tr>
                            <th>ALTERNATIF</th>
                            <th>C1</th>
                            <th>C2</th>
                            <th>C3</th>
                            <th>C4</th>
                            <th>C5</th>
                            <th class="table-success">Si</th>
                            <th class="table-warning">Ki</th>
                            <th class="table-danger">RANK</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Tampilkan A0 terlebih dahulu --}}
                        <tr class="table-warning fw-bold">
                            <td>A0</td>
                            <td>{{ number_format($arasData['normalisasi_terbobot'][0]['bidang'], 3) }}</td>
                            <td>{{ number_format($arasData['normalisasi_terbobot'][0]['benefit'], 3) }}</td>
                            <td>{{ number_format($arasData['normalisasi_terbobot'][0]['jenis'], 3) }}</td>
                            <td class="bg-light">{{ number_format($arasData['normalisasi_terbobot'][0]['harga'], 3) }}</td>
                            <td>{{ number_format($arasData['normalisasi_terbobot'][0]['syarat'], 3) }}</td>
                            <td class="table-success fw-bold">{{ number_format($arasData['s0'], 3) }}</td>
                            <td class="table-warning fw-bold">1.000</td>
                            <td class="table-danger fw-bold">OPTIMAL</td>
                        </tr>
                        {{-- Tampilkan alternatif lainnya --}}
                        @foreach($hasil as $index => $item)
                            @php
                                $altIndex = $index + 1;
                            @endphp
                            <tr class="{{ $item['ranking'] <= 3 ? 'table-light' : '' }}">
                                <td>A{{ $altIndex }}</td>
                                <td>{{ number_format($arasData['normalisasi_terbobot'][$altIndex]['bidang'], 3) }}</td>
                                <td>{{ number_format($arasData['normalisasi_terbobot'][$altIndex]['benefit'], 3) }}</td>
                                <td>{{ number_format($arasData['normalisasi_terbobot'][$altIndex]['jenis'], 3) }}</td>
                                <td class="bg-light">{{ number_format($arasData['normalisasi_terbobot'][$altIndex]['harga'], 3) }}</td>
                                <td>{{ number_format($arasData['normalisasi_terbobot'][$altIndex]['syarat'], 3) }}</td>
                                <td class="table-success">{{ number_format($item['si'], 3) }}</td>
                                <td class="table-warning">{{ number_format($item['ki'], 3) }}</td>
                                <td class="table-danger fw-bold">{{ $item['ranking'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Hasil Rekomendasi Final --}}
    <div class="card mb-4">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">Hasil Rekomendasi Final</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">Ranking</th>
                            <th>Nama Lomba</th>
                            <th>Tingkat</th>
                            <th>Jenis</th>
                            <th>Bidang</th>
                            <th>Benefit</th>
                            <th>Harga</th>
                            <th>Syarat</th>
                            <th class="text-center">Si</th>
                            <th class="text-center">Ki</th>
                            <th class="text-center">% Optimal</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Iterasi hasil ranking final --}}
                        @foreach($hasil as $item)
                            <tr class="{{ $item['ranking'] == 1 ? 'table-success' : ($item['ranking'] == 2 ? 'table-info' : ($item['ranking'] == 3 ? 'table-warning' : '')) }}">
                                <td class="text-center">
                                    @if($item['ranking'] == 1)
                                        <span class="badge bg-success fs-6">🏆 #{{ $item['ranking'] }}</span>
                                    @elseif($item['ranking'] == 2)
                                        <span class="badge bg-info fs-6">🥈 #{{ $item['ranking'] }}</span>
                                    @elseif($item['ranking'] == 3)
                                        <span class="badge bg-warning fs-6">🥉 #{{ $item['ranking'] }}</span>
                                    @else
                                        <span class="badge bg-secondary fs-6">#{{ $item['ranking'] }}</span>
                                    @endif
                                </td>
                                <td><strong>{{ $item['lomba']['nama'] }}</strong></td>
                                <td>{{ ucfirst($item['lomba']['tingkat']) }}</td>
                                <td>{{ ucfirst($item['lomba']['jenis']) }}</td>
                                <td>{{ $item['lomba']['bidang'] }}</td>
                                <td>{{ $item['lomba']['benefit'] }}</td>
                                <td>
                                    @if($item['lomba']['harga'] == 0)
                                        <span class="badge bg-success">GRATIS</span>
                                    @else
                                        Rp {{ number_format($item['lomba']['harga'], 0, ',', '.') }}
                                    @endif
                                </td>
                                <td>{{ ucfirst($item['lomba']['syarat']) }}</td>
                                <td class="text-center"><strong>{{ number_format($item['si'], 3) }}</strong></td>
                                <td class="text-center"><strong>{{ number_format($item['ki'], 3) }}</strong></td>
                                <td class="text-center">
                                    <span class="badge {{ $item['ki'] >= 0.8 ? 'bg-success' : ($item['ki'] >= 0.6 ? 'bg-warning' : 'bg-secondary') }}">
                                        {{ number_format($item['ki'] * 100, 1) }}%
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- Bagian rekomendasi terbaik --}}
            @if(count($hasil) > 0)
                <div class="alert alert-success mt-3">
                    <h5><i class="fas fa-trophy"></i> Rekomendasi Terbaik:</h5>
                    <div class="row">
                        <div class="col-md-8">
                            <p class="mb-1">
                                <strong class="fs-5">{{ $hasil[0]['lomba']['nama'] }}</strong>
                            </p>
                            <p class="mb-1">
                                <span class="badge bg-primary">{{ ucfirst($hasil[0]['lomba']['tingkat']) }}</span>
                                <span class="badge bg-info">{{ $hasil[0]['lomba']['bidang'] }}</span>
                                <span class="badge bg-secondary">{{ ucfirst($hasil[0]['lomba']['jenis']) }}</span>
                            </p>
                            <p class="mb-0">
                                <strong>Harga:</strong> 
                                @if($hasil[0]['lomba']['harga'] == 0)
                                    <span class="text-success">GRATIS</span>
                                @else
                                    Rp {{ number_format($hasil[0]['lomba']['harga'], 0, ',', '.') }}
                                @endif
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="bg-white p-2 rounded border">
                                <div><strong>Nilai Ki:</strong> {{ number_format($hasil[0]['ki'], 3) }}</div>
                                <div><strong>Efektivitas:</strong> {{ number_format($hasil[0]['ki'] * 100, 1) }}%</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 