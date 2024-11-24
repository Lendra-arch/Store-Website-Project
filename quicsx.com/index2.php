<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuicsX - Buat Hidupmu Jadi Lebih Mudah!</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="layout/footer.css">
    <link rel="icon" href="resources/logo.png">
</head>
<body>
<?php include "layout/navbar.php"; ?>
    <!-- Halaman Utama -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>Buat Hidupmu<br>Jadi Lebih Mudah!</h1>
                    <p>QuicsX hadir untuk membantu kegiatan digital dengan cepat dan nyaman setiap saat.</p>
                    <a href="page/About.php" class="btn">Learn More</a>
                </div>
                <div class="hero-image">
                    <img src="resources/home.png" alt="Digital services illustration">
                </div>
            </div>
        </div>
    </section>

    <section class="services">
        <div class="container">
            <h2><span style="color: #1456b3;">Layanan</span> Yang<br>Kami Sediakan!</h2>
            <div class="services-grid">
                <a href="#.html" class="service-card">
                    <div class="service-icon">💳</div>
                    <h3>Top Up E-Wallet</h3>
                </a>
                <a href="#" class="service-card">
                    <div class="service-icon">🎮</div>
                    <h3>Top Up Games</h3>
                </a>
                <a href="#" class="service-card">
                    <div class="service-icon">📃</div>
                    <h3>Bayar Tagihan</h3>
                </a>
                <a href="#" class="service-card">
                    <div class="service-icon">🎥</div>
                    <h3>Jasa Edit Video</h3>
                </a>
                <a href="#" class="service-card">
                    <div class="service-icon">📷</div>
                    <h3>Jasa Edit Foto</h3>
                </a>
                <a href="#" class="service-card">
                    <div class="service-icon">📄</div>
                    <h3>Jasa Edit/Buat Dokumen</h3>
                </a>
            </div>
        </div>
    </section>

    <section class="solution">
        <div class="container">
            <div class="solution-content">
                <div class="solution-image">
                    <img src="resources/cus.png" alt="Customer service illustration">
                </div>
                <div class="solution-steps">
                    <h2>Solusi Simpel!</h2>
                    <div class="step-item">
                        <div class="step-number">1</div>
                        <span>Hubungi Kami</span>
                    </div>
                    <div class="step-item">
                        <div class="step-number">2</div>
                        <span>Konsultasi</span>
                    </div>
                    <div class="step-item">
                        <div class="step-number">3</div>
                        <span>Taruh Pesanan</span>
                    </div>
                    <div class="step-item">
                        <div class="step-number">4</div>
                        <span>Pembayaran</span>
                    </div>
                    <a href="https://api.whatsapp.com/send?phone=6282184591229&text=Min mau tanya boleh?
                    " class="btn" style="margin-top: 1.5rem;">Mulai Sekarang</a>
                </div>
            </div>
        </div>
    </section>
   <?php include "layout/footer.php"; ?>
</body>
</html>