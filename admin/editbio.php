<?php
// Ambil NIM dari query parameter
$nim_mhs = $_GET['nim_mhs'] ?? null;

if ($nim_mhs) {
    // Menginisialisasi cURL untuk mengambil data biodata dari API
    $ch = curl_init('https://raishaapi1.v-project.my.id/api/biodata/' . $nim_mhs);
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
    $dataBiodata = json_decode($response, true);
    if (!$dataBiodata || !isset($dataBiodata['data'])) {
        header("Location: admin_page.php?status=error&message=Data tidak ditemukan");
        exit();
    }

    // Mendapatkan data biodata
    $row = $dataBiodata['data'];
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
    <title>Edit Biodata - Admin</title>
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
                <h2>Edit Biodata</h2>
                <form id="biodataForm" action="update_bio.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="nim_mhs" value="<?php echo htmlspecialchars($row['nim_mhs']); ?>">

                    <label for="nim">NIM Mahasiswa:</label>
                    <input type="text" id="nim" name="nim_mhs" value="<?php echo htmlspecialchars($row['nim_mhs']); ?>" required />

                    <label for="nama">Nama Mahasiswa:</label>
                    <input type="text" id="nama" name="nama_mhs" value="<?php echo htmlspecialchars($row['nama_mhs']); ?>" required />

                    <label for="prodi">Program Studi:</label>
                    <input type="text" id="prodi" name="prodi" value="<?php echo htmlspecialchars($row['prodi']); ?>" required />

                    <label for="jurusan">Jurusan:</label>
                    <input type="text" id="jurusan" name="jurusan" value="<?php echo htmlspecialchars($row['jurusan']); ?>" required />

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required />

                    <label for="no_hp">No HP:</label>
                    <input type="text" id="no_hp" name="no_hp" value="<?php echo htmlspecialchars($row['no_hp']); ?>" required />

                    <label for="foto">Foto:</label>
                    <input type="file" id="foto" name="foto" accept="image/*" />
                    <small>Biarkan kosong jika tidak ingin mengubah foto</small>

                    <button type="submit">Update Biodata</button>
                </form>
            </div>
        </div>
    </section>
</body>

</html>