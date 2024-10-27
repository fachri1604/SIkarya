<?php
// Koneksi ke database
include '../php/koneksi.php';


$id_karya = $_GET['id_karya']; // Mendapatkan ID karya dari URL
$stmt = $conn->prepare("
    SELECT 
        karya.nama_karya, 
        karya.desc_karya, 
        biodata_mhs.nama_mhs 
    FROM 
        karya 
    JOIN 
        biodata_mhs ON karya.nim_mhs = biodata_mhs.nim_mhs 
    WHERE 
        karya.id_karya = ?
");
$stmt->bind_param("i", $id_karya); // Mengikat parameter
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "Nama Karya: " . $row['nama_karya'];
    echo "Deskripsi: " . $row['desc_karya'];
    echo "Nama Mahasiswa: " . $row['nama_mhs']; // Menggunakan nama kolom yang benar
} else {
    echo "Karya tidak ditemukan.";
}

$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Karya - <?php echo $nama_karya; ?></title>
    <link rel="stylesheet" href="../css/tes.css">
</head>
<body>
    <!-- Menampilkan Detail Karya -->
    <div class="project-container">
        <h1><?php echo $nama_karya; ?></h1>
        <p><?php echo $deskripsi; ?></p>

        <!-- Galeri Gambar -->
        <div class="gallery">
            <?php foreach ($gambar_karya as $gambar) { ?>
                <img src="uploads/<?php echo $gambar; ?>" alt="Screenshot">
            <?php } ?>
        </div>

        <!-- Profil Mahasiswa -->
        <div class="student-profile">
            <h3>Nama Mahasiswa: <?php echo $mahasiswa_nama; ?></h3>
        </div>
    </div>
</body>
</html>
