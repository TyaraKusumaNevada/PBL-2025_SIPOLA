@extends('layouts.template') 
@section('content')
<div class="container py-5">
    <h2 class="mb-4">Info Lomba Terbaru</h2>
<a href="{{ url('/landing') }}" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Rekomendasi</th>
                <th>ID Mahasiswa</th>
                <th>ID Lomba</th>
                <th>ID Dosen</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lombaTerbaru as $lomba)
            <tr>
                <td>{{ $lomba->id_rekomendasi }}</td>
                <td>{{ $lomba->id_mahasiswa }}</td>
                <td>{{ $lomba->id_lomba }}</td>
                <td>{{ $lomba->id_dosen }}</td>
                <td>{{ $lomba->created_at }}</td>
                <td>{{ $lomba->updated_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
