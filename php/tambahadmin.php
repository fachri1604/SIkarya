<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $url = "https://raishaapi1.v-project.my.id/api/users";

    // Siapkan data untuk dikirim
    $fields = array(
        'username' => $_POST['username'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
    );

 

    // Inisialisasi cURL
    $ch = curl_init();

    // Set opsi cURL
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array('Content-Type: multipart/form-data'),
        CURLOPT_POSTFIELDS => $fields,
        CURLOPT_SSL_VERIFYPEER => false, // Tambahkan ini jika ada masalah SSL
        CURLOPT_SSL_VERIFYHOST => false  // Tambahkan ini jika ada masalah SSL
    ));

    // Eksekusi request
    $response = curl_exec($ch);

    // Cek error cURL
    if (curl_errno($ch)) {
        die('Error cURL: ' . curl_error($ch));
    }

    // Tutup session cURL
    curl_close($ch);

    // Decode response JSON
    $responseData = json_decode($response, true);

    // Handle response
    if (isset($responseData['success']) && $responseData['success']) {
        // Redirect ke halaman sukses
        echo "User Admin baru ditambahkan.\n";
        echo "<script>alert('$action_message'); window.location.href='../admin/admin.php';</script>";
    } else {
        // Redirect ke halaman error
        echo "Error : " . json_encode($responseData) . "\n";
    }
}
