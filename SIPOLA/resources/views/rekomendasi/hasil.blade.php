@extends('layouts.template')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Matriks Awal (Bobot berdasarkan preferensi user)</h3>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Nama</th>
                    <th>Tingkat</th>
                    <th>Jenis (Bobot)</th>
                    <th>Bidang (Bobot)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($matriks as $item)
                    <tr>
                        <td>{{ $item['nama'] }}</td>
                        <td>{{ ucfirst($item['tingkat']) }}</td>
                        <td>{{ number_format($item['jenis'], 2) }}</td>
                        <td>{{ number_format($item['bidang'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <hr class="my-5">

    <h3 class="mb-3">Hasil Rekomendasi</h3>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Nama</th>
                    <th>Tingkat</th>
                    <th>Jenis</th>
                    <th>Bidang</th>
                    <th>Skor</th> 
                    <th>Skor Relatif</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hasil as $item)
                    <tr>
                        <td>{{ $item['lomba']['nama'] }}</td>
                        <td>{{ ucfirst($item['lomba']['tingkat']) }}</td>
                        <td>{{ ucfirst($item['lomba']['jenis']) }}</td>
                        <td>{{ $item['lomba']['bidang'] }}</td>
                        <td>{{ number_format($item['skor'], 4) }}</td>
                        <td>{{ number_format($item['skor_relatif'], 4) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
