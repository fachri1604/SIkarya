<?php
include '../php/koneksi.php'; // Menghubungkan ke database

// Cek apakah ada pencarian
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$query = "SELECT * FROM karya";

// Filter jika ada pencarian
if ($search) {
    $query .= " WHERE nama_karya LIKE '%$search%'";
}

$result = $conn->query($query);
?>

<div class="card-list">
    <?php
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $gambar_karya_array = explode(',', $row['gambar_karya']);
            $gambar_pertama = $gambar_karya_array[0];
    ?>
            <div class="card-item">
                <div class="card-content">
                    <img src="../uploads/<?php echo $gambar_pertama; ?>" alt="Gambar Karya" />
                    <h3><?php echo $row['nama_karya']; ?></h3>
                    <p>NIM: <?php echo $row['nim_mhs']; ?></p>
                    <p>Deskripsi: <?php echo $row['desc_karya']; ?></p>
                </div>
            </div>
    <?php
        }
    } else {
        echo "<p>Tidak ada karya ditemukan.</p>";
    }
    ?>
</div>
