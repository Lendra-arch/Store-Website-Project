<?php
session_start();
include "../service/database.php";

// Jika Uswr sudah login, ambil user id nya
if (isset($_SESSION['user_id'])) {
    // Ambil user_id dari session
    $user_id = $_SESSION['user_id'];
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['pesan'] = 'login dulu sebelum melanjutkan';
        header("Location: ../page/login.php"); // Jika belum login, arahkan ke halaman login
        exit;
    } else{
    $uid = $_POST['uid'];
    $sid = $_POST['sid'];
    $item =  $_POST['item'];
    $item = "MLBB ". $item;
    $price = $_POST['item_price'] + 1000; // Tambahkan biaya administrasi 1000 rupiah
    $payment_method = $_POST['payment_method']; // Ambil metode pembayaran
    $info = "User ID: $uid | Server ID: $sid";

    // Query untuk memasukkan data ke dalam tabel pesanan
    $sql = "INSERT INTO pesanan (user_id, item, harga, informasi, pembayaran, tanggal_pesanan) 
            VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isiss", $user_id, $item, $price, $info, $payment_method);

    // Eksekusi query
    if ($stmt->execute()) {
        // Encode variabel untuk URL yang lebih aman
        $uid_encoded = urlencode($uid);
        $sid_encoded = urlencode($sid);
        $item_encoded = urlencode($item);
        $price_encoded = number_format($price, 0, ',', '.');
        $payment_method_encoded = urlencode($payment_method);

        // Membuat pesan untuk WhatsApp
        $message = "Halo, saya ingin melakukan top up dengan informasi berikut:\n\n" . 
            "- User ID: $uid_encoded\n" . 
            "- Server ID: $sid_encoded\n" . 
            "- Item: $item_encoded\n" . 
            "- Total: Rp $price_encoded\n" . 
            "- Metode Pembayaran: $payment_method_encoded\n\n" . 
            "Terima kasih!";

        // Encode pesan agar aman untuk URL
        $encoded_message = urlencode($message);

        // URL WhatsApp dengan pesan yang sudah di-encode
        $whatsapp_url = "https://wa.me/6285745735072?text=$encoded_message";
        
        // Mengarahkan ke WhatsApp menggunakan JavaScript
        echo "<script>window.location.href = '$whatsapp_url';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
}
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Up Diamond MLBB</title>
    <link rel="stylesheet" href="../css/e-wallet.css">
    <link rel="stylesheet" href="../layout/footer.css">
    <link rel="stylesheet" href="layout/navbar.css">
    <link rel="icon" href="../resources/logo.png">
</head>
<body>
    <?php include "../layout/navbar.php" ?>
    <div class="container">
        <!-- Bagian kiri -->
        <div class="icon-info card">
            <div style="display: flex; align-items: center; gap: 10px;">
                <img src="../images/ml.jpg" alt="MLBB" class="icon-logo">
                <h2>Mobile Legends</h2>
            </div>
            <div class="separator"></div>
            <p>Top Up Diamond MLBB Hanya Dalam Hitungan Detik<br>
                1. Cukup Masukan User ID & Server Anda.<br>
                2. Pilih Nominal Yang Anda inginkan.<br>
                3. Pilih Pembayaran Yang Anda Gunakan Dan Selesaikan Pembayaran.<br>
                4. Dan Item Akan Secara Langsung Ditambahkan Ke Akun Anda.</p>
        </div>

        <!-- Form -->
        <form id="topup-form" method="POST" class="form-section">
            <!-- Input nomor telepon -->
            <div class="card">
                <h3>📱 Masukkan User ID</h3>
                <div class="input-form">
                <input type="text"  name="uid" placeholder="User ID" required>
                <input type="text"  name="sid" placeholder="Server ID" required>
                </div>
            </div>

            <!-- Pilihan item -->
            <div class="card">
                <h3>💎 Pilih Nominal Top Up</h3>
                <div class="item-grid">
                    <?php
                    // Pilihan item
                    $items = [
                        ['value' => '59 DM', 'price' => 5000],
                        ['value' => '199 DM', 'price' => 10000],
                        ['value' => '299 DM', 'price' => 20000],
                        ['value' => '479 DM', 'price' => 30000],
                        ['value' => '500 DM', 'price' => 50000],
                        ['value' => '1000 DM', 'price' => 100000],
                    ];

                    // Loop untuk menampilkan item
                    foreach ($items as $item) {
                        echo '<div class="item-option" onclick="selectItem(this, \'' . $item['value'] . '\', ' . $item['price'] . ')">
                            <div>' . $item['value'] . '</div>
                            <div>Rp ' . number_format($item['price'], 0, ',', '.') . '</div>
                        </div>';
                    }
                    ?>
                </div>
                <!-- Input tersembunyi untuk item yang dipilih -->
                <input type="hidden" name="item" id="selected_item" value="">
                <input type="hidden" name="item_price" id="item_price" value="0">
                <p id="item-error" class="error" style="display: none;">Pilih salah satu item!</p>
            </div>

            <!-- Pilihan metode pembayaran -->
            <div class="card">
                <h3>💳 Pilih Metode Pembayaran</h3>
                <select name="payment_method" required>
                    <option value="QRIS">QRIS</option>
                    <option value="All E-Wallet">All E-Wallet</option>
                    <option value="BCA">BCA</option>
                </select>
                <p>Total Harga: <span id="total-price">Rp 0</span></p>
            </div>

            <!-- Submit -->
            <div class="card">
                <button type="submit">Konfirmasi Top Up →</button>
            </div>
        </form>
    </div>

    <script>
        // Variabel untuk item yang dipilih
        let selectedItem = null; // Variabel untuk item yang dipilih

        // Fungsi untuk memilih item
        function selectItem(element, itemName, price) {
            // Reset tampilan item yang dipilih sebelumnya
            document.querySelectorAll('.item-option').forEach(item => item.classList.remove('selected'));

            // Tandai item yang dipilih
            element.classList.add('selected');
            selectedItem = itemName; // Simpan nama item yang dipilih

            // Perbarui nilai input tersembunyi
            document.getElementById('selected_item').value = itemName; // Isi item yang dipilih
            document.getElementById('item_price').value = price; // Isi harga item

            // Perbarui harga total di UI
            const totalPrice = price + 1000; // Tambahkan biaya tambahan
            document.getElementById('total-price').textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;

            // Sembunyikan pesan error jika ada
            document.getElementById('item-error').style.display = 'none';
        }

        // Validasi sebelum submit
        document.getElementById('topup-form').addEventListener('submit', function (event) {
            if (!selectedItem) {
                // Tampilkan pesan error jika item belum dipilih
                document.getElementById('item-error').style.display = 'block';
                event.preventDefault(); // Batalkan pengiriman form
            }
        });
    </script>
    <?php include "../layout/footer.php" ?>
</body>
</html>
