<!DOCTYPE html>

<html lang="en" class="layout-menu-fixed layout-compact" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>SI POLA</title>

    <meta name="description" content="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('template/assets/img/favicon/favicon.ico') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/fonts/iconify-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    @stack('css')

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('template/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('template/assets/js/config.js') }}"></script>

    <style>
      body {
    position: relative;
    z-index: 0;
    background-image: url('{{ asset('image/bg.jpg') }}');
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
}

/* Overlay dengan pengaturan brightness */
body::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: inherit;
    background-size: inherit;
    background-repeat: inherit;
    background-attachment: inherit;
    filter: brightness(0.979); /* Atur di sini: 1 = normal, <1 lebih gelap, >1 lebih terang */
    z-index: -1;
}
    </style>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo mt-5 mb-5">
                    <img src="{{ asset('image/logo_sipola.png') }}" alt="Gambar Logo" class="logo-image d-block mx-auto" style="max-width: 100px; height: auto;">
                </div>
                @include('layouts.sidebar')
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('layouts.header')
                <!-- / Navbar -->

                <div class="content-wrapper">
                    <!-- Content -->
                    <section class="content">
                        @yield('content')
                    </section>
                    <!-- / Content -->
                    <div class="content-backdrop fade"></div>


<html lang="en" class="layout-menu-fixed layout-compact" data-assets-path="../assets/"
    data-template="vertical-menu-template-free">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport"
            content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
        <title>SI POLA</title>

        <meta name="description" content="" />
        <!-- Animate.css untuk animasi elemen (seperti fadeIn, slideIn, dll.) -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- DataTables Bootstrap 5 CSS -->
        <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

        <!-- SweetAlert2 CSS (dari CDN) -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

        <!-- Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('template/assets/img/favicon/favicon.ico') }}" />

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

        <!-- Vendor CSS -->
        <link rel="stylesheet" href="{{ asset('template/assets/vendor/fonts/iconify-icons.css') }}" />
        <link rel="stylesheet" href="{{ asset('template/assets/vendor/css/core.css') }}" />
        <link rel="stylesheet" href="{{ asset('template/assets/css/demo.css') }}" />
        <link rel="stylesheet" href="{{ asset('template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
        <link rel="stylesheet" href="{{ asset('template/assets/vendor/libs/apex-charts/apex-charts.css') }}" />


        @stack('css') <!-- Taruh ini setelah semua CSS utama -->

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

        <!-- Bootstrap 5 Bundle JS (sudah termasuk Popper) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Helpers -->
        <script src="{{ asset('template/assets/vendor/js/helpers.js') }}"></script>

        <!-- Config -->
        <script src="{{ asset('template/assets/js/config.js') }}"></script>
    </head>
    <body>
        <!-- Layout wrapper -->
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                <!-- Menu -->
                <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                    <div class="app-brand demo mt-5 mb-5">
                      <img src="{{ asset('image/logo_sipola.png') }}" alt="Gambar Logo" class="logo-image d-block mx-auto" style="max-width: 100px; height: auto;">
                      </a>
                    </div>
                    <!-- Sidebar -->
                    @include('layouts.sidebar')
                    <!-- /.sidebar -->
                </aside>
                <!-- / Menu -->
                <!-- Layout container -->
                <div class="layout-page">
                    <!-- Navbar -->
                    @include('layouts.header')
                    <!-- / Navbar -->
                    <div class="content-wrapper">
                        <!-- Content -->
                        {{-- @include('layouts.content') --}}
                        <section class="content">
                            @yield('content')
                        </section>
                        <!-- / Content -->
                        <div class="content-backdrop fade"></div>
                    </div>
                    <!-- Content wrapper -->
                </div>
            </div>
            <!-- / Layout page -->
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <script src="{{ asset('template/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('template/assets/js/main.js') }}"></script>
    <script src="{{ asset('template/assets/js/dashboards-analytics.js') }}"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>

    @stack('js')
</body>
</html>
