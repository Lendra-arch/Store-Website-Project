<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuicsX - Buat Hidupmu Jadi Lebih Mudah!</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="layout/footer.css">
    <link rel="stylesheet" href="layout/navbar.css">
    <link rel="icon" href="/quicsx.com/resources/logo.png">
</head>
<body>
<?php include "layout/navbar.php"; ?>
    <!-- Halaman Utama -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>Buat Hidupmu<br>Jadi Lebih Mudah!</h1>
                    <p>QuicsX hadir untuk membantu Anda. Dengan harga yang Murah namun Pelayanan Kualitas Bintang<br>⭐x5</p>
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
            <a class="card-services" href="page/produk-wallet.php">
                <div class="card-services-content">
                <h2>Top Up E-Wallet</h2>
                <p>Mendukung E-Wallet Berikut</p>
                <div class="group-icon">
                    <img src="images/icon-dana.png" class="icon">
                    <img src="images/icon-gopay.png" class="icon">
                    <img src="images/icon-ovo.png" class="icon">
                    <img src="images/icon-spay.png" class="icon">
                    <img src="images/icon-linkaja.jpg" class="icon">
                </div>
                </div>
                <div class="card-services-image"><img src="images/e-wallet.jpg" width="100%"></div>
            </a>

            <!-- <a class="card-services">
                <div class="card-services-content">
                <h2>Top Up Games</h2>
                <p>Games yang ada disini</p>
                <div class="group-icon">
                    <img src="images/icon-codm.png" class="icon">
                    <img src="images/icon-ff.png" class="icon">
                    <img src="images/icon-pubg.png" class="icon">
                    <img src="images/icon-genshin.png" class="icon">
                    <img src="images/icon-roblox.jpg" class="icon">
                    <img src="images/icon-ml.png" class="icon">
                </div>
                </div>
                <div class="card-services-image"><img src="images/games.png" width="100%"></div>
            </a> -->

             <a class="card-services" href="/quicsx.com/produk/convert.php">
                <div class="card-services-content">
                <h2>Convert Uang</h2>
                <p>Mata uang yang ada didukung</p>
                <p style="font-weight:bold;">RUPIAH & RINGGIT</p>
                </div>
                <div class="card-services-image"><img src="images/money.png" width="100%"></div>
            </a>

            <a class="card-services" href="/quicsx.com/produk/edit-video.php">
                <div class="card-services-content">
                <h2>Edit Video</h2>
                <p>Meliputi</p>
                <p style="font-weight:bold;">Subtitle, Cut video, Color Grading, Dll.</p>
                </div>
                <div class="card-services-image"><img src="images/video.jpg" width="100%"></div>
            </a>

            <a class="card-services" href="/quicsx.com/produk/edit-foto.php">
                <div class="card-services-content">
                <h2>Edit Foto</h2>
                <p>Meliputi</p>
                <p style="font-weight:bold;">Hapus Object, Hapus Background, Perbaikan Warna, Dll.</p>
                </div>
                <div class="card-services-image"><img src="images/foto.jpg" width="100%"></div>
            </a>

            <a class="card-services" href="/quicsx.com/produk/edit-dokumen.php">
                <div class="card-services-content">
                <h2>Edit atau Buat Dokumen</h2>
                <p>Meliputi</p>
                <p style="font-weight:bold;">Bikin Makalah, Perbaikan Struktur, Penataan Layout, Dll.</p>
                </div>
                <div class="card-services-image"><img src="images/dokumen.jpg" width="100%"></div>
            </a>
            <a href="/quicsx.com/page/layanan.php" class="btn" style="float: right;">Pergi ke Layanan >></a>
        </div>
    </section>

    <section class="solution">
        <div class="container">
            <div class="solution-content">
                <div class="solution-image">
                    <img src="resources/cus.png" alt="Customer service illustration" style="margin: 0 0 -8px 0; z-index: -2;">
                </div>
                <div class="solution-steps" style="margin: 0 0 2rem 0;">
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
                    <a href="https://api.whatsapp.com/send?phone=6285745735072&text=Min mau tanya boleh?
                    " class="btn" style="margin-top: 1.5rem;">Mulai Sekarang</a>
                </div>
            </div>
        </div>
    </section>
   <?php include "layout/footer.php"; ?>
</body>
</html>