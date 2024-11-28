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

// Hapus pengguna jika form dikirim
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete'])) {
    $selected_ids = $_POST['selected_ids'] ?? [];
    if (count($selected_ids) > 0) {
        $placeholders = implode(',', array_fill(0, count($selected_ids), '?'));
        $delete_sql = "DELETE FROM users WHERE id IN ($placeholders)";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param(str_repeat('i', count($selected_ids)), ...$selected_ids);
        $delete_stmt->execute();
        header("Location: total_user.php");
        exit();
    }
}

// Mendapatkan data pengguna dari tabel users
$sql_users = "SELECT id, username, role, date FROM users ORDER BY date DESC";
$result_users = $conn->query($sql_users);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Users</title>
    <link rel="stylesheet" href="../css/subdashboard.css">
    <link rel="stylesheet" href="../layout/navbar.css">
    <link rel="stylesheet" href="../layout/footer.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .btn-delete {
            margin-top: 10px;
            padding: 10px 15px;
            background-color: #ff4d4d;
            color: white;
            border: none;
            cursor: pointer;
        }
        .btn-delete:hover {
            background-color: #cc0000;
        }
        .container {
            margin: 20px auto;
            max-width: 1200px;
        }
    </style>
</head>
<body>
    <?php include "../layout/navbar.php"; ?>
    <div class="kotak">
        <h1>Daftar Pengguna</h1>
        <form method="POST">
            <table>
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Tanggal Bergabung</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result_users->num_rows > 0): ?>
                        <?php while ($row = $result_users->fetch_assoc()): ?>
                            <tr>
                                <td><input type="checkbox" name="selected_ids[]" value="<?php echo $row['id']; ?>"></td>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                                <td><?php echo htmlspecialchars($row['role']); ?></td>
                                <td><?php echo $row['date']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">Tidak ada pengguna yang ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <button type="submit" name="delete" class="btn-delete">Hapus Pengguna Terpilih</button>
        </form>
    </div>

    <script>
        // Pilih semua checkbox
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[name="selected_ids[]"]');
            for (const checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });
    </script>
    <?php include "../layout/footer.php" ?>
</body>
</html>

<?php
$conn->close();
?>
