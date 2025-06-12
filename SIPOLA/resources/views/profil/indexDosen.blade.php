@extends('layouts.template')

@section('content')
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f9fafc;
        color: #334155;
    }

    h1, h3, h5 {
        font-weight: 600;
        color: #1e293b;
    }

    .container {
        padding-top: 40px;
    }

    .card {
        border: none;
        border-radius: 16px;
        box-shadow: 8 16px 16px rgba(0, 0, 0, 0.05);
        background-color: #ffffff;
        margin-bottom: 30px;
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-outline-primary {
        color: #4f46e5;
        border: 1px solid #4f46e5;
        background-color: transparent;
    }

    .btn-outline-primary:hover {
        background-color: #3730a3;
        border-color: #3730a3;
        color: white;
    }

    .btn-secondary {
        background-color: #4f46e5;
        border: none;
        color: white;
    }

    .btn-back:hover {
        background-color: #dc2626 !important;
        border-color: #dc2626 !important;
        color: #fff !important;
    }

    .rounded-circle {
        object-fit: cover;
        border: 3px solid #e5e7eb;
    }

    .profile-img {
        text-align: center;
    }

    @media (max-width: 768px) {
        .profile-img {
            margin-bottom: 20px;
        }
    }

    .label {
        font-weight: 600;
        color: #686b74;
    }

    .value {
        text-decoration: underline;
        color: #2563eb;
    }

    .form-label {
        color: #1e293b;
        font-weight: 500;
    }

    .btn-success {
        background-color: #16a34a;
        border: none;
    }

    .btn-success:hover {
        background-color: #15803d;
    }

    .btn-secondary:hover {
        background-color: #4338ca;
    }

    .text-danger {
        font-size: 0.875rem;
    }
</style>

<div class="container">
    <a href="{{ url('/') }}" class="btn btn-secondary mb-3 btn-back">
        <i class="fa fa-arrow-left me-1"></i> Kembali
    </a>

    <h1 class="mb-4">Profil Dosen</h1>

    {{-- Profil Display --}}
    <div class="card p-4">
        <div class="row align-items-center">
            <div class="col-md-3 text-center profile-img">
                <img id="profile-photo" src="{{ $fotoPath }}" alt="Foto Profil" class="rounded-circle" width="150" height="150">
            </div>
            <div class="col-md-7">
                <h3 id="display-nama">{{ $user->name }}</h3>
                <p><span class="label">Username:</span> <span id="display-username" class="value">{{ $user->username }}</span></p>
                <p><span class="label">NIP:</span> <span class="value">{{ $user->username }}</span></p>
                <p><span class="label">Email:</span> <span class="value">{{ $user->email }}</span></p>
            </div>
            <div class="col-md-2 text-end">
                <button class="btn btn-outline-primary" id="btn-edit-profile">
                    <i class="fa fa-edit me-1"></i> Edit Profil
                </button>
            </div>
        </div>
    </div>

    {{-- Form Edit Profil --}}
    <div id="edit-form" style="display: none;">
        <div class="card p-4">
            <form id="form-edit-profile" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $user->name }}">
                    <div id="error-nama" class="text-danger mt-1" style="display:none;"></div>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username Baru</label>
                    <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}">
                    <div id="error-username" class="text-danger mt-1" style="display:none;"></div>
                </div>
                <div class="mb-3">
                    <label for="foto_profil" class="form-label">Foto Profil (jpg/png, max 2MB)</label>
                    <input type="file" class="form-control" id="foto_profil" name="foto_profil" accept=".jpg,.jpeg,.png">
                    <div id="error-foto" class="text-danger mt-1" style="display:none;"></div>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-secondary" id="btn-cancel">Batal</button>
            </form>
        </div>
    </div>
</div>

{{-- FontAwesome CDN --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

{{-- Script --}}
<script>
    document.getElementById('btn-edit-profile').addEventListener('click', () => {
        document.getElementById('edit-form').style.display = 'block';
    });

    document.getElementById('btn-cancel').addEventListener('click', () => {
        document.getElementById('edit-form').style.display = 'none';
        clearProfileErrors();
    });

    function clearProfileErrors() {
        ['error-nama', 'error-username', 'error-foto'].forEach(id => {
            const el = document.getElementById(id);
            el.style.display = 'none';
            el.textContent = '';
        });
    }

    document.getElementById('form-edit-profile').addEventListener('submit', function (e) {
        e.preventDefault();
        clearProfileErrors();

        const form = e.target;
        const formData = new FormData(form);

        fetch("{{ route('profil.update.profile') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": formData.get('_token'),
                "Accept": "application/json"
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('display-nama').textContent = data.user.nama;
                document.getElementById('display-username').textContent = data.user.username;

                if (data.fotoPath) {
                    document.getElementById('profile-photo').src = data.fotoPath + '?t=' + new Date().getTime();
                }

                document.getElementById('edit-form').style.display = 'none';
            } else if (data.errors) {
                if (data.errors.nama) {
                    let el = document.getElementById('error-nama');
                    el.textContent = data.errors.nama[0];
                    el.style.display = 'block';
                }
                if (data.errors.username) {
                    let el = document.getElementById('error-username');
                    el.textContent = data.errors.username[0];
                    el.style.display = 'block';
                }
                if (data.errors.foto_profil) {
                    let el = document.getElementById('error-foto');
                    el.textContent = data.errors.foto_profil[0];
                    el.style.display = 'block';
                }
            } else if (data.error) {
                alert(data.error);
            }
        })
        .catch(err => console.error(err));
    });
</script>
@endsection
