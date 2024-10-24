<?php
// Include file koneksi ke database
include '../php/koneksi.php';

// Mendapatkan NIM dari URL
if (isset($_GET['nim_mhs'])) {
    $nim = $_GET['nim_mhs'];

    // Query untuk mengambil data mahasiswa berdasarkan NIM
    $sql = "SELECT * FROM biodata_mhs WHERE nim_mhs='$nim'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Tampilkan form dengan data mahasiswa untuk diedit
    } else {
        echo "Data tidak ditemukan.";
    }
} else {
    echo "NIM tidak ditemukan.";
}

// Menutup koneksi
$conn->close();
?>

<!-- Form untuk mengedit data mahasiswa -->
<form action="editbio2.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="nim_mhs" value="<?php echo $row['nim_mhs']; ?>">
    
    <label for="nama">Nama Lengkap:</label>
    <input type="text" name="nama_mhs" value="<?php echo $row['nama_mhs']; ?>" required>

    <label for="prodi">Prodi:</label>
    <input type="text" name="prodi" value="<?php echo $row['prodi']; ?>" required>

    <label for="jurusan">Jurusan:</label>
    <input type="text" name="jurusan" value="<?php echo $row['jurusan']; ?>" required>

    <label for="email">Email:</label>
    <input type="email" name="email" value="<?php echo $row['email']; ?>" required>

    <label for="nomor">Nomor Handphone:</label>
    <input type="text" name="no_hp" value="<?php echo $row['no_hp']; ?>" required>

    <label for="profileImage">Foto Profil:</label>
    <input type="file" name="foto" accept="image/*">

    <button type="submit" name="submit">Simpan Perubahan</button>
</form>
