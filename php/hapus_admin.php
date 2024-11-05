<?php
// Mendapatkan username dari URL
if (isset($_GET['username'])) {
    $username = $_GET['username'];

    // URL endpoint API untuk menghapus data berdasarkan username
    $url = "http://127.0.0.1:8000/api/users/$username";

    // Inisialisasi cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); // Menggunakan metode DELETE
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Menjalankan permintaan DELETE ke API
    $response = curl_exec($ch);

    // Mendapatkan kode status HTTP
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Memeriksa jika ada kesalahan pada cURL
    if (curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);
    } else {
        // Tampilkan respons mentah dari API dan kode status HTTP
        echo "HTTP Status Code: $httpCode<br>";
        echo "Raw API Response: " . htmlspecialchars($response) . "<br>";

        // Coba decode respons JSON
        $result = json_decode($response, true);

        // Periksa jika respons JSON valid
        if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
            echo "Error parsing JSON response: " . json_last_error_msg();
        } else {
            // Memeriksa apakah penghapusan berhasil
            if (isset($result['success']) && $result['success']) {
                echo "Data berhasil dihapus";
                header('Location: ../admin/admin.php'); // Redirect ke halaman admin setelah penghapusan
                exit();
            } else {
                // Memeriksa apakah ada pesan kesalahan dalam respons
                $errorMessage = isset($result['message']) ? $result['message'] : "Tidak ada pesan kesalahan yang diberikan.";
                echo "Gagal menghapus data. Pesan: " . htmlspecialchars($errorMessage);
            }
        }
    }

    // Menutup cURL
    curl_close($ch);
} else {
    echo "Username tidak ditemukan.";
}
