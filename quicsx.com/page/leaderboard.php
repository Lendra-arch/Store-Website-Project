<?php
include "../service/database.php"; // Koneksi ke database

// Query untuk mendapatkan leaderboard
$sql = "SELECT 
            users.username,
            SUM(pesanan.harga) AS total_transaksi
        FROM 
            users u
        JOIN 
            pesanan p
        ON 
            u.user_id = p.user_id
        GROUP BY 
            u.user_id
        ORDER BY 
            total_transaksi DESC
        LIMIT 10"; // Batasi 10 besar
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
    <div class="container">
        <h1>🏆 Leaderboard</h1>
        <table>
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Username</th>
                    <th>Total Transaksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $rank = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $rank++ . "</td>
                                <td>" . htmlspecialchars($row['username']) . "</td>
                                <td>Rp " . number_format($row['total_transaksi'], 0, ',', '.') . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Belum ada transaksi.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
