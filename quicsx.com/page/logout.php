<?php
session_start();
session_unset(); // Menghapus semua data sesi
session_destroy(); // Mengakhiri sesi
header('Location:../index.php'); // Redirect ke halaman home
exit;
?>
