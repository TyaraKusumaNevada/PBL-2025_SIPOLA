    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Landing Page - SIPOLA</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
        <style>
            body {
                background: url('https://source.unsplash.com/1920x1080/?abstract') no-repeat center center fixed;
                background-size: cover;
                margin: 0;
                padding: 0;
            }

            .hero {
                background: linear-gradient(rgba(0, 0, 0, 0.78), rgba(0, 0, 0, 0.5)),
                    url('/image/landing.jpg') center/cover no-repeat;
                color: white;
                height: 100vh;
                display: flex;
                align-items: center;
            }
        </style>
    </head>

    <body>
        <!-- Navbar -->
    

        <!-- Hero Section -->
        <header class="hero">
            <div class="container text-center">
                <img src="{{ asset('image/sipola_landing.png') }}" alt="Logo SIPOLA" class="mb-4" style="width: 200px; height: auto;">
                <h1 class="display-4 fw-bold">Selamat Datang di SIPOLA</h1>
                <p class="lead">Sistem informasi modern untuk kebutuhan Anda.</p>
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg mt-3"
                    style="background-color: #3674e7; color: white;">
                    Mulai Sekarang
                </a>
            </div>
        </header>

        <!-- Info Lomba & Prestasi Section -->
        <section class="py-5" style="background-color: #f8f9fa;">
            <div class="container">
                <div class="row text-center mb-4">
                    <h2 class="fw-bold">Highlight</h2>
                </div>
                <div class="row g-4">
                    <!-- Info Lomba -->
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="text-uppercase fw-bold border-bottom border-warning border-3 pb-1">INFO LOMBA</h6>
                                <div class="d-flex align-items-start mt-3">
                                    <img src="https://img.icons8.com/color/96/trophy.png" alt="Lomba"
                                        style="width: 60px;" class="me-3" />
                                    <div>
                                        <h5 class="fw-bold">Lihat Informasi Lomba Terbaru</h5>
                                        <p class="text-muted small mb-2">Temukan berbagai lomba mulai dari tingkat lokal
                                            hingga internasional yang sesuai minat dan bakatmu.</p>
                                        <a href="{{ route('infolomba') }}" class="btn btn-sm btn-outline-primary">Lihat
                                            Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Prestasi -->
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="text-uppercase fw-bold border-bottom border-warning border-3 pb-1">PRESTASI</h6>
                                <div class="d-flex align-items-start mt-3">
                                    <img src="https://img.icons8.com/color/96/prize.png" alt="Prestasi"
                                        style="width: 60px;" class="me-3" />
                                    <div>
                                        <h5 class="fw-bold">Lihat Prestasi Mahasiswa</h5>
                                        <p class="text-muted small mb-2">Lihat capaian luar biasa mahasiswa POLINEMA dalam
                                            berbagai kompetisi dan penghargaan.</p>
                                        <a href="{{ route('infolomba') }}" class="btn btn-sm btn-outline-primary">Lihat
                                            Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="py-5" style="background-color: #8844e600">
            <div class="container text-center">
                <h2 class="fw-bold mb-4">Tentang Kami</h2>
                <p class="mx-auto" style="max-width: 600px;">
                    SIPOLA adalah website yang dirancang untuk membantu mahasiswa mendata prestasi selama perkuliahan dan
                    juga menyediakan lomba-lomba mulai dari tingkat lokal hingga internasional.
                </p>
            </div>
        </section>

        <!-- Footer -->

        
        <footer class="bg-dark text-white py-4 text-center">
            <div class="container">
                <p class="mb-0">© {{ date('Y') }} SIPOLA. All rights reserved.</p>
            </div>
        </footer>

        <!-- Bootstrap JS Bundle -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
