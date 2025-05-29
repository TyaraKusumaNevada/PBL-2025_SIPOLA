<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Register SIPOLA</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    .input-group-text {
      border-right: none;
      background-color: transparent;
      color: grey;
    }

    .form-control:focus {
      border-left: none;
      box-shadow: 0.25rem 0 0 0 #3B82F6,
        0 0.15rem 0 0 #3B82F6,
        0 -2px 0 0 #3B82F6;
    }

    .form-control {
      border-left: none;
      color: grey;
    }

    .login-image {
      width: 100%;
      height: auto;
      object-fit: cover;
    }

    .full-height {
      min-height: 100vh;
    }

    .custom-primary {
      background-color: #1E3A8A;
      color: white;
      box-shadow:
        0.2rem 0 0 0 #93C5FD,
        0.25rem 0 0 0 #93C5FD,
        0 0.15rem 0 0 #93C5FD,
        0 -2px 0 0 #93C5FD;
      backdrop-filter: blur(20px);
    }

    .custom-primary:hover {
      background-color: #3B82F6;
      color: white;
    }

    .custom {
      color: #1E3A8A;
    }

    .back-button {
      position: absolute;
      top: 20px;
      left: 20px;
      z-index: 1000;
      font-size: 1.2rem;
      color: #1E3A8A;
      text-decoration: none;
    }

    .back-button:hover {
      color: #3B82F6;
    }
  </style>
</head>
<body>

<!-- Tombol kembali -->
<a href="{{ url('/login') }}" class="back-button" style="color: white">
  <i class="bi bi-arrow-left"></i> 
</a>

<div class="container-fluid">
  <div class="row full-height">
    <!-- Kolom Gambar -->
    <div class="col-md-8 d-none d-md-block p-0 position-relative">
      <img src="{{ asset('image/hehe.JPG') }}" alt="Gambar Register" class="login-image h-100 w-100">
      <div class="position-absolute bottom-0 start-0 p-4 text-white text-left">
        <h4>Bersama, kita unggul di Polinema!</h4>
        <h2><strong>TI FAST, TI BRAVO</strong></h2>
      </div>
    </div>

    <!-- Kolom Form -->
    <div class="col-md-4 d-flex align-items-center justify-content-center">
      <form id="form-register" action="{{ route('signin') }}" method="POST" class="w-75">
        @csrf
        <img src="{{ asset('image/logo_sipola.png') }}" alt="Logo SIPOLA" class="logo-image h-50 w-50 d-block mx-auto">

        <!-- Nama -->
        <div class="mb-3">
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-person-lines-fill"></i></span>
            <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap">
          </div>
          <span id="error-nama" class="text-danger error-text"></span>
        </div>

        <!-- NIM -->
        <div class="mb-3">
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-card-text"></i></span>
            <input type="text" name="nim" class="form-control" placeholder="NIM">
          </div>
          <span id="error-nim" class="text-danger error-text"></span>
        </div>

        <!-- Email -->
        <div class="mb-3">
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
            <input type="email" name="email" class="form-control" placeholder="Email">
          </div>
          <span id="error-email" class="text-danger error-text"></span>
        </div>

        <!-- Password -->
        <div class="mb-3">
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
            <input type="password" name="password" class="form-control" placeholder="Password">
          </div>
          <span id="error-password" class="text-danger error-text"></span>
        </div>

        <!-- Konfirmasi Password -->
        <div class="mb-3">
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password">
          </div>
          <span id="error-password_confirmation" class="text-danger error-text"></span>
        </div>

        <!-- Prodi -->
        <div class="mb-3">
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-journal-code"></i></span>
            <select name="id_prodi" class="form-control">
              <option value="">-- Pilih Program Studi --</option>
              @foreach($prodi as $item)
                <option value="{{ $item->id }}">{{ $item->nama_prodi }}</option>
              @endforeach
            </select>
          </div>
          <span id="error-id_prodi" class="text-danger error-text"></span>
        </div>

        <!-- Bidang Keahlian -->
        <div class="mb-3">
          <input type="text" name="bidang_keahlian" class="form-control" placeholder="Bidang Keahlian (Opsional)">
        </div>

        <!-- Minat -->
        <div class="mb-3">
          <textarea name="minat" class="form-control" rows="3" placeholder="Minat (Opsional)"></textarea>
        </div>

        <!-- Tombol -->
        <button type="submit" class="btn custom-primary w-100">Sign In</button>

        <div class="text-center mt-3">
          <small class="form-text text-muted">
            Sudah punya akun? <a href="{{ url('/login') }}" class="custom">Login di sini</a>
          </small>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  $(document).ready(function () {
    $('#form-register').on('submit', function (e) {
      e.preventDefault();
      $('.error-text').text('');
      $.ajax({
        url: $(this).attr('action'),
        method: $(this).attr('method'),
        data: $(this).serialize(),
        dataType: 'json',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
          if (response.status) {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil!',
              text: response.message,
              timer: 2000,
              showConfirmButton: false
            }).then(() => {
              window.location.href = response.redirect;
            });
          } else {
            $.each(response.messages, function (field, messages) {
              $('#error-' + field).text(messages[0]);
            });
          }
        },
        error: function (xhr) {
          if (xhr.status === 422) {
            let errors = xhr.responseJSON.errors;
            $.each(errors, function (field, messages) {
              $('#error-' + field).text(messages[0]);
            });
          } else {
            Swal.fire('Error', 'Terjadi kesalahan. Coba lagi nanti.', 'error');
          }
        }
      });
    });
  });
</script>
</body>
</html>
