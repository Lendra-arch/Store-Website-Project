<?php
include "service/database.php";
if (!isset($_SESSION['id'])) {
    $_SESSION['id'] = 1; // Anggap user dengan ID 1 yang sedang login
}
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST['phone'];
    $item = $_POST['item'];
    $item = "DANA " . $item;
    $price = $_POST['item_price'] + 1000; // Tambahkan biaya administrasi 1000 rupiah
    $payment_method = $_POST['payment_method']; // Ambil metode pembayaran
    $user_id = 1; // Ganti dengan ID pengguna yang terautentikasi
    $info = "Nomor Telepon: $phone";

    // Query untuk memasukkan data ke dalam tabel pesanan
    $sql = "INSERT INTO pesanan (user_id, item, harga, informasi, pembayaran, tanggal_pesanan) 
            VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isiss", $user_id, $item, $price, $info, $payment_method);

    // Eksekusi query
    if ($stmt->execute()) {
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
<link rel="stylesheet" href="e-wallet.css">
<link rel="stylesheet" href="layout/footer.css">
</head>
<body>
    <?php include "layout/navbar.php" ?>
    <div class="container">
        <!-- Bagian kiri -->
        <div class="icon-info card">
            <div style="display: flex; align-items: center; gap: 10px;">
            <img src="images/dana.jpg" alt="Dana" class="icon-logo">
                <h2>Dana</h2>
            </div>
            <div class="separator"></div>
            <p>Gunakan layanan top-up saldo e-wallet dengan mudah dan cepat.</p>
        </div>

  <!-- Form -->
  <form id="topup-form" method="POST" class="form-section">
            <!-- Input nomor telepon -->
            <div class="card">
                <h3>📱 Masukkan No. Telepon</h3>
                <input type="text" name="phone" placeholder="Masukkan No. Telepon" required>
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
                    ];

                    // Loop untuk menampilkan item
                    foreach ($items as $item) {
                        echo '<div class="item-option" onclick="selectItem(this, ' . $item['price'] . ')">
                            <div>' . $item['value'] . '</div>
                            <div>Rp ' . number_format($item['price'], 0, ',', '.') . '</div>
                            <input type="hidden" name="item" value="' . $item['value'] . '">
                        </div>';
                    }
                    ?>
                </div>
                <input type="hidden" name="item_price" id="item_price" value="0">
                <p id="item-error" class="error" style="display: none;">Pilih salah satu item!</p>
            </div>

            <!-- Pilihan metode pembayaran -->
            <div class="card">
                <h3>💳 Pilih Metode Pembayaran</h3>
                <select name="payment_method" required>
                    <option value="QRIS">QRIS</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                    <option value="Kartu Kredit">Kartu Kredit</option>
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
        let selectedItem = null;

        // Fungsi untuk memilih item
        function selectItem(element, price) {
            // Reset item yang dipilih sebelumnya
            document.querySelectorAll('.item-option').forEach(item => item.classList.remove('selected'));

            // Tandai item yang dipilih
            element.classList.add('selected');
            selectedItem = price; // Simpan harga item yang dipilih

            // Perbarui harga total
            const totalPrice = price + 1000; // Biaya tambahan 1000
            document.getElementById('total-price').textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;
            document.getElementById('item_price').value = price;

            // Sembunyikan pesan error jika ada
            document.getElementById('item-error').style.display = 'none';
        }

        // Validasi sebelum submit
        document.getElementById('topup-form').addEventListener('submit', function(event) {
            if (!selectedItem) {
                // Tampilkan pesan error jika item belum dipilih
                document.getElementById('item-error').style.display = 'block';
                event.preventDefault(); // Batalkan pengiriman form
            }
        });

         // Buat pesan WhatsApp
         const message = `Halo, saya ingin melakukan top up dengan informasi berikut:\n\n- No. Telepon: ${phone}\n- Item: ${item}\n- Total: Rp ${totalPrice.toLocaleString('id-ID')}\n- Metode Pembayaran: ${paymentMethod}\n\nTerima kasih!`;

        // Arahkan ke WhatsApp dengan pesan
        const phoneNumber = "6285745735072"; // Ganti dengan nomor WhatsApp tujuan
        const whatsappURL = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
        window.location.href = whatsappURL;
    </script>
    <?php include "layout/footer.php" ?>

</body>
</html>
