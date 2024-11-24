<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
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

// Pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query dengan pagination dan pencarian
$sql = "
    SELECT 
        pesanan.nomor_pesanan AS pesanan_id,
        users.username,
        pesanan.item,
        pesanan.harga,
        pesanan.tanggal_pesanan
    FROM pesanan
    JOIN users ON pesanan.user_id = users.id
    WHERE pesanan.nomor_pesanan LIKE ?
    LIMIT ?, ?
";

$stmt = $conn->prepare($sql);
$search_param = "%$search%";
$stmt->bind_param("sii", $search_param, $start, $limit);
$stmt->execute();
$result = $stmt->get_result();

// Total data untuk pagination
$total_sql = "
    SELECT COUNT(*) AS total 
    FROM pesanan 
    WHERE nomor_pesanan LIKE ?
";
$total_stmt = $conn->prepare($total_sql);
$total_stmt->bind_param("s", $search_param);
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_data = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_data / $limit);

// Hapus data jika form dikirim
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete'])) {
    $selected_ids = $_POST['selected_ids'] ?? [];
    if (count($selected_ids) > 0) {
        $placeholders = implode(',', array_fill(0, count($selected_ids), '?'));
        $delete_sql = "DELETE FROM pesanan WHERE nomor_pesanan IN ($placeholders)";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param(str_repeat('i', count($selected_ids)), ...$selected_ids);
        $delete_stmt->execute();
        header("Location: dashboard.php?page=$page&search=$search");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../layout/footer.css">
    <title>Dashboard</title>
</head>
<body>
    <?php include "../layout/navbar.php" ?>
    <div class="kotak">
        <h2>Dashboard</h2>

        <!-- Form Pencarian -->
        <form method="GET" class="search-form">
            <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Cari ID Pesanan">
            <button type="submit">Cari</button>
        </form>

        <h3>Riwayat Pesanan</h3>
        <form method="POST">
            <table>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>NOMOR PESANAN</th>
                    <th>USERNAME</th>
                    <th>NAMA ITEM</th>
                    <th>JUMLAH</th>
                    <th>TANGGAL PESANAN</th>
                </tr>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><input type="checkbox" name="selected_ids[]" value="<?php echo $row['pesanan_id']; ?>"></td>
                            <td><?php echo $row['pesanan_id']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['item']; ?></td>
                            <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                            <td><?php echo $row['tanggal_pesanan']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">Tidak ada data yang ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </table>
            <button type="submit" name="delete" style="margin-top: 10px;">Hapus Data Terpilih</button>
        </form>

        <!-- Pagination -->
        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>" 
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
