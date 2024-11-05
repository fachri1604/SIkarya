<?php
// Pastikan file ini hanya dapat diakses melalui POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $username = $_GET['username'] ?? $_POST['username'] ?? null;
    $email = $_POST['email'];
    $password = $_POST['password'];

    // URL endpoint API untuk mengupdate data berdasarkan username
    $url = "http://127.0.0.1:8000/api/users/$username";

    // Data yang akan dikirimkan ke API dalam format JSON
    $data = json_encode([
        'email' => $email,
        'password' => $password,
    ]);

    // Inisialisasi cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // Gunakan metode PUT
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data),
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    // Jalankan permintaan PUT ke API
    $response = curl_exec($ch);

    // Periksa jika ada kesalahan pada cURL
    if (curl_errno($ch)) {
        header("Location: put_admin.php?status=error&message=" . urlencode('Request failed: ' . curl_error($ch)));
        exit();
    }

    // Mendapatkan kode status HTTP
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Menutup cURL
    curl_close($ch);

    // Menangani respons dari API
    $result = json_decode($response, true);
    if ($httpCode === 200 && isset($result['success']) && $result['success']) {
        // Jika berhasil, arahkan kembali ke halaman admin dengan status sukses
        header("Location: admin.php?status=success&message=" . urlencode("Data berhasil diperbarui."));
    } else {
        // Jika gagal, tampilkan pesan error
        $errorMessage = isset($result['message']) ? $result['message'] : "Gagal memperbarui data.";
        header("Location: admin.php?status=error&message=" . urlencode($errorMessage));
    }
    exit();
} else {
    // Jika tidak melalui POST, kembali ke halaman admin
    header("Location: admin.php");
    exit();
}
