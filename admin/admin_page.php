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
        <li><a href="Biodata.php"><i class="uil uil-user"></i><span class="link-name">Data Mahasiswa</span></a></li>
        <li><a href="admin.php"><i class="uil uil-user"></i><span class="link-name"></span></a></li>
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
                <input type="text" placeholder="Cari di sini..." />
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
                                // API endpoint for getting data
                                $url = "https://raishaapi1.v-project.my.id/api/karya";

                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, $url);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                $response = curl_exec($ch);

                                if (curl_errno($ch)) {
                                    die('Error: ' . curl_error($ch));
                                }
                                curl_close($ch);

                                $data = json_decode($response, true);

                                if (isset($data['success']) && $data['success'] && !empty($data['data'])) {
                                    foreach ($data['data'] as $row) {
                                        $gambar_karya = isset($row['gambar_karya']) && $row['gambar_karya'] ? explode(',', $row['gambar_karya'])[0] : 'default.jpg';
                                ?>
                                        <div class="card-item">
                                            <div class="card-content">
                                                <img src="../uploads/<?php echo $gambar_karya; ?>" alt="Gambar Karya" />
                                                <h3><?php echo htmlspecialchars($row['nama_karya']); ?></h3>
                                                <p>NIM: <?php echo htmlspecialchars($row['nim_mhs']); ?></p>
                                                <p>Deskripsi: <?php echo htmlspecialchars($row['desc_karya']); ?></p>
                                                <p>Tahun Rilis: <?php echo htmlspecialchars($row['tahun_rilis']); ?></p>
                                                <p>ID Kategori: <?php echo htmlspecialchars($row['id_kategori']); ?></p>
                                            </div>
                                            <div class="card-actions">
                                                <div class="button-group">
                                                    <div class="test">
                                                        <a href="edit_karya.php?id_karya=<?php echo htmlspecialchars($row['id_karya']); ?>" class="edit-btn">
                                                            Edit
                                                        </a>
                                                    </div>
                                                    <form action="../php/delete_karya.php" method="POST" style="display: inline;">
                                                        <input type="hidden" name="id_karya" value="<?php echo htmlspecialchars($row['id_karya']); ?>">
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
                        </div>
                    </section>
                </div>
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