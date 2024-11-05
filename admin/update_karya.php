<?php
// Ambil data dari form
$id_karya = $_POST['id_karya'];
$nama_karya = $_POST['nama_karya'];
$nim_mhs = $_POST['nim_mhs'];
$desc_karya = $_POST['desc_karya'];
$tahun_rilis = $_POST['tahun_rilis'];
$id_kategori = $_POST['id_kategori'];

// Endpoint API untuk mengupdate karya
$api_url = "https://raishaapi1.v-project.my.id/api/karya/$id_karya"; // Ganti dengan URL API Anda

// Data yang akan dikirim ke API
$data = [
    'nama_karya' => $nama_karya,
    'nim_mhs' => $nim_mhs,
    'desc_karya' => $desc_karya,
    'tahun_rilis' => $tahun_rilis,
    'id_kategori' => $id_kategori,
    // 'gambar_karya' => $gambar_karya, // Jika ada gambar yang diupload
];

// Inisialisasi cURL
$ch = curl_init($api_url);

// Set opsi cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); // Menggunakan POST untuk permintaan
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Mengirim data dalam format JSON
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json'
]);

// Eksekusi cURL
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Tutup cURL
curl_close($ch);

// Cek respon dari API
if ($http_code === 200) {
    // Berhasil
    header("Location: ../admin/admin_page.php?status=success&message=Data berhasil diupdate");
} else {
    // Gagal
    $error_message = json_decode($response, true);
    header("Location: ../admin/admin_page.php?status=error&message=" . urlencode("Gagal mengupdate data: " . ($error_message['message'] ?? 'Tidak ada pesan')));
}

exit();
