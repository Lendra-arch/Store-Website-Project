<?php
// Daftar gambar
$images = [
    "../images/banner1.jpg",
    "../images/banner2.jpg",
    "../images/banner3.jpg"
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <link rel="stylesheet" href="../css/produk.css">
    <link rel="stylesheet" href="../layout/footer.css">
</head>
<body>
    <?php include "../layout/navbar.php" ?>
    <h1 style="    text-align: center; font-size: 2rem; margin-bottom: 2rem; color: #1a365d;">Produk Kami</h1>
    <img id="image-slider" src="<?php echo $images[0]; ?>" alt="Banner" style="justify-self: center; object-fit:cover; width:60%; max-width: 1000px; max-height:200px; display: block; border-radius: 20px;">
    <section>
        <h2>E-Wallet</h2>
        <div class="menu-container">
            <div class="menu-item">
                <a href="../produk/gopay.php">
                    <img src="../images/gopay.jpg" alt="GoPay">
                    <div class="menu-title">GoPay</div>
                </a>
            </div>
            <div class="menu-item">
                <a href="../produk/ovo.php">
                    <img src="../images/ovo.jpg" alt="OVO">
                    <div class="menu-title">OVO</div>
                </a>
            </div>
            <div class="menu-item">
                <a href="../produk/dana.php">
                    <img src="../images/dana.jpg" alt="DANA">
                    <div class="menu-title">DANA</div>
                </a>
            </div>
            <div class="menu-item">
                <a href="../produk/linkaja.php">
                    <img src="../images/linkaja.jpg" alt="LinkAja">
                    <div class="menu-title">LinkAja</div>
                </a>
            </div>
            <div class="menu-item">
                <a href="../produk/shopeepay.php">
                    <img src="../images/shopeepay.jpg" alt="ShopeePay">
                    <div class="menu-title">ShopeePay</div>
                </a>
            </div>
        </div>
    </section>

    <section>
        <h2>Games</h2>
        <div class="menu-container">
            <div class="menu-item">
                <a href="../produk/mobile-legends.php">
                    <img src="../images/ml.jpg" alt="Mobile Legends">
                    <div class="menu-title">Mobile Legends</div>
                </a>
            </div>
            <div class="menu-item">
                <a href="../produk/pubg.php">
                    <img src="../images/pubg.jpg" alt="PUBG Mobile">
                    <div class="menu-title">PUBG Mobile</div>
                </a>
            </div>
            <div class="menu-item">
                <a href="../produk/free-fire.php">
                    <img src="../images/ff.jpg" alt="Free Fire">
                    <div class="menu-title">Free Fire</div>
                </a>
            </div>
            <div class="menu-item">
                <a href="../produk/genshin.php">
                    <img src="../images/genshin.jpg" alt="Genshin Impact">
                    <div class="menu-title">Genshin Impact</div>
                </a>
            </div>
            <div class="menu-item">
                <a href="../produk/roblox.php">
                    <img src="../images/roblox.jpg" alt="Roblox">
                    <div class="menu-title">Roblox</div>
                </a>
            </div>
            <div class="menu-item">
                <a href="../produk/cod-mobile.php">
                    <img src="../images/codm.jpg" alt="Call of Duty Mobile">
                    <div class="menu-title">Call of Duty Mobile</div>
                </a>
            </div>
        </div>
    </section>

    <section>
        <h2>Layanan Digital</h2>
        <div class="menu-container">
            <div class="menu-item">
                <a href="../produk/edit-foto.php">
                    <img src="../images/edit-foto.jpeg" alt="Edit Foto">
                    <div class="menu-title">Edit Foto</div>
                </a>
            </div>
            <div class="menu-item">
                <a href="../produk/edit-video.php">
                    <img src="../images/edit-video.jpg" alt="Edit Video">
                    <div class="menu-title">Edit Video</div>
                </a>
            </div>
            <div class="menu-item">
                <a href="../produk/edit-dokumen.php">
                    <img src="../images/edit-dokumen.jpg" alt="Edit Dokumen">
                    <div class="menu-title">Dokumen</div>
                </a>
            </div>
        </div>
    </section>
    <?php include "../layout/footer.php" ?>
    <script>
        // Daftar gambar dari PHP
        const images = <?php echo json_encode($images); ?>;

        // Mendapatkan elemen gambar
        const imageElement = document.getElementById('image-slider');

        // Indeks gambar saat ini
        let currentIndex = 0;

        // Fungsi untuk mengganti gambar
        function changeImage() {
            currentIndex = (currentIndex + 1) % images.length; // Pergantian indeks
            imageElement.src = images[currentIndex]; // Ganti src gambar
        }

        // Jalankan fungsi setiap 3 detik
        setInterval(changeImage, 3000);
    </script>
</body>
</html>