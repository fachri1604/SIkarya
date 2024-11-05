<!DOCTYPE html>
<html lang="id">

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
        <img src="../assets/logo/logo_polnep.png" alt="Logo SiKarya" />
      </div>
      <span class="logo_name">SiKarya</span>
    </div>
    <div class="menu-items">
      <ul class="nav-links">
        <li><a href="admin_page.php"><i class="uil uil-estate"></i><span class="link-name">Karya</span></a></li>
        <li><a href="content.php"><i class="uil uil-plus-circle"></i><span class="link-name">Tambah Karya</span></a></li>
        <li><a href="Biodata.php"><i class="uil uil-user"></i><span class="link-name">Data Mahasiswa</span></a></li>
        <li><a href="admin.php"><i class="uil uil-user"></i><span class="link-name">Admin Desk</span></a></li>
      </ul>
      <ul class="logout-mode">
        <li><a href="../login/login.php"><i class="uil uil-signout"></i><span class="link-name">Logout</span></a></li>
      </ul>
    </div>
  </nav>

  <section class="dashboard">
    <div class="top">
      <h3>Data Admin</h3>
    </div>

    <div class="dash-content">
      <table id="dataTable">
        <thead>
          <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Fetch data dari API
          $url = "http://127.0.0.1:8000/api/users";
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $response = curl_exec($ch);
          if (curl_errno($ch)) {
            die('Error: ' . curl_error($ch));
          }
          curl_close($ch);

          $data = json_decode($response, true);

          if (isset($data['success']) && $data['success']) {
            foreach ($data['data'] as $row) {
              // Cek apakah ada data 'foto' dan konversi ke URL penuh


              // echo "<p>URL Foto: " . htmlspecialchars($fotoUrl) . "</p>";

              echo "<tr>
                        <td>" . htmlspecialchars($row["username"]) . "</td>
                        <td>" . htmlspecialchars($row["email"]) . "</td>
                       
                        
             
        <td>
          <div class='button-group'>
            <a href='edit_admin.php?username=" . htmlspecialchars($row["username"]) . "' 
               class='edit-btn' 
               onclick='return confirm(\"Apakah Anda yakin ingin mengedit data ini?\")'>
              <i class='uil uil-edit'></i>
            </a>
            <a href='../php/hapus_admin.php?username=" . htmlspecialchars($row["username"]) . "' 
               class='delete-btn' 
               onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>
              <i class='uil uil-trash-alt'></i>
            </a>
          </div>
        </td>
      </tr>";
            }
          } else {
            echo "<tr><td colspan='8' style='text-align: center;'>Tidak ada data ditemukan</td></tr>";
          }
          ?>
        </tbody>
      </table>
      <div class="project-form" id="editFormSection">
        <h2>Tambah/Edit Biodata Mahasiswa</h2>
        <form id="projectForm" action="../php/tambahadmin.php" method="POST" enctype="multipart/form-data">
          <label for="username">Username:</label>
          <input type="text" id="username" name="username" required />

          <label for="email">Email:</label>
          <input type="text" id="email" name="email" required />

          <label for="password">Password:</label>
          <input type="text" id="password" name="password" required />

          <button type="submit" name="submit">Simpan Data</button>
        </form>
      </div>
    </div>
  </section>

  <!-- <script>
    function populateForm(event, editButton) {
      event.preventDefault();
      document.getElementById("nim").value = editButton.getAttribute("data-nim");
      document.getElementById("nama").value = editButton.getAttribute("data-nama");
      document.getElementById("prodi").value = editButton.getAttribute("data-prodi");
      document.getElementById("jurusan").value = editButton.getAttribute("data-jurusan");
      document.getElementById("email").value = editButton.getAttribute("data-email");
      document.getElementById("nomor").value = editButton.getAttribute("data-nomor");

      const fileInput = document.getElementById("profileImage");
      const existingPreview = document.querySelector("#editFormSection .profile-preview");
      if (existingPreview) existingPreview.remove();

      const foto = editButton.getAttribute("data-foto");
      if (foto) {
        const profilePreview = document.createElement("img");
        // profilePreview.src = ../php/uploads/${foto};
        profilePreview.alt = "Foto Profil";
        profilePreview.classList.add("profile-preview");
        fileInput.insertAdjacentElement("afterend", profilePreview);
      }
    }
  </script> -->

</body>

</html>