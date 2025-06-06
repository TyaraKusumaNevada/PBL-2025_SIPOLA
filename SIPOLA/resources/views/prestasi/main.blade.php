@extends('layouts.template')

@section('content')
<div id="kontenPrestasi">
    @if ($jumlahPrestasi == 0)
        @include('prestasi.index')
    @else
        @include('prestasi.histori')
    @endif
</div>
@endsection