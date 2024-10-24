<?php
// Include file koneksi ke database
include '../php/koneksi.php';

// Mendapatkan NIM dari URL
if (isset($_GET['nim_mhs'])) {
    $nim = $_GET['nim_mhs'];

    // Query untuk menghapus data mahasiswa berdasarkan NIM
    $sql = "DELETE FROM biodata_mhs WHERE nim_mhs='$nim'";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil dihapus";
        header('Location: ../admin/biodata.php'); // Redirect ke halaman admin setelah penghapusan
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "NIM tidak ditemukan.";
}

// Menutup koneksi
$conn->close();
?>
