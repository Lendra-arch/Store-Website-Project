<?php

    if (session_status() == PHP_SESSION_NONE) {

        session_start();

    }
?>

<nav>
    <div class="container">
        <a href="#" class="logo">Quics<span style="color: #FF5C00 ">X</span></a>
        <div class="nav-links">
            <a href="/index.php">Home</a>
            <a href="/page/leaderboard.php" >Leaderboard</a>
            <?php if (isset($_SESSION['username'])): ?>
                <!-- Navbar 2: User sudah login -->
            <?php if ($_SESSION["role"] === 'admin'): ?>
                <!-- Navbar 3: Admin yang login -->
                    <a href="/page/layanan.php" >Produk</a>
                    <a href="/page/dashboard.php" >Dashboard</a>
                    <a href="#">Halo,  <?php echo htmlspecialchars($_SESSION['username']); ?></a>
                    <a href="/page/logout.php" class="link-custom">Logout</a>
                <?php else: ?>
                    <a href="/page/layanan.php" >Produk</a>
                    <a href="#">Halo,  <?php echo htmlspecialchars($_SESSION['username']); ?></a>
                    <a href="/page/logout.php" class="link-custom">Logout</a>
            <?php endif; ?>
                <?php else: ?>
                <!-- Navbar 1: User belum login -->
                    <a href="/page/About.php">About</a>
                    <a href="/page/login.php">Login</a>
            <?php endif; ?>
    </div>
</nav>