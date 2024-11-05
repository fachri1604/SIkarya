<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/admin.css" />
    <link rel="stylesheet" href="../css/filter.css" />
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
            <!-- <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Cari di sini..." />
            </div> -->
            <img src="images/profile.jpg" alt="" />
        </div>

        <section class="content-container">
            <div class="konten2" id="karya">
                <form id="filterForm" action="admin_page.php" method="GET">
                    <label for="categoryFilter">Kategori:</label>
                    <select id="categoryFilter" name="id_kategori">
                        <option value="">Semua Kategori</option>
                        <option value="1">PBL</option>
                        <option value="2">Tugas Akhir</option>
                        <option value="3">Final Project</option>
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

                <!-- Konten Card dengan Pagination -->
                <h2>Galeri Karya Mahasiswa</h2>

                <?php include '../php/paginationadmin.php'; ?>

            </div>
        </section>
    </section>

    <script>
        // Menampilkan pop-up berdasarkan status
        <?php if (isset($_GET['status'])): ?>
            var status = "<?php echo $_GET['status']; ?>";
            var message = "<?php echo htmlspecialchars(urldecode($_GET['message'] ?? '')); ?>";
            if (status === 'success') {
                alert(message);
            } else if (status === 'error') {
                alert('Error: ' + message);
            }
        <?php endif; ?>
    </script>
</body>

</html>