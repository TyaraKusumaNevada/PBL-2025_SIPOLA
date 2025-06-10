@extends('layouts.template')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12 mb-4">
                <!-- Kotak besar pembungkus judul + semua kartu lomba -->
                <div class="card border" style="border-color: #f5deb3;">
                    <div class="card-body py-3 ms-1">
                        <h5 class="card-title text-primary fs-3 fw-semibold mb-4 mt-3">
                            <i class="bi bi-award me-2"></i> Tersedia Lomba
                        </h5>
                        <p class="text-muted fs-6 mb-4">
                            Ayo, tunjukkan prestasimu dengan mendaftar pada lomba berikut ini!
                        </p>
                        <div class="row">
                            @foreach ($lombas as $lomba)
                                <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                                    <div class="card shadow-sm h-100 lomba-card" style="border: 1px solid #f5deb3;">
                                        <div class="card-body p-2">
                                            <img src="{{ asset('storage/' . $lomba->pamflet_lomba) }}"
                                                alt="Pamflet {{ $lomba->nama_lomba }}" class="img-fluid rounded w-100 mb-3"
                                                style="height: 250px; object-fit: cover;">

                                            <h6 class="fw-bold text-dark mb-1">{{ $lomba->nama_lomba }}</h6>
                                            <small class="text-muted d-block mb-2">{{ $lomba->penyelenggara_lomba }}</small>

                                            <span class="badge bg-warning text-dark rounded-pill px-3 py-1 mb-3">
                                                Sampai
                                                {{ \Carbon\Carbon::parse($lomba->tanggal_selesai)->translatedFormat('d M Y') }}
                                            </span>
                                            <div class="row mt-5">
                                                <div class="col d-flex justify-content-between">
                                                    <a href="{{ $lomba->link_pendaftaran }}" target="_blank"
                                                        class="btn btn-sm btn-outline-info">
                                                        <i class="bi bi-pencil-square me-1"></i> Daftar
                                                    </a>
                                                    <button
                                                        onclick="modalAction('{{ url('/lombaMahasiswa/' . $lomba->id_tambahLomba . '/show_info') }}')"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-eye me-1"></i> Detail
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Bootstrap -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" id="modalContent">
                <!-- konten akan di-load di sini lewat AJAX -->
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .lomba-card:hover {
            transform: scale(1.02);
            transition: transform 0.2s ease;
            z-index: 10;
            position: relative;
        }
    </style>
@endpush

@push('js')
    <script>
        function modalAction(url = '') {
            $('#modalContent').load(url, function() {
                const modal = new bootstrap.Modal(document.getElementById('myModal'), {
                    backdrop: 'static',
                    keyboard: false
                });
                modal.show();
            });
        }
    </script>
@endpush