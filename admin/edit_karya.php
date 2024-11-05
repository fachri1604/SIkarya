<?php
// Ambil ID Karya dari query parameter
$id_karya = $_GET['id_karya'] ?? null;

if ($id_karya) {
    // Menginisialisasi cURL untuk mengambil data karya dari API
    $ch = curl_init('https://raishaapi1.v-project.my.id/api/karya/' . $id_karya);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Mengirim permintaan
    $response = curl_exec($ch);

    // Menangani kesalahan cURL
    if (curl_errno($ch)) {
        header("Location: admin_page.php?status=error&message=" . urlencode('Request failed: ' . curl_error($ch)));
        exit();
    }

    // Menutup cURL
    curl_close($ch);

    // Menangani respons dari API
    $dataKarya = json_decode($response, true);
    if (!$dataKarya || !isset($dataKarya['data'])) {
        header("Location: admin_page.php?status=error&message=Data tidak ditemukan");
        exit();
    }

    // Mendapatkan data karya
    $row = $dataKarya['data'];
} else {
    header("Location: admin_page.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/admin.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <title>Edit Karya - Admin</title>
</head>

<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <img src="../assets/logo/logo_polnep.png" alt="Logo SiKarya" />
            </div>
            <span class="logo_name">SiKarya</span>
        </div>
        <div class="menu-items">
            <ul class="nav-links">
                <li>
                    <a href="admin_page.php"><i class="uil uil-estate"></i><span class="link-name">Karya</span></a>
                </li>
                <li>
                    <a href="content.php"><i class="uil uil-plus-circle"></i><span class="link-name">Tambah Karya</span></a>
                </li>
                <li>
                    <a href="Biodata.php"><i class="uil uil-user"></i><span class="link-name">Biodata Mahasiswa</span></a>
                </li>
            </ul>
            <ul class="logout-mode">
                <li>
                    <a href="../login/login.html"><i class="uil uil-signout"></i><span class="link-name">Logout</span></a>
                </li>
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            <img src="images/profile.jpg" alt="" />
        </div>
        <div class="dash-content">
            <div class="overview"></div>
            <div class="project-form">
                <h2>Edit Karya</h2>
                <form id="projectForm" action="update_karya.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_karya" value="<?php echo htmlspecialchars($row['id_karya']); ?>">

                    <label for="projectTitle">Judul Karya:</label>
                    <input type="text" id="projectTitle" name="nama_karya" value="<?php echo htmlspecialchars($row['nama_karya']); ?>" required />

                    <label for="nim">NIM Mahasiswa:</label>
                    <select id="nim" name="nim_mhs" required>
                        <option value="">Pilih NIM</option>
                        <?php
                        // Query untuk mendapatkan NIM dari API
                        $ch = curl_init('https://raishaapi1.v-project.my.id/api/biodata');
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $nimResponse = curl_exec($ch);
                        curl_close($ch);

                        $nimData = json_decode($nimResponse, true);
                        if ($nimData && isset($nimData['data'])) {
                            foreach ($nimData['data'] as $nim_row) {
                                $selected = ($nim_row['nim_mhs'] == $row['nim_mhs']) ? 'selected' : '';
                                echo "<option value='" . $nim_row['nim_mhs'] . "' " . $selected . ">" .
                                    htmlspecialchars($nim_row['nim_mhs']) . " - " . htmlspecialchars($nim_row['nama_mhs']) . "</option>";
                            }
                        } else {
                            echo "<option value=''>Tidak ada data mahasiswa</option>";
                        }
                        ?>
                    </select>

                    <label for="projectDescription">Deskripsi Karya:</label>
                    <textarea id="projectDescription" name="desc_karya" required><?php echo htmlspecialchars($row['desc_karya']); ?></textarea>

                    <label for="releaseYear">Tahun Rilis:</label>
                    <input type="text" id="releaseYear" name="tahun_rilis" value="<?php echo htmlspecialchars($row['tahun_rilis']); ?>" required />

                    <label for="categoryId">ID Kategori:</label>
                    <select id="categoryId" name="id_kategori" required>
                        <option value="">Pilih Kategori</option>
                        <?php
                        // Query untuk mendapatkan ID Kategori dari API
                        $ch = curl_init('https://raishaapi1.v-project.my.id/api/kategori');
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $catResponse = curl_exec($ch);
                        curl_close($ch);

                        $catData = json_decode($catResponse, true);
                        if ($catData && isset($catData['data'])) {
                            foreach ($catData['data'] as $cat_row) {
                                $selected = ($cat_row['id_kategori'] == $row['id_kategori']) ? 'selected' : '';
                                echo "<option value='" . $cat_row['id_kategori'] . "' " . $selected . ">" .
                                    htmlspecialchars($cat_row['id_kategori']) . " - " . htmlspecialchars($cat_row['jenis_karya']) . "</option>";
                            }
                        } else {
                            echo "<option value=''>Tidak ada data kategori</option>";
                        }
                        ?>
                    </select>

                    <label for="mainImage">Gambar Karya:</label>
                    <input type="file" id="mainImage" name="gambar_karya" accept="image/*" />
                    <small>Biarkan kosong jika tidak ingin mengubah gambar</small>

                    <button type="submit">Update Karya</button>
                </form>
            </div>
        </div>
    </section>
</body>

</html>