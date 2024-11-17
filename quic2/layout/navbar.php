<?php
session_start(); // Memulai sesi
?>

<nav>
        <div class="container">
            <a href="#" class="logo">Quics<span style="color: #FF5C00 ">X</span></a>
            <div class="nav-links">
                <a href="index.php">Home</a>
                <a href="About.php">About</a>
                <?php if (isset($_SESSION['username'])): ?>
                    <!-- Navbar 2: User sudah login -->
                    <a href="#">Hello, <?php echo htmlspecialchars($_SESSION['username']); ?></a>
                    <a href="logout.php" >Logout</a>
                    <?php else: ?>
                        <!-- Navbar 1: User belum login -->
                        <a href="login.php">Login</a>
                        <?php endif; ?>
    </div>
</nav>
