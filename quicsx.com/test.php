<?php
session_start();

include "service/database.php";
// Simulasi login (dalam aplikasi nyata, ini akan menjadi sistem login yang sebenarnya)
if (!isset($_SESSION['id'])) {
    $_SESSION['id'] = 1; // Anggap user dengan ID 1 yang sedang login
}

// Data item e-wallet
$items = array(
    array("nama" => "GoPay 10K", "harga" => 11000),
    array("nama" => "GoPay 20K", "harga" => 21000),
    array("nama" => "OVO 25K", "harga" => 26000),
    array("nama" => "OVO 50K", "harga" => 51000),
    array("nama" => "DANA 20K", "harga" => 21000),
    array("nama" => "DANA 50K", "harga" => 51000),
    array("nama" => "LinkAja 20K", "harga" => 21000),
    array("nama" => "LinkAja 50K", "harga" => 51000)
);

// Proses checkout
if (isset($_POST['checkout'])) {
    $user_id = $_SESSION['id'];
    $item = $_POST['item'];
    $harga = $_POST['harga'];
    
    $sql = "INSERT INTO pesanan (user_id, item, harga, tanggal_pesanan) VALUES ('$user_id', '$item', $harga, NOW())";
    
    if (mysqli_query($conn, $sql)) {
        echo "<p>Pesanan berhasil dibuat!</p>";
    } else {
        echo "<p>Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>E-Wallet Top Up</title>
</head>
<body>
    <h1>E-Wallet Top Up</h1>
    
    <form method="post" action="">
        <h2>Pilih Item:</h2>
        <select name="item" onchange="updateHarga(this.value)">
            <?php
            foreach ($items as $item) {
                echo "<option value='" . $item['nama'] . "' data-harga='" . $item['harga'] . "'>" . $item['nama'] . " - Rp " . number_format($item['harga']) . "</option>";
            }
            ?>
        </select>
        
        <br><br>
        <input type="hidden" name="harga" id="harga" value="<?php echo $items[0]['harga']; ?>">
        <input type="submit" name="checkout" value="Checkout">
    </form>

    <script>
    function updateHarga(item) {
        var select = document.querySelector('select[name="item"]');
        var option = select.options[select.selectedIndex];
        document.getElementById('harga').value = option.getAttribute('data-harga');
    }
    </script>

    <?php
    // Menampilkan riwayat pesanan
    $user_id = $_SESSION['id'];
    $sql = "SELECT * FROM pesanan WHERE user_id = $user_id ORDER BY tanggal_pesanan DESC LIMIT 5";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<h2>Riwayat Pesanan Terakhir:</h2>";
        echo "<ul>";
        while($row = mysqli_fetch_assoc($result)) {
            echo "<li>" . $row["item"] . " - Rp " . number_format($row["harga"]) . " - " . $row["tanggal_pesanan"] . "</li>";
        }
        echo "</ul>";
    }

    mysqli_close($conn);
    ?>
</body>
</html>