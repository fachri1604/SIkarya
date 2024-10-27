<?php
include '../php/koneksi.php'; // Pastikan sudah menghubungkan dengan database

// Bagian 1: Menampilkan Daftar Judul Karya sebagai tautan
$sql_list = "SELECT id_karya, nama_karya FROM karya ORDER BY tahun_rilis DESC";
$result_list = $conn->query($sql_list);

echo "<h2>Daftar Karya</h2>";
if ($result_list->num_rows > 0) {
    echo "<ul>";
    while ($row = $result_list->fetch_assoc()) {
        echo "<li><a href='?id_karya=" . $row['id_karya'] . "'>" . $row['nama_karya'] . "</a></li>";
    }
    echo "</ul>";
} else {
    echo "<p>Tidak ada data karya yang ditemukan.</p>";
}

// Bagian 2: Menampilkan Detail Karya Berdasarkan ID
if (isset($_GET['id_karya'])) {
    $id_karya = $_GET['id_karya'];

    // Mengambil data karya berdasarkan id_karya yang dipilih
    $sql = "SELECT * FROM karya WHERE id_karya = $id_karya";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        echo "<div class='project-container'>";
        echo "<h1>" . $row['nama_karya'] . "</h1>";
        echo "<p class='published-date'>Tahun Rilis: " . $row['tahun_rilis'] . "</p>";
        
        // Bagian Gambar Karya
        echo "<div class='gallery-thumbnails'>";
        $gambar = explode(',', $row['gambar_karya']); // Mengambil nama gambar dari string database
        foreach ($gambar as $img) {
            echo "<img src='../uploads/" . $img . "' alt='Screenshot' />";
        }
        echo "</div>";
        
        // Bagian Deskripsi Karya
        echo "<div class='project-description'>";
        echo "<p>" . $row['desc_karya'] . "</p>";
        echo "</div>";
        
        // Bagian Profil Mahasiswa
        echo "<div class='student-profile'>";
        echo "<img src='../php/uploads1/" . $row['foto'] . "' alt='Foto Mahasiswa' />";
        echo "<h3>" . $row['nama_mhs'] . "</h3>";
        echo "<p>NIM: " . $row['nim_mhs'] . "</p>";
        echo "</div>";
        
        echo "</div>";
    } else {
        echo "<p>Data karya tidak ditemukan.</p>";
    }
} else {
    echo "<p>Silakan pilih judul karya dari daftar di atas untuk melihat detailnya.</p>";
}

$conn->close();
?>
