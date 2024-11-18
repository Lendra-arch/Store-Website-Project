<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Up E-Wallet</title>
    <link rel="stylesheet" href="e-wallet.css">
    <link rel="stylesheet" href="layout/footer.css">
</head>
<body>
    <?php include "layout/navbar.php";?>
</html><div class="container">
        <h1 class="page-title">Top Up E-Wallet</h1>
        <p class="page-subtitle">Pilih e-wallet yang ingin kamu isi saldonya</p>

        <div class="wallet-list">
            <!-- Gopay -->
            <div class="wallet-card">
                <button class="wallet-header" onclick="toggleWallet(this)">
                    <div class="wallet-icon">💳</div>
                    <span class="wallet-name">GoPay</span>
                </button>
                <div class="wallet-content">
                    <ul class="price-list">
                        <li class="price-item">
                            <label>
                                <input type="checkbox" class="price-checkbox" data-price="21000" onchange="updateTotal(this)">
                                <span>Rp 20.000</span>
                            </label>
                            <span>Rp 21.000</span>
                        </li>
                        <li class="price-item">
                            <label>
                                <input type="checkbox" class="price-checkbox" data-price="51500" onchange="updateTotal(this)">
                                <span>Rp 50.000</span>
                            </label>
                            <span>Rp 51.500</span>
                        </li>
                        <li class="price-item">
                            <label>
                                <input type="checkbox" class="price-checkbox" data-price="102000" onchange="updateTotal(this)">
                                <span>Rp 100.000</span>
                            </label>
                            <span>Rp 102.000</span>
                        </li>
                    </ul>
                    <div class="total-price">Total: Rp 0</div>
                    <button class="checkout-btn" disabled>Checkout</button>
                </div>
            </div>

            <!-- OVO -->
            <div class="wallet-card">
                <button class="wallet-header" onclick="toggleWallet(this)">
                    <div class="wallet-icon">💳</div>
                    <span class="wallet-name">OVO</span>
                </button>
                <div class="wallet-content">
                    <ul class="price-list">
                        <li class="price-item">
                            <label>
                                <input type="checkbox" class="price-checkbox" data-price="26000" onchange="updateTotal(this)">
                                <span>Rp 25.000</span>
                            </label>
                            <span>Rp 26.000</span>
                        </li>
                        <li class="price-item">
                            <label>
                                <input type="checkbox" class="price-checkbox" data-price="51500" onchange="updateTotal(this)">
                                <span>Rp 50.000</span>
                            </label>
                            <span>Rp 51.500</span>
                        </li>
                        <li class="price-item">
                            <label>
                                <input type="checkbox" class="price-checkbox" data-price="102000" onchange="updateTotal(this)">
                                <span>Rp 100.000</span>
                            </label>
                            <span>Rp 102.000</span>
                        </li>
                    </ul>
                    <div class="total-price">Total: Rp 0</div>
                    <button class="checkout-btn" disabled>Checkout</button>
                </div>
            </div>

            <!-- Dana -->
            <div class="wallet-card">
                <button class="wallet-header" onclick="toggleWallet(this)">
                    <div class="wallet-icon">💳</div>
                    <span class="wallet-name">DANA</span>
                </button>
                <div class="wallet-content">
                    <ul class="price-list">
                        <li class="price-item">
                            <label>
                                <input type="checkbox" class="price-checkbox" data-price="21000" onchange="updateTotal(this)">
                                <span>Rp 20.000</span>
                            </label>
                            <span>Rp 21.000</span>
                        </li>
                        <li class="price-item">
                            <label>
                                <input type="checkbox" class="price-checkbox" data-price="51500" onchange="updateTotal(this)">
                                <span>Rp 50.000</span>
                            </label>
                            <span>Rp 51.500</span>
                        </li>
                        <li class="price-item">
                            <label>
                                <input type="checkbox" class="price-checkbox" data-price="102000" onchange="updateTotal(this)">
                                <span>Rp 100.000</span>
                            </label>
                            <span>Rp 102.000</span>
                        </li>
                    </ul>
                    <div class="total-price">Total: Rp 0</div>
                    <button class="checkout-btn" disabled>Checkout</button>
                </div>
            </div>

            <!-- ShopeePay -->
            <div class="wallet-card">
                <button class="wallet-header" onclick="toggleWallet(this)">
                    <div class="wallet-icon">💳</div>
                    <span class="wallet-name">ShopeePay</span>
                </button>
                <div class="wallet-content">
                    <ul class="price-list">
                        <li class="price-item">
                            <label>
                                <input type="checkbox" class="price-checkbox" data-price="21000" onchange="updateTotal(this)">
                                <span>Rp 20.000</span>
                            </label>
                            <span>Rp 21.000</span>
                        </li>
                        <li class="price-item">
                            <label>
                                <input type="checkbox" class="price-checkbox" data-price="51500" onchange="updateTotal(this)">
                                <span>Rp 50.000</span>
                            </label>
                            <span>Rp 51.500</span>
                        </li>
                        <li class="price-item">
                            <label>
                                <input type="checkbox" class="price-checkbox" data-price="102000" onchange="updateTotal(this)">
                                <span>Rp 100.000</span>
                            </label>
                            <span>Rp 102.000</span>
                        </li>
                    </ul>
                    <div class="total-price">Total: Rp 0</div>
                    <button class="checkout-btn" disabled>Checkout</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleWallet(button) {
            const content = button.nextElementSibling;
            const allContents = document.querySelectorAll('.wallet-content');
            
            allContents.forEach(item => {
                if (item !== content && item.classList.contains('active')) {
                    item.classList.remove('active');
                }
            });
            
            content.classList.toggle('active');
        }

        function updateTotal(checkbox) {
            const walletContent = checkbox.closest('.wallet-content');
            const checkboxes = walletContent.querySelectorAll('.price-checkbox:checked');
            const totalElement = walletContent.querySelector('.total-price');
            const checkoutBtn = walletContent.querySelector('.checkout-btn');
            
            let total = 0;
            checkboxes.forEach(cb => {
                total += parseInt(cb.dataset.price);
            });
            
            totalElement.textContent = `Total: Rp ${total.toLocaleString('id-ID')}`;
            checkoutBtn.disabled = total === 0;
        }
    </script>
    <?php include "layout/footer.php";?>
</body>