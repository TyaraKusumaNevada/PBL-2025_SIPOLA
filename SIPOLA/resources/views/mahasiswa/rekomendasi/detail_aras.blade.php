{{-- <table class="table table-bordered table-sm">
    <thead>
        <tr>
            <th>Kriteria</th>
            <th>Nilai</th>
            <th>Bobot</th>
            <th>Skor Akhir</th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0; @endphp
        @foreach ($data as $key => $value)
            @php
                $w = $bobot['bobot_' . $key] ?? 0;
                $score = $value * $w;
                $total += $score;
            @endphp
            <tr>
                <td>{{ ucfirst($key) }}</td>
                <td>{{ $value }}</td>
                <td>{{ $w }}</td>
                <td>{{ number_format($score, 4) }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr class="table-success">
            <td colspan="3"><strong>Total Skor</strong></td>
            <td><strong>{{ number_format($total, 4) }}</strong></td>
        </tr>
    </tfoot>
</table> --}}
<div class="card card-body">
    <h6 class="fw-bold text-primary">Tahap 1: Matriks Keputusan</h6>
    <ul class="mb-3">
        <li>Biaya Pendaftaran: {{ $data['biaya'] }}</li>
        <li>Hadiah: {{ $data['hadiah'] }}</li>
        <li>Tingkat Lomba: {{ $data['tingkat'] }}</li>
        <li>Sisa Hari: {{ $data['sisa_hari'] }}</li>
        <li>Format Lomba: {{ $data['format'] }}</li>
        <li>Kesesuaian Minat: {{ $data['minat'] }}</li>
        <li>Tipe Lomba: {{ $data['tipe_lomba'] }}</li>
    </ul>

    <h6 class="fw-bold text-primary">Tahap 2: Normalisasi Matriks</h6>
    <ul class="mb-3">
        @foreach ($normalisasi as $key => $val)
            <li>{{ ucfirst($key) }}: {{ number_format($val, 4) }}</li>
        @endforeach
    </ul>

    <h6 class="fw-bold text-primary">Tahap 3: Matriks Normalisasi Terbobot</h6>
    <ul class="mb-3">
        @foreach ($terbobot as $key => $val)
            <li>{{ ucfirst($key) }} x Bobot: {{ number_format($val, 4) }}</li>
        @endforeach
    </ul>

    <h6 class="fw-bold text-primary">Tahap 4: Menghitung Nilai Utilitas</h6>
    <p class="mb-2">Nilai Skor ARAS = {{ implode(' + ', $terbobot) }} = <strong>{{ number_format($score, 4) }}</strong></p>

    <h6 class="fw-bold text-primary">Tahap 5: Peringkat</h6>
    <p>Peringkat saat ini: <strong>{{ $rank }}</strong> dari total {{ $total }}</p>
</div>
