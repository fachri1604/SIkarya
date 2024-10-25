<?php
include '../php/koneksi.php';

if (isset($_POST['id_karya'])) {
    $id_karya = mysqli_real_escape_string($conn, $_POST['id_karya']);

    // Pertama, hapus file gambar jika ada
    $query_gambar = "SELECT gambar_karya FROM karya WHERE id_karya = '$id_karya'";
    $result_gambar = mysqli_query($conn, $query_gambar);
    $row = mysqli_fetch_assoc($result_gambar);
    
    if ($row && !empty($row['gambar_karya'])) {
        $file_path = '../php/' . $row['gambar_karya'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    // Kemudian hapus record dari database
    $query = "DELETE FROM karya WHERE id_karya = '$id_karya'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: admin_page.php?status=success&message=Data berhasil dihapus");
        exit();
    } else {
        header("Location: admin_page.php?status=error&message=Gagal menghapus data");
        exit();
    }
} else {
    header("Location: admin_page.php?status=error&message=ID tidak valid");
    exit();
}
?>