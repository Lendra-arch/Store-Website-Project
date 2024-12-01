<?php
session_start();
include "../service/database.php";

// Jika User sudah login, ambil user id nya
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['pesan'] = 'Login dulu sebelum melanjutkan';
        header("Location: ../page/login.php");
        exit;
    } else {
        $phone = $_POST['phone'];
        $basic_category = $_POST['basic_category'];
        $advanced_category = $_POST['advanced_category'];
        $category_price = $_POST['basic_price'] + $_POST['advanced_price']; // Harga total kategori
        $time_category = $_POST['time_category'];
        $time_price = $_POST['time_price'];
        $output_format = $_POST['output_format'];
        $format_price = $_POST['format_price'];
        $note = isset($_POST['note']) && trim($_POST['note']) !== "" ? $_POST['note'] : "Tidak Ada.";
        $payment_method = $_POST['payment_method'];

        // Gabungkan kategori dan waktu pengerjaan
        $item = trim("$basic_category, $advanced_category", ", ");
        $info = "Nomor Telepon: $phone\nWaktu Pengerjaan: $time_category\nFormat Keluaran: $output_format\nCatatan: $note";

        // Hitung total harga
        $price = $category_price + $time_price + $format_price + 1000;

        // Query untuk memasukkan data ke dalam tabel pesanan
        $sql = "INSERT INTO pesanan (user_id, item, harga, informasi, pembayaran, tanggal_pesanan) 
                VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isiss", $user_id, $item, $price, $info, $payment_method);

        if ($stmt->execute()) {
            $message = "Halo, saya ingin melakukan editing video:\n\n" .
                "- No. Telepon: $phone\n" .
                "- Kategori: $item\n" .
                "- Format: $output_format\n" .
                "- Total: Rp " . number_format($price, 0, ',', '.') . "\n" .
                "- Metode Pembayaran: $payment_method\n" .
                "- Catatan: $note\n\nTerima kasih!";
            $encoded_message = urlencode($message);
            $whatsapp_url = "https://wa.me/6285745735072?text=$encoded_message";
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
    <title>Jasa Edit Video</title>
    <link rel="stylesheet" href="../css/e-wallet.css">
    <link rel="stylesheet" href="../layout/navbar.css">
    <link rel="stylesheet" href="../layout/footer.css">
    <link rel="icon" href="../resources/logo.png">
</head>
<body>
    <?php include "../layout/navbar.php" ?>
    <div class="container">
        <!-- Informasi -->
        <div class="icon-info card">
            <div style="display: flex; align-items: center; gap: 10px;">
                <img src="../images/edit-video.jpg" alt="edit photo" class="icon-logo">
                <h2>Jasa Edit Video</h2>
            </div>
            <div class="separator"></div>
            <p>Pesan Jasa Edit Video Dengan Harga Affordable.<br>
                1. Pilih Kategori Editing video Yang Anda Inginkan.<br>
                2. Masukkan Nomor Telepon Anda Agar Bisa Dihubungi Saat Proses Selesai.<br>
                3. Pilih Metode Pembayaran Yang Anda Gunakan.<br>
                4. Tekan Konfirmasi Dan Anda Akan Diarahkan Ke Whatsapp Untuk Informasi Lebih Lanjut.<br>
                5. Anda Akan Mendapatkan Video Yang Sudah Diedit Dengan Kualitas Terbaik.<br>
                6. Resolusi default adalah 1080p</p>
        </div>

        <!-- Form -->
        <form id="edit-photo-form" method="POST" class="form-section">
            <div class="card">
                <h3>Masukkan No. Telepon</h3>
                <input type="text" name="phone" placeholder="081xxx" required>
            </div>

            <!-- Kategori Basic -->
            <div class="card basic">
                <h3>Kategori Basic</h3>
                <div class="item-grid">
                    <?php 
                    $kategoriBasic = [
                        ['value' => 'Pemotongan, Penggabungan Klip', 'price' => 5000],
                        ['value' => 'Add Text/Title', 'price' => 10000],
                        ['value' => 'Add Background Music', 'price' => 20000],
                        ['value' => 'Efek Transisi', 'price' => 20000],
                    ];
                    foreach ($kategoriBasic as $category) { ?>
                        <div class="item-option" onclick="selectBasic(this, '<?= $category['value'] ?>', <?= $category['price'] ?>)">
                            <div><?= $category['value'] ?></div>
                            <div>Rp <?= number_format($category['price'], 0, ',', '.') ?></div>
                        </div>
                    <?php } ?>
                </div>
                <input type="hidden" name="basic_category" id="basic_category" value="">
                <input type="hidden" name="basic_price" id="basic_price" value="0">
            </div>

            <!-- Kategori Advanced -->
            <div class="card advanced">
                <h3>Kategori Advanced</h3>
                <div class="item-grid">
                    <?php 
                    $kategoriAdvanced = [
                        ['value' => 'Green Screen/Chroma Key', 'price' => 15000],
                        ['value' => 'Color Grading', 'price' => 30000],
                        ['value' => 'Subtitle/Terjemahan', 'price' => 50000],
                    ];
                    foreach ($kategoriAdvanced as $category) { ?>
                        <div class="item-option" onclick="selectAdvanced(this, '<?= $category['value'] ?>', <?= $category['price'] ?>)">
                            <div><?= $category['value'] ?></div>
                            <div>Rp <?= number_format($category['price'], 0, ',', '.') ?></div>
                        </div>
                    <?php } ?>
                </div>
                <input type="hidden" name="advanced_category" id="advanced_category" value="">
                <input type="hidden" name="advanced_price" id="advanced_price" value="0">
            </div>

            <!-- Waktu Pengerjaan -->
            <div class="card time">
                <h3>Pilih Waktu Pengerjaan</h3>
                <div class="item-grid">
                    <?php 
                    $kategoriWaktu = [
                        ['value' => 'Express<br>(1-2 hari)', 'price' => 20000],
                        ['value' => 'Reguler<br>(3-5 hari)', 'price' => 10000],
                        ['value' => 'Hemat<br>(6-7 hari)', 'price' => 5000],
                    ];
                    foreach ($kategoriWaktu as $category) { ?>
                        <div class="item-option" onclick="selectTime(this, '<?= $category['value'] ?>', <?= $category['price'] ?>)">
                            <div><?= $category['value'] ?></div>
                            <div>Rp <?= number_format($category['price'], 0, ',', '.') ?></div>
                        </div>
                    <?php } ?>
                </div>
                <input type="hidden" name="time_category" id="time_category" value="">
                <input type="hidden" name="time_price" id="time_price" value="0">
            </div>
            <!-- Format Keluaran -->
            <div class="card">
                <h3>Format Keluaran</h3>
                <div class="item-grid">
                    <?php 
                    $outputFormats = [
                        ['value' => 'MOV', 'price' => 0],
                        ['value' => 'MP4', 'price' => 0],
                        ['value' => 'MKV', 'price' => 5000], // Misalnya, PDF ada biaya tambahan
                    ];
                    foreach ($outputFormats as $format) { ?>
                        <div class="item-option" onclick="selectFormat(this, '<?= $format['value'] ?>', <?= $format['price'] ?>)">
                            <div><?= $format['value'] ?></div>
                            <div>Rp <?= number_format($format['price'], 0, ',', '.') ?></div>
                        </div>
                    <?php } ?>
                </div>
                <input type="hidden" name="output_format" id="output_format" value="">
                <input type="hidden" name="format_price" id="format_price" value="0">
            </div>
            <!-- Metode Pembayaran -->
            <div class="card">
                <h3>💳 Pilih Metode Pembayaran</h3>
                <select name="payment_method" required>
                    <option value="QRIS">QRIS</option>
                    <option value="All E-Wallet">All E-Wallet</option>
                    <option value="BCA">BCA</option>
                </select>
                <p>Total Harga: <span id="total-price">Rp 0</span></p>
            </div>

            <!-- Catatan -->
            <div class="card">
                <h3>Catatan Opsional</h3>
                <input type="text"name="note" placeholder="Masukkan catatan khusus untuk edit video (opsional)"></input>
            </div>

            <!-- Submit -->
            <div class="card">
                <button type="submit">Konfirmasi Edit video →</button>
            </div>
        </form>
    </div>
    <script>
let basicPrice = 0, advancedPrice = 0, timePrice = 0, formatPrice = 0;

function selectBasic(element, categoryName, price) {
    resetAdvanced();
    resetSelection('basic');
    element.classList.add('selected');
    document.getElementById('basic_category').value = categoryName;
    document.getElementById('basic_price').value = price;
    basicPrice = price;
    updateTotalPrice();
}

function selectAdvanced(element, categoryName, price) {
    resetBasic();
    resetSelection('advanced');
    element.classList.add('selected');
    document.getElementById('advanced_category').value = categoryName;
    document.getElementById('advanced_price').value = price;
    advancedPrice = price;
    updateTotalPrice();
}

function selectTime(element, timeName, price) {
    resetSelection('time');
    element.classList.add('selected');
    document.getElementById('time_category').value = timeName;
    document.getElementById('time_price').value = price;
    timePrice = price;
    updateTotalPrice();
}

function selectFormat(element, formatName, price) {
    resetSelection('format');
    element.classList.add('selected');
    document.getElementById('output_format').value = formatName;
    document.getElementById('format_price').value = price;
    formatPrice = price;
    updateTotalPrice();
}

function updateTotalPrice() {
    const totalPrice = basicPrice + advancedPrice + timePrice + formatPrice + 1000; // Biaya tambahan
    document.getElementById('total-price').textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;
}

function resetSelection(type) {
    document.querySelectorAll(`.${type} .item-option`).forEach(item => item.classList.remove('selected'));
}

function resetBasic() {
    document.getElementById('basic_category').value = "";
    document.getElementById('basic_price').value = 0;
    basicPrice = 0;
    resetSelection('basic');
}

function resetAdvanced() {
    document.getElementById('advanced_category').value = "";
    document.getElementById('advanced_price').value = 0;
    advancedPrice = 0;
    resetSelection('advanced');
}

function updateTotalPrice() {
    const totalPrice = basicPrice + advancedPrice + timePrice + 1000;
    document.getElementById('total-price').textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;
}
    </script>
    <?php include "../layout/footer.php" ?>
</body>
</html>
