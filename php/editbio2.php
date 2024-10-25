<?php
include 'koneksi.php';

$target_dir = "uploads1/";
$nim_mhs = $_POST['nim_mhs'];
$nama_mhs = $_POST['nama_mhs'];
$prodi = $_POST['prodi'];
$jurusan = $_POST['jurusan'];
$email = $_POST['email'];
$no_hp = $_POST['no_hp'];
$foto = basename($_FILES["foto"]["name"]);

// Cek jika NIM sudah ada
$sql_check = "SELECT * FROM biodata_mhs WHERE nim_mhs = '$nim_mhs'";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
    // Mode Update jika NIM ada
    $row = $result_check->fetch_assoc(); // Ambil data untuk mendapatkan foto yang ada
    $existing_foto = $row['foto']; // Simpan nama foto yang sudah ada

    $sql = "UPDATE biodata_mhs SET 
                nama_mhs='$nama_mhs', 
                prodi='$prodi', 
                jurusan='$jurusan', 
                email='$email', 
                no_hp='$no_hp'";

    // Jika ada foto yang diunggah, update foto
    if ($_FILES["foto"]["size"] > 0) { // Cek apakah ada file yang diupload
        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $foto);
        $sql .= ", foto='$foto'"; // Tambahkan foto jika ada yang diunggah
    } else {
        $sql .= ", foto='$existing_foto'"; // Jaga foto yang ada jika tidak diupload baru
    }

    $sql .= " WHERE nim_mhs='$nim_mhs'";
    $action_message = "Data berhasil diperbarui.";
} else {
    // Mode Tambah jika NIM tidak ada
    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $foto)) {
        $sql = "INSERT INTO biodata_mhs (nim_mhs, nama_mhs, prodi, jurusan, email, no_hp, foto)
                VALUES ('$nim_mhs', '$nama_mhs', '$prodi', '$jurusan', '$email', '$no_hp', '$foto')";
        $action_message = "Data berhasil ditambahkan.";
    }
}

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('$action_message'); window.location.href='../admin/biodata.php';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
