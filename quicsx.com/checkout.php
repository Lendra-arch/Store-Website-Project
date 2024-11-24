<?php
session_start();
include "../service/database.php";

// Periksa apakah data diterima
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true); // Ambil data JSON
    $userId = $data['user_id']; // User ID yang login
    $items = $data['items']; // Item yang dipilih
    
    if (!empty($userId) && !empty($items)) {
        // Loop untuk setiap item dan simpan ke database
        foreach ($items as $item) {
            $itemName = $conn->real_escape_string($item['name']); // Nama item
            $quantity = (int)$item['quantity']; // Jumlah item

            // Simpan pesanan ke tabel pesanan
            $sql = "INSERT INTO pesanan (user_id, item, jumlah) 
                    VALUES ('$userId', '$itemName', '$quantity')";
            if ($conn->query($sql) === TRUE) {
                // Pesanan berhasil disimpan
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal menyimpan pesanan: ' . $conn->error]);
                exit();
            }
        }
        echo json_encode(['success' => true, 'message' => 'Pesanan berhasil disimpan']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Data tidak valid']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Metode tidak valid']);
}

$conn->close();
?>
