{{-- @extends('layouts.template')

@section('content')
<div class="container">
    <h2 class="mb-4">Hasil Rekomendasi Lomba</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(count($ranking) > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Lomba</th>
                        <th>Bidang</th>
                        <th>Tingkat</th>
                        <th>Biaya</th>
                        <th>Hadiah</th>
                        <th>Format</th>
                        <th>Tipe</th>
                        <th>Tanggal Berakhir</th>
                        <th>Sisa Hari</th>
                        <th>Skor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ranking as $index => $item)
                        @php
                            $lomba = \App\Models\TambahLombaModel::find($item['id_lomba']);
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $lomba->nama_lomba }}</td>
                            <td>{{ $lomba->bidang_lomba }}</td>
                            <td>{{ ucfirst($lomba->tingkat_lomba) }}</td>
                            <td>Rp{{ number_format($lomba->biaya_pendaftaran, 0, ',', '.') }}</td>
                            <td>Rp{{ number_format($lomba->hadiah, 0, ',', '.') }}</td>
                            <td>{{ ucfirst($lomba->format_lomba) }}</td>
                            <td>{{ ucfirst($lomba->tipe_lomba) }}</td>
                            <td>{{ \Carbon\Carbon::parse($lomba->tanggal_selesai)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::now()->diffInDays($lomba->tanggal_selesai, false) }} hari</td>
                            <td><strong>{{ number_format($item['score'], 4) }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">Belum ada lomba yang cocok dengan preferensimu.</div>
    @endif
</div>
@endsection --}}

