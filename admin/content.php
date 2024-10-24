<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../css/admin.css" />
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
  <title>Halaman Admin</title>
</head>

<body>
  <nav>
    <div class="logo-name">
      <div class="logo-image">
        <img src="../assets/logo/logo polnep.png" alt="Logo SiKarya" />
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
        <h2>Add/Edit Project</h2>
        <form id="projectForm" action="../php/tambahkarya.php" method="POST" enctype="multipart/form-data">
          <label for="projectId">ID Karya:</label>
          <input type="text" id="projectId" name="id_karya" required />

          <label for="projectTitle">Judul Karya:</label>
          <input type="text" id="projectTitle" name="nama_karya" required />

          <label for="nim">NIM Mahasiswa:</label>
          <select id="nim" name="nim_mhs" required>
            <option value="">Pilih NIM</option>
            <?php
            // Include koneksi ke database
            include '../php/koneksi.php';

            // Query untuk mendapatkan NIM dari tabel biodata_mhs
            $sql = "SELECT nim_mhs, nama_mhs FROM biodata_mhs";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['nim_mhs'] . "'>" . $row['nim_mhs'] . " - " . $row['nama_mhs'] . "</option>";
              }
            } else {
              echo "<option value=''>Tidak ada data mahasiswa</option>";
            }
            ?>
          </select>

          <label for="projectDescription">Deskripsi Karya:</label>
          <textarea id="projectDescription" name="desc_karya" required></textarea>

          <label for="releaseYear">Tahun Rilis:</label>
          <input type="text" id="releaseYear" name="tahun_rilis" required />

          <label for="categoryId">ID Kategori:</label>
          <select id="categoryId" name="id_kategori" required>
            <option value="">Pilih Kategori</option>
            <?php
            // Query untuk mendapatkan ID Kategori dari tabel kategori
            $sql = "SELECT id_kategori, jenis_karya FROM kategori";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id_kategori'] . "'>" . $row['id_kategori'] . " - " . $row['jenis_karya'] . "</option>";
              }
            } else {
              echo "<option value=''>Tidak ada data kategori</option>";
            }

            // Menutup koneksi
            $conn->close();
            ?>
          </select>

          <label for="mainImage">Gambar Karya:</label>
          <input type="file" id="mainImage" name="gambar_karya" accept="image/*" required />

          <button type="submit">Save Project</button>
        </form>
      </div>
    </div>
  </section>
</body>

</html>