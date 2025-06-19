@foreach ($rekomendasi as $item)
    <div class="card mb-2">
        <div class="card-body">
            <h5>{{ $item['lomba']->nama_lomba }}</h5>
            <p>Tingkat: {{ $item['lomba']->tingkat_lomba }}, Skor: <strong>{{ $item['skor'] }}</strong></p>
        </div>
    </div>
@endforeach