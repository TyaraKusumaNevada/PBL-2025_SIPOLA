
@extends('layouts.template')

@section('content')
    <style>
        .form-section {
            padding-top: 40px;
        }

        .form-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 30px;
            background-color: #ffffff;
        }

        .form-label {
            font-weight: 500;
        }

        .btn-rekomendasi {
            background-color: #2b3ea0;
            color: #fff;
            font-weight: 500;
            border: none;
        }

        .btn-rekomendasi:hover {
            background-color: #1a2b6d;
        }
    </style>

    <div class="container form-section">
        <a href="{{ url('/') }}" class="btn btn-secondary mb-3 btn-back">
            <i class="fa fa-arrow-left me-1"></i> Kembali
        </a>

        <div class="form-card">
            <h2 class="mb-4">Pilih sesuai kriteria lomba yang Anda inginkan</h2>

            <form method="POST" action="{{ route('rekomendasi.hitung') }}">
                @csrf

                <div class="mb-3">
                    <label for="ipk" class="form-label">IPK tertinggi</label>
                    <input type="number" step="0.01" name="ipk" id="ipk" class="form-control"
                        placeholder="Masukkan IPK Anda (contoh: 3.25)" required min="0" max="4">
                </div>

                <div class="mb-3">
                    <label for="harga" class="form-label">biaya lomba</label>
                    <input type="text" step="0.01" name="harga" id="harga" class="form-control"
                        placeholder="masukkan harga lomba yang diinginkan (jika gratis 0) " required min="0" max="4">
                </div>

                <div class="mb-4">
                    <label for="syarat" class="form-label">syarat</label>
                    <select name="syarat" id="syarat" class="form-select" required>
                        <option value="Default">pilih disini</option>
                        <option value="bebas">bebas</option>
                        <option value="folow ig">folow ig</option>
                        <option value="upload twiboon">upload twiboon</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="jenis" class="form-label">Jenis Lomba</label>
                    <select name="jenis" id="jenis" class="form-select" required>
                        <option value="Default">pilih disini</option>
                        <option value="individu">Individu</option>
                        <option value="tim">Tim</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="benefit" class="form-label">Benefit</label>
                    <select name="benefit" id="benefit" class="form-select" required>
                        <option value="Default">pilih disini</option>
                        <option value="Dana Transportasi">Dana Transportasi</option>
                        <option value="Makan">Makan</option>
                        <option value="Penginapan">Penginapan</option>
                        <option value="Sertifikat">Sertifikat</option>
                    </select>
                </div>


                <button type="submit" class="btn btn-rekomendasi">Rekomendasikan</button>
            </form>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endsection