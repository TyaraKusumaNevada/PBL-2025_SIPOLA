@extends('layouts.template')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="bg-white shadow rounded-4 p-10">
                    <div class="row align-items-center">
                        {{-- <!-- Gambar Ilustrasi -->
                        <div class="col-md-6 mb-4 mb-md-0 text-center">
                            <img src="{{ asset('image/ilustrasi_prestasi.jpg') }}" alt="Ilustrasi Prestasi" class="img-fluid" style="max-height: 300px;">
                        </div> --}}

                        <!-- Gambar Ilustrasi -->
                        <div class="col-md-6 mb-4 mb-md-0 text-center">
                            <img src="{{ asset('image/ilustrasi_prestasi.jpg') }}"
                                alt="Ilustrasi Prestasi"
                                class="img-fluid animate__animated animate__fadeInLeft"
                                style="max-height: 300px;">
                        </div>

                        <!-- Teks dan Tombol -->
                        <div class="col-md-6 text-center text-md-start">
                            <h5 class="card-title text-primary fs-3 mb-5">Unggah Prestasi Mahasiswa</h5>
                            <p class="text-muted fs-5 mb-4">
                                Tunjukkan prestasi akademik maupun non-akademik terbaikmu di sini!  
                                Unggah data yang tersedia dan dokumen pendukung lainnya.  
                                Setiap unggahan akan diverifikasi oleh admin sebelum tampil di sistem.
                            </p>
                            <p class="text-muted fs-5">
                                Ayoo, jangan biarkan pencapaianmu hanya jadi arsip pribadi — bagikan dan jadilah inspirasi!
                            </p>
                            <a href="javascript:void(0);" onclick="modalAction('{{ url('/prestasi/create_ajax') }}')" class="btn btn-sm btn-outline-primary btn-lg px-4 fs-5 "><i class="bi bi-plus-circle me-2"></i> Tambah</a>
                        </div>
                    </div>
                </div>

                <!-- Modal Container -->
                <div id="myModal" class="modal fade" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content" id="modalContent">
                            {{-- Konten AJAX akan dimuat di sini --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
@endpush


@push('js')
    <script>
        // CSRF untuk semua request AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        // Menampilkan modal AJAX
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