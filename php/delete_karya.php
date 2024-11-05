<?php
// Memastikan file ini dipanggil dengan permintaan POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mendapatkan id_karya dari POST
    if (isset($_POST['id_karya'])) {
        $id_karya = $_POST['id_karya']; // Menggunakan nama variabel yang sesuai

        // URL endpoint API untuk menghapus data berdasarkan id_karya
        $url = "https://raishaapi1.v-project.my.id/api/karya/$id_karya"; // Tambahkan id_karya ke URL

        // Inisialisasi cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); // Menggunakan metode DELETE
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Menjalankan permintaan DELETE ke API
        $response = curl_exec($ch);

        // Memeriksa jika ada kesalahan pada cURL
        if (curl_errno($ch)) {
            die('Error:' . curl_error($ch));
        }

        // Mengubah respons JSON dari API ke array PHP
        $result = json_decode($response, true);

        // Menutup cURL
        curl_close($ch);

        // Memeriksa apakah penghapusan berhasil
        if (isset($result['success']) && $result['success']) {
            // Redirect ke admin_page.php dengan pesan sukses
            header('Location: ../admin/admin_page.php?status=success&message=' . urlencode('Data berhasil dihapus.'));
            exit();
        } else {
            // Redirect dengan pesan error jika penghapusan gagal
            header('Location: ../admin/admin_page.php?status=error&message=' . urlencode($result['message']));
            exit();
        }
    } else {
        // Redirect jika id_karya tidak ditemukan
        header('Location: ../admin/admin_page.php?status=error&message=' . urlencode('ID tidak ditemukan.'));
        exit();
    }
} else {
    // Redirect jika bukan permintaan POST
    header('Location: ../admin/admin_page.php?status=error&message=' . urlencode('Metode tidak valid.'));
    exit();
}
