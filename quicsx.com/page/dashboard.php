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

// Ambil data yang dibutuhkan untuk dashboard
$sql_total_users = "SELECT COUNT(*) AS total_users FROM users";
$total_users_result = $conn->query($sql_total_users);
$total_users = $total_users_result->fetch_assoc()['total_users'];

// Pengguna Aktif (sudah melakukan transaksi)
$sql_active_users = "SELECT COUNT(DISTINCT user_id) AS active_users FROM pesanan";
$active_users_result = $conn->query($sql_active_users);
$active_users = $active_users_result->fetch_assoc()['active_users'];

// Pengguna Pasif (belum melakukan transaksi)
$passive_users = $total_users - $active_users;

$sql_total_orders = "SELECT COUNT(*) AS total_orders FROM pesanan";
$total_orders_result = $conn->query($sql_total_orders);
$total_orders = $total_orders_result->fetch_assoc()['total_orders'];

// Pesanan berhasil, dalam proses, dan gagal
$sql_orders_status = "SELECT 
                        SUM(CASE WHEN status = 'berhasil' THEN 1 ELSE 0 END) AS berhasil,
                        SUM(CASE WHEN status = 'proses' THEN 1 ELSE 0 END) AS proses,
                        SUM(CASE WHEN status = 'gagal' THEN 1 ELSE 0 END) AS gagal
                      FROM pesanan";
$orders_status_result = $conn->query($sql_orders_status);
$orders_status = $orders_status_result->fetch_assoc();

// Total Pendapatan
$sql_total_revenue = "SELECT SUM(harga) AS total_revenue FROM pesanan WHERE status = 'berhasil'";
$total_revenue_result = $conn->query($sql_total_revenue);
$total_revenue = $total_revenue_result->fetch_assoc()['total_revenue'];

// Pendapatan hari ini
$sql_today_revenue = "SELECT SUM(harga) AS today_revenue FROM pesanan WHERE status = 'berhasil' AND DATE(tanggal_pesanan) = CURDATE()";
$today_revenue_result = $conn->query($sql_today_revenue);
$today_revenue = $today_revenue_result->fetch_assoc()['today_revenue'];

// Cek apakah pendapatan hari ini ada atau tidak
if ($today_revenue == 0 || is_null($today_revenue)) {
    $today_revenue_display = "Tidak ada :(";
} else {
    $today_revenue_display = $today_revenue . " IDR";
}

// Pendapatan dalam sebulan
$sql_monthly_revenue = "SELECT SUM(harga) AS monthly_revenue FROM pesanan WHERE status = 'berhasil' AND YEAR(tanggal_pesanan) = YEAR(CURDATE()) AND MONTH(tanggal_pesanan) = MONTH(CURDATE())";
$monthly_revenue_result = $conn->query($sql_monthly_revenue);
$monthly_revenue = $monthly_revenue_result->fetch_assoc()['monthly_revenue'];

// Ambil data pengguna terbaru
$sql_recent_users = "SELECT username, date FROM users ORDER BY date DESC LIMIT 5";
$recent_users_result = $conn->query($sql_recent_users);

// Ambil data pesanan terbaru
$sql_recent_orders = "SELECT pesanan.nomor_pesanan, users.username, pesanan.item, pesanan.status, pesanan.tanggal_pesanan 
                      FROM pesanan 
                      JOIN users ON pesanan.user_id = users.id 
                      ORDER BY pesanan.tanggal_pesanan DESC LIMIT 5";
$recent_orders_result = $conn->query($sql_recent_orders);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../layout/navbar.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../layout/footer.css">
    <link rel="icon" href="/quicsx.com/resources/logo.png">
    <title>Admin Dashboard</title>
