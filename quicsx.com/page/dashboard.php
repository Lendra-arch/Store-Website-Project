<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: /quicsx.com/page/login.php");
    exit();
}

// Cek apakah user adalah admin
if ($_SESSION['role'] !== 'admin') {
    echo "<script>alert('Anda tidak memiliki akses ke sini!')</script>";
    exit();
}

include "../service/database.php";

// Mengambil data total pesanan
$sql_total_pesanan = "SELECT COUNT(*) AS total_pesanan FROM pesanan";
$result_total_pesanan = $conn->query($sql_total_pesanan);
$total_pesanan = $result_total_pesanan->fetch_assoc()['total_pesanan'];

// Mengambil data total pembayaran
$sql_total_pembayaran = "SELECT SUM(harga) AS total_pembayaran FROM pesanan";
$result_total_pembayaran = $conn->query($sql_total_pembayaran);
$total_pembayaran = $result_total_pembayaran->fetch_assoc()['total_pembayaran'] ?? 0;

// Mengambil data total user aktif
$sql_total_user = "SELECT COUNT(*) AS total_user FROM users";
$result_total_user = $conn->query($sql_total_user);
$total_user = $result_total_user->fetch_assoc()['total_user'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../layout/navbar.css">
    <link rel="stylesheet" href="../layout/footer.css">
    <title>Dashboard</title>
</head>
<body>
    <?php include "../layout/navbar.php"; ?>

    <div class="dashboard-container">
        <!-- Kartu Total Pesanan -->
        <a href="total_pesanan.php" class="dashboard-card card-pesanan">
            <div class="card-title">Total Pesanan</div>
            <div class="card-value"><?php echo $total_pesanan; ?></div>
        </a>

        <!-- Kartu Total Pembayaran -->
        <a href="total_pembayaran.php" class="dashboard-card card-pembayaran">
            <div class="card-title">Total Pembayaran</div>
            <div class="card-value">Rp <?php echo number_format($total_pembayaran, 0, ',', '.'); ?></div>
        </a>

        <!-- Kartu Total User -->
        <a href="total_user.php" class="dashboard-card card-user">
            <div class="card-title">Total User Aktif</div>
            <div class="card-value"><?php echo $total_user; ?></div>
        </a>
    </div>

    <?php include "../layout/footer.php"; ?>
</body>
</html>

<?php
$conn->close();
?>