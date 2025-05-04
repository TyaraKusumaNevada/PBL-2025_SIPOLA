@extends('layouts.template')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card p-3">
            <div class="row align-items-center">
                <!-- Profil Mahasiswa -->
                <div class="col-md-6 d-flex align-items-center">
                    <img src="{{ asset('template/assets/img/avatars/1.png') }}" alt="Foto Mahasiswa" 
                         class="rounded-circle me-3" 
                         style="width: 80px; height: 80px; object-fit: cover;">
                    <div>
                        <h2 class="mb-1 fs-3" style="color: #8B5CF6">Rizkya Salsabila</h2>
                        <p class="text-muted fs-5">2341720056</p>
                    </div>
                </div>
                <!-- Informasi Tambahan -->
                <div class="col-md-6 text-md-end">
                    <p class="mb-1 fs-5">D4 Teknik Informatika</p>
                    <p class="text-muted fs-6">2023</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Formulir Minat dan Keahlian -->
<div class="row mt-5">
    <div class="col-12">
        <div class="card p-4">
            <form class="mr-5">
                <div class="mb-3">
                    <label for="minat" class="form-label fw-medium fs-5">Minat</label>
                    <input type="text" id="minat" 
                           class="form-control form-control-lg border-2 rounded-3" placeholder="-- Pilih Minat Anda --">
                </div>

                <div class="mb-3">
                    <label for="keahlian" class="form-label fw-medium fs-5">Keahlian</label>
                    <input type="text" id="keahlian" 
                           class="form-control form-control-lg border-2 rounded-3" placeholder="-- Pilih Keahlian Anda --">
                </div>

                <div class="mb-3">
                    <label for="bidangKeahlian" class="form-label fw-medium fs-5">Bidang Keahlian</label>
                    <input type="text" id="bidangKeahlian" 
                           class="form-control form-control-lg border-2 rounded-3" placeholder="-- Pilih Bidang Keahlian Anda --">
                </div>

                <div class="mb-3">
                    <label for="sertifikasi" class="form-label fw-medium fs-5">Sertifikasi</label>
                    <input type="text" id="sertifikasi" 
                           class="form-control form-control-lg border-2 rounded-3" placeholder="Sertifikasi Web Developer BNSP">
                </div>

                <div class="mb-3">
                    <label for="pengalaman" class="form-label fw-medium fs-5">Pengalaman</label>
                    <textarea id="pengalaman" class="form-control form-control-lg border-2 rounded-3" placeholder="Magang di PT Telkom selama 3 bulan sebagai Web Developer" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-lg border-2 rounded-3 w-100 text-center mt-5" style="background-color: #8B5CF6; color: white">
                    <i class="menu-icon tf-icons bx bx-save"></i> Kirim 
                </button>
            </form>
        </div>
    </div>
</div>
  
@endsection