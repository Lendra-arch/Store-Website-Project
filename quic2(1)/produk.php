<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <link rel="stylesheet" href="produk.css">
    <link rel="stylesheet" href="layout/footer.css">
</head>
<body>
    <?php include "layout/navbar.php" ; ?>
    <section class="services">
        <div class="container">
            <h2>Nih, Produk di Toko Kami</h2>
            <p>Klik untuk info lebih lanjut ya!</p>
            <div class="kategori">
            <h4 class="judul-kategori">Layanan Digital</h4>
            <div class="services-grid">
                <a href="E-Wallet.php" class="service-card">
                    <div class="service-icon">💳</div>
                    <h3>Top Up E-Wallet</h3>
                </a>
                <a href="/game-top-up.html" class="service-card">
                    <div class="service-icon">🎮</div>
                    <h3>Top Up Games</h3>
                </a>
                <a href="/bill-payment.html" class="service-card">
                    <div class="service-icon">📃</div>
                    <h3>Bayar Tagihan</h3>
                </a>
                </div>

                <div class="kategori">
                    <h4 class="judul-kategori">Jasa Digital</h4>
                    <div class="services-grid">
                <a href="/video-editing.html" class="service-card">
                    <div class="service-icon">🎥</div>
                    <h3>Jasa Edit Video</h3>
                </a>
                <a href="/photo-editing.html" class="service-card">
                    <div class="service-icon">📷</div>
                    <h3>Jasa Edit Foto</h3>
                </a>
                <a href="/photo-editing.html" class="service-card">
                    <div class="service-icon">📄</div>
                    <h3>Jasa Edit/Buat Dokumen</h3>
                </a>
                </div>
                </div>
            </div>
        </div>
    </section>
<?php include "layout/footer.php"; ?>
</body>
</html>