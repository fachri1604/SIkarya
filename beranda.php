<!DOCTYPE html>
<html lang="en">
  <head>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    />
    <meta charset="UTF-8" />
    <link
      rel="stylesheet"
      href="./css/style.css"
    />
    <meta
      http-equiv="X-UA-Compatible"
      content="IE=edge"
    />
    <link
      href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"
      rel="stylesheet"
    />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0"
    />
    <title>SIKARYA</title>
  </head>
  <body>
    <!-- Header Section Start -->
    <nav>
      <div class="navbar">
        <i class="bx bx-menu"></i>
        <div class="logo"><a href="index.html">SiKarya</a></div>
        <div class="nav-links">
          <div class="sidebar-logo">
            <span class="logo-name">SiKarya</span>
            <i class="bx bx-x"></i>
          </div>
          <ul class="links">
            <li><a href="index.php">Beranda</a></li>
            <li><a href="karya.php">Karya</a></li>
            <li><a href="login/login.html">Login</a></li>
          </ul>
        </div>
        <div class="search-box">
          <i class="bx bx-search"></i>
          <div class="input-box">
            <input
              type="text"
              id="searchInput"
              placeholder="Search..."
            />
            <ul id="searchResults"></ul>
          </div>
        </div>
      </div>
    </nav>
    <script src="js/navbar.js"></script>
    <script src="js/search.js"></script>
    <!-- Header Section End -->

    <!-- Content Section Start -->
    <section class="content-container">
      <div
        class="konten1"
        id="beranda"
      >
        <h2>Galeri Hasil Karya Mahasiswa</h2>
        <h2>Platform Untuk Menampilkan Karya Ilmiah dan Tugas Akhir Mahasiswa</h2>
      </div>

      <div
        class="konten2"
        id="karya"
      >
        <h2>Galeri Karya Mahasiswa</h2>
        <div class="card-list">
          <?php
            include 'php/koneksi.php'; // Menghubungkan ke database
            $sql = "SELECT id_karya, nama_karya, gambar_karya FROM karya ORDER BY tahun_rilis DESC LIMIT 4"; // Mengambil 4 karya terbaru
            $result = $conn->query($sql);

            $karya_list = []; // Array sementara untuk menyimpan data

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $gambar_karya = explode(',', $row['gambar_karya'])[0]; // Mengambil gambar pertama
                    // Simpan elemen HTML dalam array, bukan langsung ditampilkan
                    $karya_list[] = "<a href='/SIKARYA2/SIkarya/detail/detail.php?id_karya=" . $row['id_karya'] . "' class='card-item'>"
                                  . "<img src='uploads/" . $gambar_karya . "' alt='Card Image' />"
                                  . "<h3>" . $row['nama_karya'] . "</h3>"
                                  . "<div class='arrow'><i class='fas fa-arrow-right card-icon'></i></div>"
                                  . "</a>";
                }
                // Balik urutan array dan tampilkan
                foreach (array_reverse($karya_list) as $karya) {
                    echo $karya;
                }
            } else {
                echo "<p>Tidak ada data karya yang ditemukan.</p>";
            }
            $conn->close();
          ?>
        </div>
      </div>
    </section>
    <!-- Content Section End -->

    <!-- Footer Section Start -->
    <footer>
      <div class="main-content">
        <div class="left box">
          <h2>Tentang Kami</h2>
          <div class="content">
            <p>
              SIKARYA adalah platform yang didedikasikan untuk menampilkan karya ilmiah dan tugas akhir mahasiswa dari Politeknik Negeri Pontianak. Kami bertujuan untuk memberikan tempat bagi mahasiswa untuk memamerkan hasil kerja mereka.
            </p>
            <br />
            <p>Kami percaya bahwa setiap karya memiliki cerita dan nilai yang harus diapresiasi, dan melalui SIKARYA, kami berharap dapat memberikan pengakuan yang layak bagi setiap karya mahasiswa.</p>
            <div class="social">
              <a href="https://web.facebook.com/polneppontianak"><span class="fab fa-facebook-f"></span></a>
              <a href="https://x.com/mediapolnep?t=hlVsNyODz2wSoB0LnMBReg&s=09"><span class="fab fa-twitter"></span></a>
              <a href="https://www.instagram.com/polnep.official/"><span class="fab fa-instagram"></span></a>
              <a href="http://www.youtube.com/@mediapolnep"><span class="fab fa-youtube"></span></a>
            </div>
          </div>
        </div>

        <div class="center box">
          <h2>Alamat</h2>
          <div class="content">
            <div class="place">
              <span class="fas fa-map-marker-alt"></span>
              <span class="text">Kalimantan Barat, Pontianak</span>
            </div>
            <div class="phone">
              <span class="fas fa-phone-alt"></span>
              <span class="text">+089-765432100</span>
            </div>
            <div class="email">
              <span class="fas fa-envelope"></span>
              <span class="text">Polnep@gmail.com</span>
            </div>
          </div>
        </div>

        <div class="right box">
          <h2>Hubungi Kami</h2>
          <div class="content">
            <form action="#">
              <div class="email">
                <div class="text">Email *</div>
                <input
                  type="email"
                  required
                />
              </div>
              <div class="msg">
                <div class="text">Message *</div>
                <textarea
                  rows="2"
                  cols="25"
                  required
                ></textarea>
              </div>
              <div class="btn">
                <button type="submit">Send</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="bottom">
        <center>
          <span class="credit">Created By <a href="">POlNEP</a> | </span>
          <span class="far fa-copyright"></span><span> 2020 All rights reserved.</span>
        </center>
      </div>
    </footer>
    <!-- Footer Section End -->
  </body>
</html>