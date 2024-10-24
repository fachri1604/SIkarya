<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form karya
    $nama_karya = $_POST['nama_karya'];
    $nim_mhs = $_POST['nim_mhs']; // NIM diambil dari form karya
    $desc_karya = $_POST['desc_karya'];
    $tahun_rilis = $_POST['tahun_rilis'];
    $id_kategori = $_POST['id_kategori'];

    // Cek apakah NIM sudah ada di tabel biodata_mhs
    $cek_nim = "SELECT * FROM biodata_mhs WHERE nim_mhs = '$nim_mhs'";
    $result = $conn->query($cek_nim);

    if ($result->num_rows > 0) {
        // Proses upload gambar karya
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["gambar_karya"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Cek apakah file benar-benar gambar
        $check = getimagesize($_FILES["gambar_karya"]["tmp_name"]);
        if ($check === false) {
            echo "File bukan gambar.";
            exit;
        }

        // Cek ukuran file
        if ($_FILES["gambar_karya"]["size"] > 2000000) {
            echo "Ukuran file terlalu besar.";
            exit;
        }

        // Cek format gambar
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Hanya JPG, JPEG, PNG & GIF yang diperbolehkan.";
            exit;
        }

        // Pindahkan file yang diupload ke folder
        if (move_uploaded_file($_FILES["gambar_karya"]["tmp_name"], $target_file)) {
            $gambar_karya = $target_file;

            // Query untuk menyimpan data karya ke tabel
            $sql = "INSERT INTO karya (nama_karya, nim_mhs, desc_karya, tahun_rilis, id_kategori, gambar_karya) 
                    VALUES ('$nama_karya', '$nim_mhs', '$desc_karya', '$tahun_rilis', '$id_kategori', '$gambar_karya')";

            if ($conn->query($sql) === TRUE) {
                echo "Karya berhasil ditambahkan";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Terjadi kesalahan saat mengupload file.";
        }
    } else {
        echo "NIM tidak ditemukan di biodata_mhs. Silakan masukkan NIM yang sudah terdaftar.";
    }
}

// Tutup koneksi
$conn->close();
