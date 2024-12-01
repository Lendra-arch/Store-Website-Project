<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hero Section with Background and Foreground Image</title>
    <style>
        /* CSS */

        /* Styling Hero Section */
        .hero {
            position: relative; /* Menjadikan parent elemen untuk posisi absolute */
            background-image: url('images/ml.jpg'); /* Ganti dengan gambar background Anda */
            background-size: cover; /* Agar gambar memenuhi seluruh area */
            background-position: center; /* Posisi gambar di tengah */
            height: 400px; /* Tinggi hero section */
            display: flex; /* Untuk memposisikan konten di tengah */
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white; /* Warna teks */
            overflow: hidden; /* Konten tetap di dalam area */
        }

        /* Styling untuk konten teks */
        .hero-content {
            background: rgba(0, 0, 0, 0.5); /* Overlay gelap transparan agar teks lebih terlihat */
            padding: 20px;
            border-radius: 10px;
            z-index: 1; /* Pastikan berada di depan background */
        }

        /* Styling gambar foreground */
        .hero-image {
            position: absolute; /* Posisi bebas di dalam hero */
            bottom: 0; /* Selalu di bawah */
            left: 0; /* Selalu di kiri */
            width: 150px; /* Ukuran gambar */
            z-index: 2; /* Berada di depan background */
            transform: translate(-10%, 10%); /* Menggeser posisi gambar */
        }

        /* Styling tombol */
        .btn {
            background-color: #00796b;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            margin: 10px;
            text-decoration: none;
            font-weight: bold;
        }

        .btn.secondary {
            background-color: #004d40;
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero">
        <!-- Konten teks -->
        <div class="hero-content">
            <h1>Say hello to your new favorite drinking buddy</h1>
            <p>...and goodbye to rough mornings</p>
            <a href="#" class="btn">Shop Morning Recovery</a>
            <a href="#" class="btn secondary">Subscribe & Save</a>
        </div>
        <!-- Gambar foreground -->
        <img src="images/banner.jpg" alt="Bottle" class="hero-image">
    </section>
</body>
</html>
