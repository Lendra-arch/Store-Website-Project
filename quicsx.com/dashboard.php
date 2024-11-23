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

include "service/database.php";
$username = $_SESSION['username'];

// Menyimpan pesanan
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $pesanan = $_POST['pesanan'];
//     $sql = "INSERT INTO pesanan (id, pesanan) VALUES ('$username', '$pesanan')";
//     $conn->query($sql);
// }

$sql = "
    SELECT 
        pesanan.nomor_pesanan AS pesanan_id,
        users.username,
        pesanan.item,
        pesanan.harga,
        pesanan.tanggal_pesanan
    FROM pesanan
    JOIN users ON pesanan.user_id = users.id
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="styles.css">
    <title>Dashboard</title>
</head>
<body>
    <div class="container">
        <h2>Dashboard</h2>
        <h3>Total Pesanan</h3>
        <table>
            <tr>
                <th>NOMOR PESANAN</th>
                <th>USERNAME</th>
                <th>NAMA ITEM</th>
                <th>JUMLAH</th>
                <th>TANGGL PESANAN</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['pesanan_id'] ?></td>
                        <td><?php echo $row['username'] ?> </td>
                        <td><?php echo $row['item'] ?></td>
                        <td><?php echo $row['harga'] ?></td>
                        <td><?php echo $row['tanggal_pesanan'] ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">Anda belum memiliki pesanan.</td>
                </tr>
            <?php endif; ?>
        </table>

        <h3>Tambah Pesanan</h3>
        <form method="POST" action="">
            <input type="number" name="total_pesanan" placeholder="Total Pesanan" required>
            <button type="submit">Simpan Pesanan</button>
        </form>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
