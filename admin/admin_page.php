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
                        include '../php/ambil_data.php';
                        include '../php/koneksi.php';
                        
                        // Handle delete
                        if (isset($_POST['delete']) && isset($_POST['id_karya'])) {
                            $id_karya = mysqli_real_escape_string($conn, $_POST['id_karya']);
                            
                            // Ambil informasi gambar sebelum menghapus
                            $query_gambar = "SELECT gambar_karya FROM karya WHERE id_karya = '$id_karya'";
                            $result_gambar = mysqli_query($conn, $query_gambar);
                            $row = mysqli_fetch_assoc($result_gambar);
                            
                            // Hapus file gambar jika ada
                            if ($row && !empty($row['gambar_karya'])) {
                                $file_path = '../php/' . $row['gambar_karya'];
                                if (file_exists($file_path)) {
                                    unlink($file_path);
                                }
                            }
                            
                            // Hapus record dari database
                            $query = "DELETE FROM karya WHERE id_karya = '$id_karya'";
                            if (mysqli_query($conn, $query)) {
                                // Redirect ke halaman yang sama dengan pesan sukses
                                header("Location: ".$_SERVER['PHP_SELF']."?status=success&message=Data berhasil dihapus");
                                exit();
                            } else {
                                header("Location: ".$_SERVER['PHP_SELF']."?status=error&message=Gagal menghapus data");
                                exit();
                            }
                        }
                        
                        // Tampilkan pesan status jika ada
                        if (isset($_GET['status'])) {
                            $status = $_GET['status'];
                            $message = $_GET['message'] ?? '';
                            
                            if ($status == 'success') {
                                echo '<div class="alert alert-success">' . htmlspecialchars($message) . '</div>';
                            } else if ($status == 'error') {
                                echo '<div class="alert alert-danger">' . htmlspecialchars($message) . '</div>';
                            }
                        }
                        ?>
                        <!DOCTYPE html>
                        <!-- [Previous HTML head and nav remains the same] -->
                        <link rel="stylesheet" href="../css/admin.css" />
                        
                        <div class="card-list">
                            <?php
                            if (!empty($karya)) {
                                foreach ($karya as $row) {
                                    ?>
                                    <!-- Di dalam admin_page.php -->
                        <div class="card-item">
                            <div class="card-content">
                                <img src="../php/<?php echo $row['gambar_karya']; ?>" alt="Gambar Karya" />
                                <h3><?php echo $row['nama_karya']; ?></h3>
                                <p>NIM: <?php echo $row['nim_mhs']; ?></p>
                                <p>Deskripsi: <?php echo $row['desc_karya']; ?></p>
                                <p>Tahun Rilis: <?php echo $row['tahun_rilis']; ?></p>
                                <p>ID Kategori: <?php echo $row['id_kategori']; ?></p>
                            </div>
                            <div class="card-actions">
                                <div class="button-group">
                                    <a href="edit_karya.php?id_karya=<?php echo $row['id_karya']; ?>" class="edit-btn">
                                        <button type="button">Edit</button>
                                    </a>
                                    <!-- Perbaikan pada form delete -->
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" style="display: inline;">
                                        <input type="hidden" name="id_karya" value="<?php echo $row['id_karya']; ?>">
                                        <button type="submit" name="delete" class="delete-btn" onclick="return confirm('Apakah kamu yakin ingin menghapus karya ini?')">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                                    <?php
                                }
                            } else {
                                echo '<p>Tidak ada proyek ditemukan.</p>';
                            }
                            ?>
                        </div>

</html>