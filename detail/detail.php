<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Karya</title>
    <link rel="stylesheet" href="../css/tes.css">
</head>

<body>
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
                    <li><a href="../beranda.php">Beranda</a></li>
                    <li><a href="../karya.php">Karya</a></li>
                    <li><a href="../login/login.php">Login</a></li>
                </ul>
            </div>
            <div class="search-box">
                <i class="bx bx-search"></i>
                <div class="input-box">
                    <input type="text" placeholder="Search..." />
                </div>
            </div>
        </div>
    </nav>
    <?php
    $id = $_GET['id_karya'] ?? null; // Use null as a fallback

    if ($id) {
        // Initialize cURL
        $url = "https://raishaapi1.v-project.my.id/api/karya/$id";
        $ch = curl_init($url);

        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        // Execute cURL request
        $response = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response
        $data = json_decode($response, true);

        // Initialize empty variables for cases where data may not be present
        $karya = $biodata = [];
        $gambar_karya = null;

        // Check if data was successfully retrieved
        if ($data && isset($data['success']) && $data['success']) {
            $karya = $data['data'] ?? [];
            $biodata = $karya['biodata'] ?? [];
            $gambar_karya = $karya['gambar_karya'] ?? [];
        } else {
            echo "<p>Error: Unable to fetch data or data is missing.</p>";
        }
    } else {
        echo "<p>Error: No ID provided.</p>";
        $karya = $biodata = [];
        $gambar_karya = null;
    }
    ?>


    <div class="project-container">
        <h1 id="nama_karya"><?php echo htmlspecialchars($karya['nama_karya'] ?? ''); ?></h1>

        <div class="slideshow-container" id="slideshow">
            <?php if ($gambar_karya): ?>
                <?php foreach ($gambar_karya as $gambar): ?>
                    <div class="slides">
                        <img src="../uploads/<?php echo htmlspecialchars(trim($gambar)); ?>" alt="<?php echo htmlspecialchars($karya['nama_karya']); ?>">
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No images available for this project.</p>
            <?php endif; ?>
        </div>

        <div class="layout">
            <div class="description" id="description">
                <h2>Deskripsi</h2>
                <p><?php echo htmlspecialchars($karya['desc_karya'] ?? ''); ?></p>
            </div>

            <div class="student-profile" id="student-profile">
                <h3>Profil Mahasiswa</h3>
                <img src="<?php echo $biodata['foto'] ? "../php/uploads1/{$biodata['foto']}" : '../assets/default-profile.png'; ?>" alt="Foto Mahasiswa" style="width: 150px; height: auto;">
                <h4>Nama Mahasiswa: <span><?php echo htmlspecialchars($biodata['nama_mhs'] ?? ''); ?></span></h4>
                <h4>Prodi: <span><?php echo htmlspecialchars($biodata['prodi'] ?? ''); ?></span></h4>
                <h4>Jurusan: <span><?php echo htmlspecialchars($biodata['jurusan'] ?? ''); ?></span></h4>
                <h4>Email: <span><?php echo htmlspecialchars($biodata['email'] ?? ''); ?></span></h4>
                <h4>Tahun Rilis: <span><?php echo htmlspecialchars($karya['tahun_rilis'] ?? ''); ?></span></h4>
            </div>
        </div>
    </div>

    <script>
        // JavaScript to handle slideshow functionality
        let slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function showSlides(n) {
            let slides = document.getElementsByClassName("slides");
            if (n > slides.length) slideIndex = 1;
            if (n < 1) slideIndex = slides.length;
            Array.from(slides).forEach(slide => slide.style.display = "none");
            slides[slideIndex - 1].style.display = "block";
        }
    </script>

    <footer>
        <!-- Your footer content here -->
    </footer>
</body>

</html>