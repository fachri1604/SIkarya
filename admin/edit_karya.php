<?php
include '../php/koneksi.php';

if (isset($_GET['id_karya'])) {
    $id_karya = mysqli_real_escape_string($conn, $_GET['id_karya']);
    
    // Mengambil data karya berdasarkan ID
    $query = "SELECT * FROM karya WHERE id_karya = '$id_karya'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        header("Location: admin_page.php?status=error&message=Data tidak ditemukan");
        exit();
    }
} else {
    header("Location: admin_page.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Karya</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="edit-container">
        <h2>Edit Karya</h2>
        <form action="update_karya.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_karya" value="<?php echo htmlspecialchars($row['id_karya']); ?>">

            <label for="nama_karya">Nama Karya:</label>
            <input type="text" id="nama_karya" name="nama_karya" value="<?php echo htmlspecialchars($row['nama_karya']); ?>" required>

            <label for="desc_karya">Deskripsi Karya:</label>
            <textarea id="desc_karya" name="desc_karya" required><?php echo htmlspecialchars($row['desc_karya']); ?></textarea>

            <label for="tahun_rilis">Tahun Rilis:</label>
            <input type="text" id="tahun_rilis" name="tahun_rilis" value="<?php echo htmlspecialchars($row['tahun_rilis']); ?>" required>

            <label for="gambar_karya">Gambar Karya:</label>
            <input type="file" id="gambar_karya" name="gambar_karya">
            <small>Biarkan kosong jika tidak ingin mengubah gambar</small>

            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>
