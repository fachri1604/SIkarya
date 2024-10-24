<?php
// ambil_data.php
include 'koneksi.php'; // Menggunakan file koneksi

$sql = "SELECT * FROM karya"; // Anggap 'karya' adalah nama tabel
$result = $conn->query($sql);

// Memeriksa apakah ada hasil
$karya = [];
if ($result->num_rows > 0) {
    // Menyimpan hasil ke dalam array
    while ($row = $result->fetch_assoc()) {
        $karya[] = $row; // Menambahkan setiap baris ke dalam array
    }
}
$conn->close(); // Menutup koneksi
