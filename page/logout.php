<?php
session_start();
// Ambil URL terakhir dari sesi, jika ada
$redirect_url = isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : '/index.php'; // Default ke halaman utama jika tidak ada
session_unset(); // Menghapus semua data sesi
session_destroy(); // Mengakhiri sesi
header("Location: $redirect_url");
exit;
?>
