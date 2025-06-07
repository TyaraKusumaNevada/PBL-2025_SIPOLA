@extends('layouts.template')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12 mb-4">
                <!-- Kotak besar pembungkus judul + semua kartu lomba -->
                <div class="card border" style="border-color: #f5deb3;">
                    <div class="card-body py-3 ms-1">
                        {{-- <h4 class="fw-bold text-primary mb-4">Lomba Tersedia</h4> --}}
                        <h5 class="fcard-title text-primary fs-3 mb-5 mt-5">Lomba Tersedia</h5>

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

                                            <span class="badge bg-warning text-dark rounded-pill px-3 py-1">
                                                Sampai
                                                {{ \Carbon\Carbon::parse($lomba->tanggal_selesai)->translatedFormat('d M Y') }}
                                            </span>

                                            <div class="mt-3 text-end">
                                                <button
                                                    onclick="modalAction('{{ url('/lombaDospem/' . $lomba->id_tambahLomba . '/show_info') }}')"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye me-1"></i> Detail
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div> <!-- end row for lombas -->

                    </div> <!-- end card-body utama -->
                </div> <!-- end card utama -->
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
            /* Supaya efek scale tidak tertimpa elemen lain */
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
