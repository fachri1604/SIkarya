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
                <li><a href="content.php"><i class="uil uil-plus-circle"></i><span class="link-name">Tambah Karya</span></a></li>
                <li><a href="Biodata.php"><i class="uil uil-user"></i><span class="link-name">Biodata Mahasiswa</span></a></li>
            </ul>
            <ul class="logout-mode">
                <li><a href="../login/login.html"><i class="uil uil-signout"></i><span class="link-name">Logout</span></a></li>
                <!-- <li class="mode">
                    <a href="#"><i class="uil uil-moon"></i><span class="link-name">Mode Gelap</span></a>
                    <div class="mode-toggle"><span class="switch"></span></div>
                </li> -->
            </ul>
        </div>
    </nav>
    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Cari di sini..." />
            </div>
            <img src="images/profile.jpg" alt="" />
        </div>

        <div class="content">
            <section class="karya-container">
                <div class="konten">
                    <h2>Galeri Karya Mahasiswa</h2>
                    <div class="card-list">
                        <?php
                        include '../php/ambil_data.php'; // Mengambil data dari file terpisah


                        if (!empty($karya)) {
                            foreach ($karya as $row) {
                                echo '<a href="detail/detail' . $row['id_karya'] . '.html" class="card-item">';
                                echo '<img src="../php/' . $row['gambar_karya'] . '" alt="Gambar Karya" />';
                                echo '<h3>' . $row['nama_karya'] . '</h3>';
                                echo '<p>NIM: ' . $row['nim_mhs'] . '</p>';
                                echo '<p>Deskripsi: ' . $row['desc_karya'] . '</p>';
                                echo '<p>Tahun Rilis: ' . $row['tahun_rilis'] . '</p>';
                                echo '<p>ID Kategori: ' . $row['id_kategori'] . '</p>';
                                echo '<div class="card-actions">';
                                echo '<div class="button-group">';
                                echo '<button class="edit-btn">Edit</button>';
                                echo '<button class="delete-btn">Hapus</button>';
                                echo '</div></div></a>';
                            }
                        } else {
                            echo '<p>Tidak ada proyek ditemukan.</p>';
                        }
                        ?>
                    </div>
                </div>
            </section>
        </div>
    </section>
    <script src="../js/project_card.js"></script>
</body>

</html>