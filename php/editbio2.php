<?php
include '../php/koneksi.php';

if (isset($_POST['nim_mhs'])) {
    $nim = $_POST['nim_mhs'];
    $nama = $_POST['nama_mhs'];
    $prodi = $_POST['prodi'];
    $jurusan = $_POST['jurusan'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];

    // Cek apakah ada foto yang diunggah
    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto']['name'];
        $target_dir = "../php/uploads1/";
        $target_file = $target_dir . basename($_FILES["foto"]["name"]);

        // Upload foto
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            // Jika upload sukses, update dengan foto baru
            $sql = "UPDATE biodata_mhs SET 
                        nama_mhs='$nama', 
                        prodi='$prodi', 
                        jurusan='$jurusan', 
                        email='$email', 
                        no_hp='$no_hp', 
                        foto='$foto' 
                    WHERE nim_mhs='$nim'";
        } else {
            echo "Error saat mengunggah foto.";
            exit;
        }
    } else {
        // Jika tidak ada foto yang diunggah, update tanpa mengubah kolom foto
        $sql = "UPDATE biodata_mhs SET 
                    nama_mhs='$nama', 
                    prodi='$prodi', 
                    jurusan='$jurusan', 
                    email='$email', 
                    no_hp='$no_hp'
                WHERE nim_mhs='$nim'";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil diperbarui.";
        header('Location: ../admin/Biodata.php'); // Redirect ke halaman admin setelah update
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    echo "Form tidak lengkap.";
}
?>
