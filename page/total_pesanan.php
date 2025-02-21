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

$username = $_SESSION['username'];

// Pagination setup
$limit = 10; // Maksimal 10 data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Pencarian dan filter status
$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter_status = isset($_GET['status']) ? $_GET['status'] : '';

// Query dengan pagination, pencarian, dan filter status
$sql = "
    SELECT 
        pesanan.nomor_pesanan AS pesanan_id,
        users.username,
        pesanan.item,
        pesanan.harga,
        pesanan.tanggal_pesanan,
        pesanan.status
    FROM pesanan
    JOIN users ON pesanan.user_id = users.id
    WHERE pesanan.nomor_pesanan LIKE ?
";

// Tambahkan filter status jika ada
if (!empty($filter_status) && $filter_status !== 'all') {
    $sql .= " AND pesanan.status = ?";
}

// Tambahkan urutan berdasarkan tanggal terbaru
$sql .= " ORDER BY pesanan.tanggal_pesanan DESC";

// Tambahkan limit dan offset
$sql .= " LIMIT ?, ?";

$stmt = $conn->prepare($sql);
$search_param = "%$search%";

// Bind parameter berdasarkan adanya filter status
if (!empty($filter_status) && $filter_status !== 'all') {
    $stmt->bind_param("ssii", $search_param, $filter_status, $start, $limit);
} else {
    $stmt->bind_param("sii", $search_param, $start, $limit);
}
$stmt->execute();
$result = $stmt->get_result();

// Total data untuk pagination
$total_sql = "
    SELECT COUNT(*) AS total 
    FROM pesanan 
    WHERE nomor_pesanan LIKE ?
";
if (!empty($filter_status) && $filter_status !== 'all') {
    $total_sql .= " AND status = ?";
}
$total_stmt = $conn->prepare($total_sql);
if (!empty($filter_status) && $filter_status !== 'all') {
    $total_stmt->bind_param("ss", $search_param, $filter_status);
} else {
    $total_stmt->bind_param("s", $search_param);
}
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_data = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_data / $limit);

// Hapus atau update data jika form dikirim
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['action']) && isset($_POST['selected_ids'])) {
        $selected_ids = $_POST['selected_ids'];

        if ($_POST['action'] === 'delete') {
            // Hapus data
            $placeholders = implode(',', array_fill(0, count($selected_ids), '?'));
            $delete_sql = "DELETE FROM pesanan WHERE nomor_pesanan IN ($placeholders)";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param(str_repeat('i', count($selected_ids)), ...$selected_ids);
            $delete_stmt->execute();
        } elseif ($_POST['action'] === 'update') {
            // Update status
            $new_status = $_POST['bulk_status'];
            $placeholders = implode(',', array_fill(0, count($selected_ids), '?'));
            $update_sql = "UPDATE pesanan SET status = ? WHERE nomor_pesanan IN ($placeholders)";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("s" . str_repeat('i', count($selected_ids)), $new_status, ...$selected_ids);
            $update_stmt->execute();
        }

        header("Location: total_pesanan.php?page=$page&search=$search&status=$filter_status");
        exit();
    }
}

// Mengambil data total pesanan
$sql_total_pesanan = "SELECT COUNT(*) AS total_pesanan FROM pesanan";
$result_total_pesanan = $conn->query($sql_total_pesanan);
$total_pesanan = $result_total_pesanan->fetch_assoc()['total_pesanan'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../layout/navbar.css">
    <link rel="stylesheet" href="../css/subdashboard.css">
    <link rel="stylesheet" href="../layout/footer.css">
    <link rel="icon" href="/resources/logo.png">
    <title>Dashboard</title>
</head>
<body>
    <?php include "../layout/navbar.php" ?>
    <div class="kotak">
        <a href="/page/dashboard.php" style="text-decoration: none; font-weight: bold; color: black;">< Kembali</a>
        <a href="total_pesanan.php" class="dashboard-card card-pesanan">
            <div class="card-title">Total Pesanan</div>
            <div class="card-value" style="text-align: right;"><?php echo $total_pesanan; ?></div>
        </a>
        <!-- Form Pencarian -->
        <form method="GET" class="search-form">
            <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Cari ID Pesanan">
            <select name="status">
                <option value="all" <?php echo $filter_status === 'all' ? 'selected' : ''; ?>>Semua Status</option>
                <option value="proses" <?php echo $filter_status === 'proses' ? 'selected' : ''; ?>>Proses</option>
                <option value="berhasil" <?php echo $filter_status === 'berhasil' ? 'selected' : ''; ?>>Berhasil</option>
                <option value="gagal" <?php echo $filter_status === 'gagal' ? 'selected' : ''; ?>>Gagal</option>
            </select>
            <button type="submit">Cari</button>
        </form>

        <h3>Pesanan</h3>
        <form method="POST">
            <table>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>NOMOR PESANAN</th>
                    <th>USERNAME</th>
                    <th>NAMA ITEM</th>
                    <th>JUMLAH</th>
                    <th>TANGGAL PESANAN</th>
                    <th>STATUS</th>
                </tr>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><input type="checkbox" name="selected_ids[]" value="<?php echo $row['pesanan_id']; ?>"></td>
                            <td><?php echo $row['pesanan_id']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['item']; ?></td>
                            <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                            <td><?php echo $row['tanggal_pesanan']; ?></td>
                            <td><?php
                            // Menambahkan warna pada status
                            switch ($row['status']) {
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
                                    echo ucfirst($row['status']);
                                    break;
                            }
                            ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">Tidak ada data yang ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </table>

            <!-- Menu Aksi -->
            <div style="margin-top: 10px;">
                <select name="action" required>
                    <option value="">-- Pilih Aksi --</option>
                    <option value="delete">Hapus Data Terpilih</option>
                    <option value="update">Update Status</option>
                </select>
                <select name="bulk_status" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="proses">Proses</option>
                    <option value="berhasil">Berhasil</option>
                    <option value="gagal">Gagal</option>
                </select>
                <button type="submit">Kirim</button>
            </div>
        </form>

        <!-- Pagination -->
        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($filter_status); ?>" 
                   class="<?php echo $i == $page ? 'active' : ''; ?>">
                   <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>
    </div>
    <?php include "../layout/footer.php" ?>

    <script>
        // Pilih semua checkbox
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[name="selected_ids[]"]');
            for (const checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>
