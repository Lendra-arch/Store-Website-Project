<?php
session_start();
include "../service/database.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Cek apakah user sudah login
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // Ambil user_id dari session
} else {
    // Jika user belum login, simpan data sementara dan redirect ke login
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $_SESSION['temp_data'] = $_POST; // Simpan data form sementara
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI']; // Simpan URL saat ini
        $_SESSION['pesan'] = 'Login dahulu sebelum melanjutkan.';
        header("Location: ../page/login.php"); // Redirect ke halaman login
        exit;
    }
}

// Ambil data sementara jika ada
$temp_data = isset($_SESSION['temp_data']) ? $_SESSION['temp_data'] : [];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($user_id)) {
    $phone = $_POST['phone'];
    $item = $_POST['item'];
    $item = "DANA " . $item;
    $price = $_POST['item_price'] + 1000; // Tambahkan biaya administrasi 1000 rupiah
    $payment_method = $_POST['payment_method'];
    $info = "Nomor Telepon: $phone";

    // Query untuk memasukkan data ke dalam tabel pesanan
    $sql = "INSERT INTO pesanan (user_id, item, harga, informasi, pembayaran, tanggal_pesanan) 
            VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isiss", $user_id, $item, $price, $info, $payment_method);

    // Eksekusi query
    if ($stmt->execute()) {
        // Hapus data sementara setelah sukses
        unset($_SESSION['temp_data']);

        // Encode variabel untuk URL yang lebih aman
        $phone_encoded = urlencode($phone);
        $item_encoded = urlencode($item);
        $price_encoded = number_format($price, 0, ',', '.');
        $payment_method_encoded = urlencode($payment_method);

        // Membuat pesan untuk WhatsApp
        $message = "Halo, saya ingin melakukan top up dengan informasi berikut:\n\n" . 
            "- No. Telepon: $phone_encoded\n" . 
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
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dana Top Up</title>
    <link rel="stylesheet" href="../css/e-wallet.css">
    <link rel="stylesheet" href="../layout/navbar.css">
    <link rel="stylesheet" href="../layout/footer.css">
    <link rel="icon" href="../resources/logo.png">
</head>
<body>
    <?php include "../layout/navbar.php" ?>
    <div class="container">
        <!-- Bagian kiri -->
        <div class="icon-info card">
            <div style="display: flex; align-items: center; gap: 10px;">
                <img src="../images/dana.jpg" alt="Dana" class="icon-logo">
                <h2>Dana</h2>
            </div>
            <div class="separator"></div>
            <p>Top Up Saldo Hanya Dalam Hitungan Detik<br>
                1. Cukup Masukan Nomor Telepon Anda.<br>
                2. Pilih Nominal Yang Anda inginkan.<br>
                3. Pilih Pembayaran Yang Anda Gunakan.<br>
                4. Anda Akan Diarahkan Ke Whatsapp Admin.<br>5. Selesaikan Pembayaran.<br>6. Dan Transaksi Akan Langsung Diproses</p>
        </div>

       <!-- Form -->
<form id="topup-form" method="POST" class="form-section">
    <!-- Input nomor telepon -->
    <div class="card">
        <h3>📱 Masukkan No. Telepon</h3>
        <input type="number" name="phone" placeholder="Masukkan No. Telepon" 
               value="<?= isset($temp_data['phone']) ? htmlspecialchars($temp_data['phone']) : '' ?>" required>
    </div>

    <!-- Pilihan item -->
    <div class="card">
        <h3>💎 Pilih Item</h3>
        <div class="item-grid">
            <?php
            // Pilihan item
            $items = [
                ['value' => '5rb', 'price' => 5000],
                ['value' => '10rb', 'price' => 10000],
                ['value' => '20rb', 'price' => 20000],
                ['value' => '30rb', 'price' => 30000],
                ['value' => '50rb', 'price' => 50000],
                ['value' => '100rb', 'price' => 100000],
                ['value' => '700rb', 'price' => 720000],
            ];

            // Loop untuk menampilkan item
            foreach ($items as $item) {
                $isSelected = isset($temp_data['item']) && $temp_data['item'] === $item['value'];
                echo '<div class="item-option ' . ($isSelected ? 'selected' : '') . '" 
                          onclick="selectItem(this, \'' . $item['value'] . '\', ' . $item['price'] . ')">
                          <div>' . $item['value'] . '</div>
                          <div>Rp ' . number_format($item['price'], 0, ',', '.') . '</div>
                      </div>';
            }
            ?>
        </div>
        <input type="hidden" name="item" id="selected_item" value="<?= $temp_data['item'] ?? '' ?>">
        <input type="hidden" name="item_price" id="item_price" value="<?= $temp_data['item_price'] ?? 0 ?>">
        <p id="item-error" class="error" style="display: none;">Pilih salah satu item!</p>
    </div>

    <!-- Pilihan metode pembayaran -->
    <div class="card">
        <h3>💳 Pilih Metode Pembayaran</h3>
        <select name="payment_method" required>
            <option value="QRIS" <?= isset($temp_data['payment_method']) && $temp_data['payment_method'] === 'QRIS' ? 'selected' : '' ?>>QRIS</option>
            <option value="All E-Wallet" <?= isset($temp_data['payment_method']) && $temp_data['payment_method'] === 'All E-Wallet' ? 'selected' : '' ?>>All E-Wallet</option>
            <option value="BCA" <?= isset($temp_data['payment_method']) && $temp_data['payment_method'] === 'BCA' ? 'selected' : '' ?>>BCA</option>
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
