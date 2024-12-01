<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jasa Edit Convert</title>
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
                <img src="../images/convert.jpg" alt="convert photo" class="icon-logo">
                <h2>Jasa Convert</h2>
            </div>
            <div class="separator"></div>
            <p>Jasa Convert Dengan Fee Yang Affordable.<br>
                1. Pilih Mata Uang Darimana Ke Mana.<br>
                2. Masukkan Nomor Telepon Anda.<br>
                3. Masukkan Nominal Yang Akan Dikonversi.<br>
                4. Pilih Metode Pembayaran Yang Anda Gunakan.<br>
                5. Tekan Konfirmasi Dan Anda Akan Diarahkan Ke WhatsApp Untuk Informasi Lebih Lanjut.<br><br>
                Note: Jika Anda Memilih Kategori Rupiah Ke Ringgit, Masukkan Nominal Dalam Rupiah Begitupun Sebaliknya<br>
            </p>
        </div>

        <!-- Form -->
        <form id="convert-form" method="POST" class="form-section">
            <div class="card">
                <h3>Masukkan No. Telepon</h3>
                <input type="text" name="phone" placeholder="081xxx" required>
            </div>

            <!-- Kategori Convert -->
            <div class="card">
                <h3>Kategori Convert</h3>
                <div class="item-grid">
                    <?php 
                    $kategoriConvert = [
                        ['value' => 'Rupiah ke Ringgit', 'price' => 5000],
                        ['value' => 'Ringgit ke Rupiah', 'price' => 5000],
                    ];
                    foreach ($kategoriConvert as $category) { ?>
                        <div class="item-option" onclick="selectCategory(this, '<?= $category['value'] ?>', <?= $category['price'] ?>)">
                            <div><?= $category['value'] ?></div>
                            <div>Rp <?= number_format($category['price'], 0, ',', '.') ?></div>
                        </div>
                    <?php } ?>
                </div>
                <input type="hidden" name="convert_category" id="convert_category" value="">
                <input type="hidden" name="convert_price" id="convert_price" value="0">
            </div>

            <!-- Nominal -->
            <div class="card">
                <h3>Masukkan Nominal</h3>
                <input type="number" name="amount" id="amount" placeholder="Nominal" required oninput="updateConvertedAmount()">
                <p>Nominal yang Diterima: <span id="received-amount">-</span></p>
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
                <input type="text" name="note" placeholder="Masukkan catatan khusus (opsional)">
            </div>

            <!-- Submit -->
            <div class="card">
                <button type="submit">Konfirmasi Convert →</button>
            </div>
        </form>
    </div>
    <script>
let categoryPrice = 0;
const conversionRate = 3500; // Kurs Ringgit ke Rupiah
let selectedCategory = "";

function selectCategory(element, categoryName, price) {
    resetSelection();
    element.classList.add('selected');
    document.getElementById('convert_category').value = categoryName;
    document.getElementById('convert_price').value = price;
    selectedCategory = categoryName;
    categoryPrice = price;
    updateConvertedAmount();
}

function resetSelection() {
    document.querySelectorAll('.item-option').forEach(item => item.classList.remove('selected'));
}

function updateConvertedAmount() {
    const amount = parseFloat(document.getElementById('amount').value || 0);
    let receivedAmount = 0;
    let receivedCurrency = "";
    let totalPrice = 0;

    if (selectedCategory === "Rupiah ke Ringgit") {
        receivedAmount = amount / conversionRate; // Rupiah ke Ringgit
        receivedCurrency = "RM";
        totalPrice = (receivedAmount * conversionRate) + categoryPrice;
        document.getElementById('total-price').textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;
    } else if (selectedCategory === "Ringgit ke Rupiah") {
        receivedAmount = amount * conversionRate; // Ringgit ke Rupiah
        receivedCurrency = "Rp";
        totalPrice = (receivedAmount) + (categoryPrice / conversionRate);
        document.getElementById('total-price').textContent = `RM ${totalPrice.toLocaleString('id-ID')}`;
    }

    document.getElementById('received-amount').textContent = `${receivedCurrency} ${receivedAmount.toLocaleString('id-ID')}`;
}
    </script>
    <?php include "../layout/footer.php" ?>
</body>
</html>
