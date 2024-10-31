<?php
// Koneksi ke database
include '../php/koneksi.php';

$id_karya = $_GET['id_karya']; // Mendapatkan ID karya dari URL

// Query untuk mendapatkan detail karya, termasuk nama karya, deskripsi, nama mahasiswa, gambar, dan foto mahasiswa
$stmt = $conn->prepare("
    SELECT 
        karya.nama_karya, 
        karya.desc_karya, 
        karya.gambar_karya,
        karya.tahun_rilis,
        biodata_mhs.nama_mhs,
        biodata_mhs.foto,
        biodata_mhs.prodi,
        biodata_mhs.jurusan,
        biodata_mhs.email
    FROM 
        karya 
    JOIN 
        biodata_mhs ON karya.nim_mhs = biodata_mhs.nim_mhs 
    WHERE 
        karya.id_karya = ?
");
$stmt->bind_param("i", $id_karya);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    $data['gambar_karya'] = explode(',', $data['gambar_karya']); // Mengambil daftar gambar
} else {
    echo json_encode(["error" => "Karya tidak ditemukan."]);
    exit;
}

$stmt->close();
$conn->close();

// Mengirim data ke format JSON
header('Content-Type: application/json');
echo json_encode($data);