{{-- 
@extends('layouts.template')

@section('content')
<div class="container">
    <h2 class="mb-4">Rekomendasi Lomba</h2> --}}

    {{-- ✅ Form Preferensi --}}
    {{-- <div class="card mb-4">
        <div class="card-header"><strong>Form Preferensi Mahasiswa</strong></div>
        <div class="card-body">
            @include('mahasiswa.rekomendasi.form_preferensi')
        </div>
    </div> --}}

    {{-- ✅ Form Bobot Kriteria --}}
    {{-- <div class="card mb-4">
        <div class="card-header"><strong>Form Bobot Kriteria</strong></div>
        <div class="card-body">
            @include('mahasiswa.rekomendasi.form_bobot')
        </div>
    </div> --}}

    {{-- 🧠 Tombol Proses Rekomendasi --}}
    {{-- <form method="POST" action="{{ route('mahasiswa.rekomendasi.proses') }}">
        @csrf
        <button class="btn btn-success mb-3" type="submit">
            <i class="fas fa-search"></i> Lihat Rekomendasi
        </button>
    </form> --}}

    {{-- 📋 Hasil Tabel Rekomendasi --}}
    {{-- @if(isset($rekomendasi))
        <div class="card">
            <div class="card-header"><strong>Hasil Rekomendasi Lomba</strong></div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Lomba</th>
                            <th>Skor</th>
                            <th>Minat</th>
                            <th>Format</th>
                            <th>Tingkat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekomendasi as $lomba)
                            <tr>
                                <td>{{ $lomba->nama_lomba }}</td>
                                <td>{{ number_format($lomba->skor, 4) }}</td>
                                <td>{{ $lomba->kategori_lomba }}</td>
                                <td>{{ ucfirst($lomba->format_lomba) }}</td>
                                <td>{{ ucfirst($lomba->tingkat_lomba) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>
@endsection --}}
{{-- <table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama Lomba</th>
            <th>Kategori</th>
            <th>Tingkat</th>
            <th>Penyelenggara</th>
            <th>Tanggal Selesai</th>
            <th>Hadiah</th>
            <th>Status</th>
            <th>Tipe</th>
        </tr>
    </thead>
    <tbody>
        @foreach($lomba as $item)
        <tr>
            <td>{{ $item->nama_lomba }}</td>
            <td>{{ ucfirst($item->kategori_lomba) }}</td>
            <td>{{ ucfirst($item->tingkat_lomba) }}</td>
            <td>{{ $item->penyelenggara_lomba }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</td>
            <td>Rp{{ number_format($item->hadiah, 0, ',', '.') }}</td>
            <td>{{ $item->status_verifikasi }}</td>
            <td>{{ ucfirst($item->tipe_lomba) }}</td>
        </tr>
        @endforeach
    </tbody>
</table> --}}

@extends('layouts.template')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-xxl-12 mb-6 order-0">
            <div class="card">
                <div class="d-flex align-items-start row">
                    <div class="col-sm-12">
                        <div class="card-body min-vh-50 mb-5">
                            <div class="d-flex justify-content-between align-items-center mb-5">
                                <h5 class="card-title text-primary fs-3 m-0">Daftar Rekomendasi Lomba</h5>
                                {{-- <a href="javascript:void(0);" 
                                    onclick="openFormBobot('{{ route('mahasiswa.rekomendasi.form_bobot') }}')"
                                    class="btn btn-sm btn-outline-primary fs-6 float-end">
                                    <i class="bx bx-slider-alt"></i> Rekomendasi
                                </a> --}}
                                {{-- <a href="javascript:void(0);"
                                    class="btn btn-sm btn-outline-primary fs-6 float-end"
                                    data-url="{{ route('mahasiswa.rekomendasi.form_bobot') }}"
                                    onclick="openFormBobot(this)">
                                    <i class="bx bx-slider-alt"></i> Rekomendasi
                                </a> --}}
                                {{-- <a href="javascript:void(0);" 
                                onclick="openFormBobot('{{ route('mahasiswa.rekomendasi.form_bobot') }}')" 
                                class="btn btn-sm btn-outline-primary fs-6 float-end">
                                <i class="bx bx-slider-alt"></i> Rekomendasi 2
                                </a>
                                <a href="javascript:void(0);" onclick="openFormPreferensi()" class="btn btn-sm btn-outline-primary float-end">
                                    <i class="bx bx-slider-alt"></i> Rekomendasi
                                </a> --}}
                                <!-- Tombol rekomendasi preferensi -->
                                <a href="javascript:void(0);" onclick="openFormPreferensi()" class="btn btn-sm btn-outline-primary float-end ms-2">
                                    <i class="bx bx-slider-alt"></i> Rekomendasi (Preferensi)
                                </a>

                                {{-- <!-- Tombol rekomendasi bobot -->
                                <a href="javascript:void(0);" onclick="openFormBobot()" class="btn btn-sm btn-outline-primary float-end">
                                    <i class="bx bx-slider-alt"></i> Rekomendasi (Bobot)
                                </a> --}}
                            </div>

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            {{-- @if(isset($rekomendasi) && count($rekomendasi) > 0)
                                <div class="mt-4">
                                    <h5 class="text-primary">Hasil Rekomendasi Lomba (Metode ARAS)</h5>
                                    @foreach ($rekomendasi as $item)
                                        <div class="card mb-2">
                                            <div class="card-body">
                                                <h5>{{ $item['lomba']->nama_lomba }}</h5>
                                                <p>
                                                    Tingkat: {{ $item['lomba']->tingkat }} <br>
                                                    Skor: <strong>{{ $item['skor'] }}</strong>
                                                </p>
                                                {{-- Tambahkan detail perhitungan di sini jika perlu --}}
                                            {{-- </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif --}} 

                            @foreach ($rekomendasi as $item)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $item['lomba']->nama_lomba }}</h5>
                                        <p class="card-text">Tingkat: {{ $item['lomba']->tingkat_lomba }}</p>
                                        <p class="card-text">Skor: <strong>{{ $item['skor'] }}</strong></p>
                                        <button class="btn btn-sm btn-outline-primary btn-detail-aras" 
                                                data-id="{{ $item['lomba']->id_tambahLomba }}">
                                            📊 Lihat Detail Perhitungan
                                        </button>
                                        <div class="mt-3 detail-aras d-none" id="detail-aras-{{ $item['lomba']->id_tambahLomba }}"></div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="w-100 mt-5">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped align-middle" id="table_lomba">
                                        <thead class="table-light">
                                            <tr class="text-center">
                                                <th>Nama Lomba</th>
                                                <th>Kategori</th>
                                                <th>Tingkat</th>
                                                <th>Penyelenggara</th>
                                                <th>Tgl. Selesai</th>
                                                <th>Hadiah</th>
                                                <th>Status</th>
                                                <th>Tipe</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($lomba as $item)
                                            <tr>
                                                <td>{{ $item->nama_lomba }}</td>
                                                <td>{{ ucfirst($item->kategori_lomba) }}</td>
                                                <td>{{ ucfirst($item->tingkat_lomba) }}</td>
                                                <td>{{ $item->penyelenggara_lomba }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</td>
                                                <td>Rp{{ number_format($item->hadiah, 0, ',', '.') }}</td>
                                                {{-- <td><span class="badge bg-success">{{ $item->status_verifikasi }}</span></td> --}}
                                                <td>
                                                    @if($item->status_verifikasi == 'Disetujui' && \Carbon\Carbon::parse($item->tanggal_selesai)->isFuture())
                                                        <span class="badge bg-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-secondary">Tidak Aktif</span>
                                                    @endif
                                                </td>
                                                <td>{{ ucfirst($item->tipe_lomba) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div> {{-- end card-body --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div id="myModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" id="modalContent"> --}}
                {{-- AJAX content will load here --}}
            {{-- </div>
        </div>
    </div> --}}
    <div class="modal fade" id="myModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="modalContent">
                <!-- form_bobot akan dimuat ke sini via AJAX -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_length {
        margin-top: 1rem;
    }
</style>
@endpush

@push('js')
<script>
    $(document).ready(function() {
        $('#table_lomba').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Berikutnya",
                    previous: "Sebelumnya"
                },
                emptyTable: "Tidak ada data lomba yang sesuai.",
                processing: "Memuat..."
            }
        });
    });
    // function openFormBobot(url) {
    //     // $('#modalContent').load(url, function () {
    //     //     const modal = new bootstrap.Modal(document.getElementById('myModal'), {
    //     //         backdrop: 'static',
    //     //         keyboard: false
    //     //     });
    //     //     modal.show();
    //     console.log('URL dipanggil:', url); // <- Cek apakah string
    //     $('#modalContent').load(url, function () {
    //         const modal = new bootstrap.Modal(document.getElementById('myModal'), {
    //             backdrop: 'static',
    //             keyboard: false
    //         });
    //         modal.show();

    //         // Bind form submit event after content is loaded
    //         $('#formPreferensi').on('submit', function(e) {
    //             e.preventDefault();
    //             let form = $(this);

    //             $.post(form.attr('action'), form.serialize(), function(response) {
    //                 alert(response.success);
    //                 modal.hide();
    //             }).fail(function(xhr) {
    //                 alert('Gagal menyimpan preferensi. Periksa input.');
    //             });
    //         });
    //     });
    // }
    function openFormPreferensi() {
        $('#modalContent').load("{{ route('mahasiswa.rekomendasi.preferensi') }}", function () {
            const modal = new bootstrap.Modal(document.getElementById('myModal'), {
                backdrop: 'static',
                keyboard: false
            });
            modal.show();
        });
    }

    function openFormBobot() {
        $('#modalContent').load("{{ route('mahasiswa.rekomendasi.bobot') }}", function () {
            const modal = new bootstrap.Modal(document.getElementById('myModal'), {
                backdrop: 'static',
                keyboard: false
            });
            modal.show();
        });
    }
    
    $('.btn-detail-aras').on('click', function () {
        let id = $(this).data('id');
        let detailDiv = $('#detail-aras-' + id);

        if (!detailDiv.hasClass('d-none')) {
            detailDiv.addClass('d-none').html('');
            return;
        }

        $.get(`/mahasiswa/rekomendasi/detail-aras/${id}`, function (res) {
            let html = `
                <div class="p-3 bg-light border rounded">
                    <h6 class="text-primary">Tahap 1: Matriks Keputusan</h6>
                    <ul>${Object.entries(res.data).map(([k, v]) => `<li>${k}: ${v}</li>`).join('')}</ul>

                    <h6 class="text-primary">Tahap 2: Normalisasi Matriks</h6>
                    <ul>${Object.entries(res.normalisasi).map(([k, v]) => `<li>${k}: ${v.toFixed(4)}</li>`).join('')}</ul>

                    <h6 class="text-primary">Tahap 3: Normalisasi Terbobot</h6>
                    <ul>${Object.entries(res.terbobot).map(([k, v]) => `<li>${k}: ${v.toFixed(4)}</li>`).join('')}</ul>

                    <h6 class="text-primary">Tahap 4: Menghitung Nilai Utilitas</h6>
                    <p><strong>Skor Total: ${res.skor}</strong></p>
                </div>
            `;
            detailDiv.removeClass('d-none').html(html);
        }).fail(function () {
            alert('Gagal memuat detail ARAS.');
        });
    });

    // $('.btn-detail-aras').on('click', function () {
    //     let id = $(this).data('id');
    //     let detailBox = $('#detail-aras-' + id);

    //     if (detailBox.hasClass('d-none')) {
    //         $.get('/mahasiswa/rekomendasi/aras-detail/' + id, function (res) {
    //             detailBox.html(res).removeClass('d-none');
    //         }).fail(function () {
    //             alert('Gagal mengambil detail perhitungan ARAS');
    //         });
    //     } else {
    //         detailBox.addClass('d-none').empty();
    //     }
    // });
    // function openFormPreferensi() {
    //     $('#modalContent').load("{{ route('mahasiswa.rekomendasi.preferensi') }}", function () {
    //         const modal = new bootstrap.Modal(document.getElementById('myModal'), {
    //             backdrop: 'static',
    //             keyboard: false
    //         });
    //         modal.show();
    //     });
    // }
    // function openFormBobot() {
    //     $('#modalContent').load("{{ route('mahasiswa.rekomendasi.bobot') }}", function () {
    //         const modal = new bootstrap.Modal(document.getElementById('myModal'), {
    //             backdrop: 'static',
    //             keyboard: false
    //         });
    //         modal.show();
    //     });
    // }
    // function openFormBobot(element) {
    //     let url = element.getAttribute('data-url');
    //     $('#modalContent').load(url, function () {
    //         const modal = new bootstrap.Modal(document.getElementById('myModal'), {
    //             backdrop: 'static',
    //             keyboard: false
    //         });
    //         modal.show();
    //     });
    // }
    // function openFormBobot(url) {
    //     $('#modalContent').load(url, function () {
    //         const modal = new bootstrap.Modal(document.getElementById('myModal'), {
    //             backdrop: 'static',
    //             keyboard: false
    //         });
    //         modal.show();
    //     });
    // }
    // function openFormBobot() {
    //     $('#modalContent').load("{{ url('mahasiswa.preferensi.create') }}", function () {
    //         const modal = new bootstrap.Modal(document.getElementById('myModal'), {
    //             backdrop: 'static',
    //             keyboard: false
    //         });
    //         modal.show();
    //     });
    // }
</script>
@endpush