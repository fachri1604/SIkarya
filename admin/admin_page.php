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
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        <div class="top">
            <div class="search-box">
                <i class="uil uil-search"></i>
                <form action="admin_page.php" method="GET" class="search-form">
                    <input type="text" name="search" placeholder="Cari di sini..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
                </form>
            </div>
            <img src="images/profile.jpg" alt="" />
        </div>

        <!-- Filter Section -->
        <section class="content-container">
            <div class="konten2" id="karya">
                <label for="categoryFilter">Kategori:</label>
                <select id="categoryFilter" name="categoryFilter" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    <option value="1">PBL</option>
                    <option value="2">Tugas Akhir</option>
                    <option value="3">Final Project</option>
                </select>

                <label for="yearFilter">Tahun Rilis:</label>
                <select id="yearFilter" name="yearFilter" onchange="this.form.submit()">
                    <option value="">Semua Tahun</option>
                    <?php
                    $currentYear = date("Y");
                    for ($year = $currentYear; $year >= 2020; $year--) {
                        echo "<option value='$year'>$year</option>";
                    }
                    ?>
                </select>

                <button onclick="applyFilters()">Filter</button>

                <div class="content">
                    <section class="karya-container">
                        <div class="konten">
                            <h2>Galeri Karya Mahasiswa</h2>
                            <div class="card-list">
                                <?php
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
                                        $gambar_karya_array = explode(',', $row['gambar_karya']);
                                        foreach ($gambar_karya_array as $gambar) {
                                            $file_path = '../uploads/' . $gambar;
                                            if (file_exists($file_path)) {
                                                unlink($file_path);
                                            }
                                        }
                                    }

                                    // Hapus record dari database
                                    $query = "DELETE FROM karya WHERE id_karya = '$id_karya'";
                                    if (mysqli_query($conn, $query)) {
                                        header("Location: " . $_SERVER['PHP_SELF'] . "?status=success&message=Data berhasil dihapus");
                                        exit();
                                    } else {
                                        header("Location: " . $_SERVER['PHP_SELF'] . "?status=error&message=Gagal menghapus data");
                                        exit();
                                    }
                                }

                                // Pagination Logic
                                $limit = 4; // Number of entries per page
                                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                $offset = ($page - 1) * $limit;

                                // Get total entries
                                $total_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM karya");
                                $total_row = mysqli_fetch_assoc($total_result);
                                $total = $total_row['total'];
                                $pages = ceil($total / $limit); // Calculate total pages

                                // Fetch data for the current page
                                $sql = "SELECT * FROM karya LIMIT $limit OFFSET $offset";
                                if (isset($_GET['search'])) {
                                    $search = mysqli_real_escape_string($conn, $_GET['search']);
                                    $sql = "SELECT * FROM karya WHERE nama_karya LIKE '%$search%' LIMIT $limit OFFSET $offset";
                                }
                                $result = $conn->query($sql);
                                $karya = [];
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $karya[] = $row;
                                    }
                                }
                                ?>
                                <div class="container-card">
                                    <div class="card-list">
                                        <?php
                                        if (!empty($karya)) {
                                            foreach ($karya as $row) {
                                                $gambar_karya_array = explode(',', $row['gambar_karya']);
                                                $gambar_pertama = $gambar_karya_array[0]; // Ambil gambar pertama
                                        ?>
                                                <div class="card-item">
                                                    <div class="card-content">
                                                        <img src="../uploads/<?php echo $gambar_pertama; ?>" alt="Gambar Karya" />
                                                        <h3><?php echo $row['nama_karya']; ?></h3>
                                                        <p>NIM: <?php echo $row['nim_mhs']; ?></p>
                                                        <p>Deskripsi: <?php echo $row['desc_karya']; ?></p>
                                                        <p>Tahun Rilis: <?php echo $row['tahun_rilis']; ?></p>
                                                        <p>ID Kategori: <?php echo $row['id_kategori']; ?></p>
                                                    </div>
                                                    <div class="card-actions">
                                                        <div class="button-group">
                                                            <div class="test">
                                                                <a href="edit_karya.php?id_karya=<?php echo $row['id_karya']; ?>" class="edit-btn">
                                                                    Edit
                                                                </a>
                                                            </div>
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

                                    <!-- Pagination Links -->
                                    <div class="pagination-container">
                                        <div class="pagination">
                                            <?php if ($pages > 1): ?>
                                                <?php for ($i = 1; $i <= $pages; $i++): ?>
                                                    <a href="?page=<?php echo $i; ?>" class="<?php echo $i === $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
                                                <?php endfor; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </section>
                </div>
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
