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
        <li><a href="admin_page.php"><i class="uil uil-estate"></i><span class="link-name">Karya</span></a></li>
        <li><a href="content.html"><i class="uil uil-plus-circle"></i><span class="link-name">Tambah Karya</span></a></li>
        <li><a href="Biodata.php"><i class="uil uil-user"></i><span class="link-name">Biodata Mahasiswa</span></a></li>
      </ul>
      <ul class="logout-mode">
        <li><a href="../login/login.html"><i class="uil uil-signout"></i><span class="link-name">Logout</span></a></li>
      </ul>
    </div>
  </nav>

  <section class="dashboard">
    <div class="top">
      <i class="uil uil-bars sidebar-toggle"></i>
      <!-- <img src="images/profile.jpg" alt="Profile Image" /> -->
    </div>

    <div class="dash-content">
      <h3>Data Mahasiswa</h3>
      <table id="dataTable">
        <thead>
          <tr>
            <th>NIM</th>
            <th>Nama Lengkap</th>
            <th>Prodi</th>
            <th>Jurusan</th>
            <th>Email</th>
            <th>Nomor Handphone</th>
            <th>Foto Profil</th>
          </tr>
        </thead>
        <tbody>
          <?php
          include '../php/koneksi.php';
          $sql = "SELECT * FROM biodata_mhs";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr>
              <td>" . $row["nim_mhs"] . "</td>
              <td>" . $row["nama_mhs"] . "</td>
              <td>" . $row["prodi"] . "</td>
              <td>" . $row["jurusan"] . "</td>
              <td>" . $row["email"] . "</td>
              <td>" . $row["no_hp"] . "</td>
              <td><img src='../php/uploads1/" . $row["foto"] . "' alt='Foto Profil' class='profile-img'></td>
            </tr>";
            }
          } else {
            echo "<tr><td colspan='7'>Tidak ada data ditemukan</td></tr>";
          }
          $conn->close();
          ?>
        </tbody>
      </table>

      <!-- Form untuk tambah/edit biodata mahasiswa -->
      <div class="project-form">
        <h2>Tambah/Edit Biodata Mahasiswa</h2>
        <form id="projectForm" action="../php/tambahbio.php" method="POST" enctype="multipart/form-data">
          <label for="nim">NIM:</label>
          <input type="text" id="nim" name="nim_mhs" required />

          <label for="nama">Nama Lengkap:</label>
          <input type="text" id="nama" name="nama_mhs" required />

          <label for="prodi">Prodi:</label>
          <input type="text" id="prodi" name="prodi" required />

          <label for="jurusan">Jurusan:</label>
          <input type="text" id="jurusan" name="jurusan" required />

          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required />

          <label for="nomor">Nomor Handphone:</label>
          <input type="text" id="nomor" name="no_hp" required />

          <label for="profileImage">Foto Profil:</label>
          <input type="file" id="profileImage" name="foto" accept="image/*" required />

          <button type="submit" name="submit">Simpan Data</button>
        </form>
      </div>
    </div>
  </section>

  <script src="../js/script.js"></script>
</body>

</html>