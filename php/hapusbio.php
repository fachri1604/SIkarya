<?php
// Mendapatkan NIM dari URL
if (isset($_GET['nim_mhs'])) {
    $nim = $_GET['nim_mhs'];

    // URL endpoint API untuk menghapus data berdasarkan NIM
    $url = "https://raishaapi1.v-project.my.id/api/biodata/$nim";

    // Inisialisasi cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); // Menggunakan metode DELETE
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Menjalankan permintaan DELETE ke API
    $response = curl_exec($ch);

    // Memeriksa jika ada kesalahan pada cURL
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        // Mengubah respons JSON dari API ke array PHP
        $result = json_decode($response, true);

        // Memeriksa apakah penghapusan berhasil
        if (isset($result['success']) && $result['success']) {
            echo "Data berhasil dihapus";
            header('Location: ../admin/biodata.php'); // Redirect ke halaman admin setelah penghapusan
            exit();
        } else {
            echo "Gagal menghapus data. Pesan: " . htmlspecialchars($result['message']);
        }
    }

    // Menutup cURL
    curl_close($ch);
} else {
    echo "NIM tidak ditemukan.";
}
