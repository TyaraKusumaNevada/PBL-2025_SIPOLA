@extends('layouts.template') {{-- Atau sesuaikan layout yang kamu pakai --}}

@section('content')
<div class="container">
    <h4>Detail User</h4>
    <table class="table table-bordered">
        <tr>
            <th>Username</th>
            <td>{{ $user->username }}</td>
        </tr>
        <tr>
            <th>Nama</th>
            <td>{{ $user->nama }}</td>
        </tr>
        <tr>
            <th>Role</th>
            <td>{{ $user->role_user }}</td>
        </tr>
        {{-- Tambah kolom lain jika ada --}}
    </table>

    <a href="{{ url('/user') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
