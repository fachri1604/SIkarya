<?php
// Ambil data dari form
$nim_mhs = $_POST['nim_mhs'];
$nama_mhs = $_POST['nama_mhs'];
$prodi = $_POST['prodi'];
$jurusan = $_POST['jurusan'];
$email = $_POST['email'];
$no_hp = $_POST['no_hp'];
$foto = $_FILES['foto'] ?? null;

// Endpoint API untuk mengupdate biodata
$api_url = "https://raishaapi1.v-project.my.id/api/biodata/$nim_mhs"; // Ganti dengan URL API Anda

// Data yang akan dikirim ke API
$data = [
    'nim_mhs' => $nim_mhs,
    'nama_mhs' => $nama_mhs,
    'prodi' => $prodi,
    'jurusan' => $jurusan,
    'email' => $email,
    'no_hp' => $no_hp,
];

// Jika ada gambar yang diupload, tambahkan ke data
if ($foto && $foto['error'] === UPLOAD_ERR_OK) {
    $data['foto'] = new CURLFile($foto['tmp_name'], $foto['type'], $foto['name']);
}

// Inisialisasi cURL
$ch = curl_init($api_url);

// Set opsi cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); // Menggunakan POST untuk permintaan
curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // Mengirim data
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: multipart/form-data', // Menggunakan multipart untuk file upload
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
    header("Location: ../admin/Biodata.php?status=success&message=Data berhasil diupdate");
} else {
    // Gagal
    $error_message = json_decode($response, true);
    header("Location: ../admin/Biodata.php?status=error&message=" . urlencode("Gagal mengupdate data: " . ($error_message['message'] ?? 'Tidak ada pesan')));
}

exit();
