<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Layout</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .input-group-text {
        border-right: none;
        background-color: transparent;
        color: grey;
    }
    .input-group:focus-within .input-group-text {
        box-shadow: 0 0 0 0.15rem #3B82F6;
        border-left: none;
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
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row full-height">
    <!-- Kolom Gambar -->
    <div class="col-md-8 d-none d-md-block p-0 position-relative">
      <img src="{{ asset('image/polinema.png') }}" alt="Gambar Login" class="login-image h-100 w-100">
      <div class="position-absolute bottom-0 start-0 p-4 text-white text-left">
        <h4>Bersama, kita unggul di Polinema!</h4>
        <h2><strong>TI FAST, TI BRAVO</strong></h2>
    </div>
    </div>

    <!-- Kolom Form Login -->
    <div class="col-md-4 d-flex align-items-center justify-content-center">
      <form id="form-login" action="/login" method="POST" class="w-75">
        <img src="{{ asset('image/logo_sipola.png') }}" alt="Gambar Logo" class="logo-image h-50 w-50 d-block mx-auto">
        <div class="mb-3">
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
            <input type="text" name="username" class="form-control" id="username" placeholder="Username">
          </div>
          <span id="error-username" class="text-danger error-text"></span>
        </div>
        <div class="mb-5">
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
            <input type="password" name="password" class="form-control" id="password" placeholder="Password" aria-describedby="password" />
        </div>
          <span id="error-password" class="text-danger error-text"></span>
          <div class="text-end">
            <small id="passwordHelp" class="form-text text-muted">
              Lupa password? <a href="#" class="custom">Hubungi Admin</a>
            </small>
        </div>
        </div>

        <button type="submit" class="btn custom-primary w-100">Masuk</button>
      </form>
    </div>
  </div>
</div>

<!-- Bootstrap & jQuery (optional for validation) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
