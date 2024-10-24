<?php
include 'koneksi.php'; // Pastikan koneksi ke database

$target_dir = "uploads1/"; // Direktori penyimpanan diubah menjadi uploads1
$target_file = $target_dir . basename($_FILES["foto"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Cek apakah form telah disubmit
if (isset($_POST["submit"])) {

    // Validasi apakah file benar-benar gambar
    $check = getimagesize($_FILES["foto"]["tmp_name"]);
    if ($check !== false) {
        echo "File adalah gambar - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File bukan gambar.";
        $uploadOk = 0;
    }

    // Cek apakah file sudah ada
    if (file_exists($target_file)) {
        echo "File sudah ada.";
        $uploadOk = 0;
    }

    // Cek ukuran file (maksimum 5MB)
    if ($_FILES["foto"]["size"] > 5000000) {
        echo "Ukuran file terlalu besar.";
        $uploadOk = 0;
    }

    // Batasi hanya format gambar tertentu (JPG, JPEG, PNG, GIF)
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Hanya file JPG, JPEG, PNG & GIF yang diizinkan.";
        $uploadOk = 0;
    }

    // Jika tidak ada kesalahan, lanjutkan upload
    if ($uploadOk == 0) {
        echo "File tidak berhasil diunggah.";
        echo '<br><button onclick="history.back()">Kembali</button>'; // Button to go back
    } else {
        // Cek apakah NIM sudah ada di database
        $nim_mhs = $_POST['nim_mhs'];
        $sql_check = "SELECT * FROM biodata_mhs WHERE nim_mhs = '$nim_mhs'";
        $result_check = $conn->query($sql_check);

        if ($result_check->num_rows > 0) {
            echo "<script>alert('NIM sudah ada. Silakan masukkan NIM yang berbeda.');</script>";
            echo '<br><button onclick="history.back()">Kembali</button>'; // Button to go back
        } else {
            // Jika NIM tidak ada, lanjutkan proses upload
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                echo "File " . basename($_FILES["foto"]["name"]) . " telah diunggah.";

                // Lanjutkan dengan menyimpan data ke database
                $nama_mhs = $_POST['nama_mhs'];
                $prodi = $_POST['prodi'];
                $jurusan = $_POST['jurusan'];
                $email = $_POST['email'];
                $no_hp = $_POST['no_hp'];
                $foto = basename($_FILES["foto"]["name"]); // Nama file yang diunggah

                // SQL untuk insert data ke tabel biodata_mhs
                $sql = "INSERT INTO biodata_mhs (nim_mhs, nama_mhs, prodi, jurusan, email, no_hp, foto)
                        VALUES ('$nim_mhs', '$nama_mhs', '$prodi', '$jurusan', '$email', '$no_hp', '$foto')";

                if ($conn->query($sql) === TRUE) {
                    echo "<script>alert('Biodata mahasiswa berhasil ditambahkan.');</script>";
                    echo '<br><button onclick="window.location.href=\'../admin/biodata.php\'">Kembali ke Halaman Awal</button>'; // Button to go to home
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                    echo '<br><button onclick="history.back()">Kembali</button>'; // Button to go back on error
                }
            } else {
                echo "Terjadi kesalahan saat mengunggah file.";
                echo '<br><button onclick="history.back()">Kembali</button>'; // Button to go back
            }
        }
    }
}

// Tutup koneksi database
$conn->close();
