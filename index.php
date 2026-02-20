<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PetShop | Sistem Pendataan Hewan & Manajemen Penjualan</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- AOS (Animate On Scroll) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary: #00796b;
            --secondary: #ffc107;
            --light: #f0f8ff;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.3rem;
        }

        .btn-primary {
            background-color: var(--primary);
            border: none;
        }

        .btn-primary:hover {
            background-color: #004d40;
        }

        .bg-light {
            background-color: var(--light) !important;
        }

        section {
            padding: 80px 0;
        }

        .hero {
            background: url('https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?auto=format&fit=crop&w=1350&q=80') center/cover no-repeat;
            position: relative;
            color: #fff;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, .55);
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .card-service i {
            font-size: 2.5rem;
            color: var(--primary);
        }

        .gallery img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: .5rem;
        }

        footer {
            background-color: #004d40;
            color: #fff;
            padding: 40px 0;
        }
    </style>
</head>

<body data-bs-spy="scroll" data-bs-target="#mainNav" data-bs-offset="70">

    <!-- Navbar -->
    <nav id="mainNav" class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-paw"></i> PetShop</a>
            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#hero">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#gallery">Galeri</a></li>
                    <li class="nav-item"><a class="btn btn-primary ms-2" href="login.php">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section id="hero" class="hero d-flex align-items-center">
        <div class="hero-overlay"></div>
        <div class="container hero-content text-center" data-aos="fade-up">
            <h1 class="display-4 fw-bold">PetShop<br>Sistem Informasi Pengelolaan Pet Shop</h1>
            <p class="lead">Kelola data hewan, penjual, pembeli, dan transaksi secara cepat, akurat, dan terpusat.</p>

        </div>
    </section>

    <!-- About -->
    <section id="about" class="bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6" data-aos="fade-right">
                    <img src="https://images.unsplash.com/photo-1520038410233-7141be7e6f97?auto=format&fit=crop&w=635&q=80"
                        class="img-fluid rounded shadow" alt="About">
                </div>
                <div class="col-md-6" data-aos="fade-left">
                    <h2 class="fw-bold mb-3">Tentang Kami</h2>
                    <p>PetShop System hadir untuk memudahkan pengelolaan data hewan peliharaan, stok, penjual, pembeli,
                        serta transaksi penjualan. Dengan antarmuka yang sederhana, Anda dapat menghemat waktu dan
                        menekan kesalahan input.</p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check-circle text-success me-2"></i>Data terpusat & real-time</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Laporan otomatis</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Akses kapan saja</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Services -->
    <section id="services">
        <div class="container text-center">
            <h2 class="fw-bold mb-5" data-aos="fade-up">Layanan Kami</h2>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card border-0 shadow h-100 card-service">
                        <div class="card-body">
                            <i class="fas fa-dog mb-3"></i>
                            <h5 class="card-title">Data Hewan</h5>
                            <p class="card-text">Tercatat lengkap mulai dari jenis, umur, hingga riwayat kesehatan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card border-0 shadow h-100 card-service">
                        <div class="card-body">
                            <i class="fas fa-shopping-cart mb-3"></i>
                            <h5 class="card-title">Transaksi Penjualan</h5>
                            <p class="card-text">Cepat, otomatis hitung total, dan cetak struk.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card border-0 shadow h-100 card-service">
                        <div class="card-body">
                            <i class="fas fa-chart-line mb-3"></i>
                            <h5 class="card-title">Laporan Real-Time</h5>
                            <p class="card-text">Stok, penjualan, dan keuntungan tersaji grafis interaktif.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery - foto lokal -->
    <section id="gallery" class="bg-light">
        <div class="container text-center">
            <h2 class="fw-bold mb-5" data-aos="fade-up">Galeri Hewan</h2>
            <div class="row g-3">
                <?php
                // scan folder img, ambil semua *.jpg | *.png | *.jpeg
                $dir = 'img/';
                $files = glob($dir . '*.{jpg,jpeg,png}', GLOB_BRACE); // array file
                foreach ($files as $img) {
                    echo '<div class="col-6 col-md-4" data-aos="zoom-in">
                  <img src="' . $img . '" class="img-fluid rounded gallery" alt="pet">
                </div>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <h5><i class="fas fa-paw"></i> PetShop System</h5>
            <p class="mb-0">&copy; <?= date('Y') ?> - Dibuat Oleh Kelompok 1.</p>
        </div>
    </footer>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true });
    </script>
</body>

</html>