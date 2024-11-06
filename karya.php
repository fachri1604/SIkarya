<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="./css/style.css" />
  <link rel="stylesheet" href="./css/filter.css" />

  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SIKARYA</title>
</head>

<body>
  <!-- Header Section -->
  <nav>
    <div class="navbar">
      <i class="bx bx-menu"></i>
      <div class="logo"><a href="beranda.php">SiKarya</a></div>
      <div class="nav-links">
        <div class="sidebar-logo">
          <span class="logo-name">SiKarya</span>
          <i class="bx bx-x"></i>
        </div>
        <ul class="links">
          <li><a href="beranda.php">Beranda</a></li>
          <li><a href="karya.php">Karya</a></li>
          <li><a href="login/login.php">Login</a></li>
        </ul>
      </div>
      <!-- <div class="search-box">
        <i class="bx bx-search"></i>
        <div class="input-box">
          <input type="text" id="searchInput" placeholder="Search..." />
          <ul id="searchResults"></ul>
        </div> -->
    </div>
    </div>
  </nav>

  <!-- Filter Section -->
  <section class="content-container">
    <div class="konten2" id="karya">
      <form id="filterForm" action="karya.php" method="GET">
        <label for="categoryFilter">Kategori:</label>
        <select id="categoryFilter" name="id_kategori">
          <option value="">Semua Kategori</option>
          <option value="1">PBL</option>
          <option value="2">Tugas Akhir</option>
          <option value="3">Lomba</option>
        </select>

        <label for="yearFilter">Tahun Rilis:</label>
        <select id="yearFilter" name="tahun_rilis">
          <option value="">Semua Tahun</option>
          <?php
          $currentYear = date("Y");
          for ($year = $currentYear; $year >= 2020; $year--) {
            echo "<option value='$year'>$year</option>";
          }
          ?>
        </select>

        <button type="submit">Filter</button>
      </form>


      <!-- Content Section -->
      <h2>Galeri Karya Mahasiswa</h2>

      <?php include './php/paginationkarya.php'; ?> <!-- Include the pagination logic -->

    </div>
  </section>

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
              <input type="email" required />
            </div>
            <div class="msg">
              <div class="text">Message *</div>
              <textarea rows="2" cols="25" required></textarea>
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

  <!-- JavaScript -->
  <script src="js/filter.js"></script>
</body>

</html>