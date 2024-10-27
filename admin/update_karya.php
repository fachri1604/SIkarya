<?php
include '../php/koneksi.php';

// Ambil data dari form
$id_karya = $_POST['id_karya'];
$nama_karya = $_POST['nama_karya'];
$nim_mhs = $_POST['nim_mhs'];
$desc_karya = $_POST['desc_karya'];
$tahun_rilis = $_POST['tahun_rilis'];
$id_kategori = $_POST['id_kategori'];

// Update data karya di database
$query = "UPDATE karya SET nama_karya='$nama_karya', nim_mhs='$nim_mhs', desc_karya='$desc_karya', tahun_rilis='$tahun_rilis', id_kategori='$id_kategori' WHERE id_karya='$id_karya'";

if ($conn->query($query) === TRUE) {
    header("Location: ../admin/admin_page.php?status=success&message=Data berhasil diupdate");
    exit(); // Pastikan untuk menghentikan eksekusi skrip setelah header
} else {
    header("Location: ../admin/admin_page.php?status=error&message=" . urlencode("Gagal mengupdate data: " . $conn->error));
    exit();
}



$conn->close();
?>

