<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $url = "https://raishaapi1.v-project.my.id/api/biodata/create-biodata";

    // Validasi file upload
    if (!isset($_FILES["foto"]) || $_FILES["foto"]["error"] != 0) {
        die("Error: File foto wajib diupload!");
    }

    // Validasi tipe file
    $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
    $filename = $_FILES["foto"]["name"];
    $filetype = $_FILES["foto"]["type"];
    $filesize = $_FILES["foto"]["size"];

    // Verifikasi ekstensi file
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    if (!array_key_exists($ext, $allowed)) {
        die("Error: Format file tidak valid! Hanya JPG, JPEG, PNG, dan GIF yang diperbolehkan.");
    }

    // Verifikasi ukuran file - maksimal 2MB
    $maxsize = 2 * 1024 * 1024;
    if ($filesize > $maxsize) {
        die("Error: Ukuran file terlalu besar! Maksimal 2MB.");
    }

    // Verifikasi tipe MIME
    if (!in_array($filetype, $allowed)) {
        die("Error: Tipe file tidak valid!");
    }

    // Siapkan data untuk dikirim
    $fields = array(
        'nim_mhs' => $_POST['nim_mhs'],
        'nama_mhs' => $_POST['nama_mhs'],
        'prodi' => $_POST['prodi'],
        'jurusan' => $_POST['jurusan'],
        'email' => $_POST['email'],
        'no_hp' => $_POST['no_hp']
    );

    // Tambahkan file foto ke data yang akan dikirim
    $fields['foto'] = new CURLFile(
        $_FILES["foto"]["tmp_name"],
        $_FILES["foto"]["type"],
        $_FILES["foto"]["name"]
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
        echo "Biodata baru ditambahkan.\n";
        echo "<script>alert('$action_message'); window.location.href='../admin/biodata.php';</script>";
    } else {
        // Redirect ke halaman error
        echo "Error : " . json_encode($responseData) . "\n";
    }
}