</head>
<body>
    <?php include "../layout/navbar.php" ?>
    <div class="kotak">
        <h2>Dashboard Panel</h2>

        <!-- Statistik Pengguna -->
        <div class="stats-container">
            <div class="stat-box" style="width: 90%;">
                <div class="stat-box-header">Statistik Pengguna</div>
                <div class="stat-box-content">
                    <div class="card">
                        <div class="card-title">Total Pengguna</div>
                        <div class="card-value"><?php echo $total_users; ?></div>
                    </div>
                    <div class="card">
                        <div class="card-title">Pengguna Aktif</div>
                        <div class="card-value"><?php echo $active_users; ?></div>
                    </div>
                    <div class="card">
                        <div class="card-title">Pengguna Pasif</div>
                        <div class="card-value"><?php echo $passive_users; ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Pesanan -->
        <div class="stats-container">
            <div class="stat-box" style="width: 90%;">
                <div class="stat-box-header">Statistik Pesanan</div>
                <div class="stat-box-content">
                    <div class="card">
                        <div class="card-title">Total Pesanan</div>
                        <div class="card-value"><?php echo $total_orders; ?></div>
                    </div>
                    <div class="card">
                        <div class="card-title">Pesanan Berhasil</div>
                        <div class="card-value"><?php echo $orders_status['berhasil']; ?></div>
                    </div>
                    <div class="card">
                        <div class="card-title">Pesanan Proses</div>
                        <div class="card-value"><?php echo $orders_status['proses']; ?></div>
                    </div>
                    <div class="card">
                        <div class="card-title">Pesanan Gagal</div>
                        <div class="card-value"><?php echo $orders_status['gagal']; ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Pendapatan -->
        <div class="stats-container">
            <div class="stat-box" style="width: 90%;">
                <div class="stat-box-header">Statistik Pendapatan</div>
                <div class="stat-box-content">
                    <div class="card">
                        <div class="card-title">Total Pendapatan</div>
                        <div class="card-value"><?php echo $total_revenue; ?> IDR</div>
                    </div>
                    <div class="card">
                        <div class="card-title">Pendapatan Hari Ini</div>
                        <div class="card-value"><?php echo $today_revenue_display; ?></div>
                    </div>
                    <div class="card">
                        <div class="card-title">Pendapatan Bulan Ini</div>
                        <div class="card-value"><?php echo $monthly_revenue; ?> IDR</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Cepat -->
        <div class="menu-box">
            <h2>Menu Cepat</h2>
            <a href="total_pesanan.php" class="action-link">Lihat Semua Pesanan</a>
            <a href="total_user.php" class="action-link">Lihat Semua Pengguna</a>
            <a href="total_pembayaran.php" class="action-link">Lihat Semua Pembayaran</a>
        </div>

        <!-- Pengguna Terbaru -->
        <div class="dashboard-box">
            <h3>Pengguna Terbaru</h3>
            <table>
                <tr>
                    <th>Username</th>
                    <th>Tanggal Bergabung</th>
                </tr>
                <?php while ($user = $recent_users_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['date']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <!-- Pesanan Terbaru -->
        <div class="dashboard-box">
            <h3>Pemesanan Terbaru</h3>
            <table>
                <tr>
                    <th>Nomor Pesanan</th>
                    <th>Username</th>
                    <th>Nama Item</th>
                    <th>Status</th>
                    <th>Tanggal Pesanan</th>
                </tr>
                <?php while ($order = $recent_orders_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $order['nomor_pesanan']; ?></td>
                        <td><?php echo $order['username']; ?></td>
                        <td><?php echo $order['item']; ?></td>
                        <td>
                            <?php
                            // Menambahkan warna pada status
                            switch ($order['status']) {
                                case 'proses':
                                    echo "<span style='color: orange;'>Proses</span>";
                                    break;
                                case 'berhasil':
                                    echo "<span style='color: green;'>Berhasil</span>";
                                    break;
                                case 'gagal':
                                    echo "<span style='color: red;'>Gagal</span>";
                                    break;
                                default:
                                    echo ucfirst($order['status']);
                                    break;
                            }
                            ?>
                        </td>
                        <td><?php echo $order['tanggal_pesanan']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>

    </div>

    <?php include "../layout/footer.php" ?>
</body>
</html>

<?php
$conn->close();
?>
