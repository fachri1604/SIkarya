<?php
include '../php/koneksi.php';

// Function to generate a new ID
function generateNewId($conn) {
    $sql = "SELECT id_karya FROM karya ORDER BY id_karya DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastId = $row['id_karya'];
        $number = intval(substr($lastId, 1));
        $newNumber = $number + 1;
    } else {
        $newNumber = 1;
    }
    return 'K' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $id_karya = generateNewId($conn);
        $nama_karya = $_POST['nama_karya'];
        $nim_mhs = $_POST['nim_mhs'];
        $desc_karya = $_POST['desc_karya'];
        $tahun_rilis = $_POST['tahun_rilis'];
        $id_kategori = $_POST['id_kategori'];
        $gambar_karya = [];

        if (isset($_FILES['gambar_karya'])) {
            $target_dir = "../uploads/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            foreach ($_FILES['gambar_karya']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['gambar_karya']['error'][$key] == 0) {
                    $file_extension = pathinfo($_FILES['gambar_karya']['name'][$key], PATHINFO_EXTENSION);
                    $new_filename = $id_karya . '_' . ($key + 1) . '.' . $file_extension;
                    $target_file = $target_dir . $new_filename;
                    if (move_uploaded_file($tmp_name, $target_file)) {
                        $gambar_karya[] = $new_filename;
                    }
                }
            }
        }

        $gambar_karya_string = implode(',', $gambar_karya);
        $stmt = $conn->prepare("INSERT INTO karya (id_karya, nama_karya, nim_mhs, desc_karya, tahun_rilis, id_kategori, gambar_karya) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $id_karya, $nama_karya, $nim_mhs, $desc_karya, $tahun_rilis, $id_kategori, $gambar_karya_string);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Karya berhasil ditambahkan!');
                    window.location.href = 'admin_page.php';
                  </script>";
        } else {
            throw new Exception("Error: " . $stmt->error);
        }
        $stmt->close();
    } catch (Exception $e) {
        echo "<script>
                alert('Error: " . addslashes($e->getMessage()) . "');
                window.history.back();
              </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Head content -->
</head>
<body>
    <section class="content-container">
        <form action="content.php" method="POST" enctype="multipart/form-data">
            <label for="nama_karya">Nama Karya:</label>
            <input type="text" name="nama_karya" required>
            <label for="nim_mhs">NIM:</label>
            <input type="text" name="nim_mhs" required>
            <label for="desc_karya">Deskripsi:</label>
            <textarea name="desc_karya" required></textarea>
            <label for="tahun_rilis">Tahun Rilis:</label>
            <input type="number" name="tahun_rilis" required>
            <label for="id_kategori">ID Kategori:</label>
            <input type="text" name="id_kategori" required>
            <label for="gambar_karya">Gambar Karya:</label>
            <input type="file" name="gambar_karya[]" multiple required>
            <button type="submit">Tambah Karya</button>
        </form>
    </section>
</body>
</html>
