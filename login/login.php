<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="../css/login.css" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
</head>

<body>
    <!-- Header Section Start -->
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
                    <li><a href="../beranda.php">Beranda</a></li>
                    <li><a href="../karya.php">Karya</a></li>
                </ul>
            </div>
            <!-- <div class="search-box">
        <i class="bx bx-search"></i>
        <div class="input-box">
          <input type="text" id="searchInput" placeholder="Search..." />
          <ul id="searchResults"></ul>
        </div>
      </div>
    </div> -->
    </nav>
    <!-- Header Section End -->

    <!-- Content Section Start -->
    <div class="content-container">
        <div class="login-container">
            <h2>Admin Login</h2>
            <form action="" method="POST"> <!-- Form akan mengarah ke file yang sama -->
                <input type="text" name="username" placeholder="Username" required />
                <input type="password" name="password" placeholder="Password" required />
                <button type="submit">Login</button>
            </form>

            <?php
            // Cek apakah form telah disubmit
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Ambil username dan password dari input
                $username = isset($_POST['username']) ? $_POST['username'] : '';
                $password = isset($_POST['password']) ? $_POST['password'] : '';

                // URL API login
                $apiUrl = 'https://raishaapi1.v-project.my.id/api/login';

                // Siapkan data untuk dikirim ke API
                $data = [
                    'username' => $username,
                    'password' => $password
                ];

                // Inisialisasi cURL
                $ch = curl_init($apiUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); // Kirim data

                // Eksekusi permintaan
                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Dapatkan status code

                // Tutup cURL
                curl_close($ch);

                // Cek status code dari respons
                if ($httpCode === 200) {
                    // Jika login berhasil, redirect ke halaman admin
                    header('Location: ../admin/admin_page.php');
                    exit;
                } else {
                    // Jika login gagal, tampilkan pesan error
                    echo "<script>alert('Nama pengguna atau kata sandi salah!');</script>";
                }
            }
            ?>
        </div>
    </div>
    <!-- Content Section End -->

    <!-- Footer Section Start -->
    <footer>
        <div class="main-content">
            <div class="left box">
                <h2>About us</h2>
                <div class="content">
                    <p>SIKARYA adalah platform yang didedikasikan untuk menampilkan karya ilmiah dan tugas akhir mahasiswa dari Politeknik Negeri Pontianak. Kami bertujuan untuk memberikan tempat bagi mahasiswa untuk memamerkan hasil kerja mereka.</p>
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
                        <span class="text">+62-561736180</span>
                    </div>
                    <div class="email">
                        <span class="fas fa-envelope"></span>
                        <span class="text">kampus@polnep.ac.id</span>
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

        <!-- Footer Bottom -->
        <div class="bottom">
            <center>
                <span class="credit">Created By <a href="https://polnep.ac.id/">POLNEP</a> | </span>
                <span class="far fa-copyright"></span><span> 2020 All rights reserved.</span>
            </center>
        </div>
    </footer>
</body>

</html>