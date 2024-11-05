<?php
// Ambil NIM dari query parameter
$username = $_GET['username'] ?? null;

if ($username) {
    // Menginisialisasi cURL untuk mengambil data biodata dari API
    $ch = curl_init('http://127.0.0.1:8000/api/users/' . $username);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Mengirim permintaan
    $response = curl_exec($ch);

    // Menangani kesalahan cURL
    if (curl_errno($ch)) {
        header("Location: admin.php?status=error&message=" . urlencode('Request failed: ' . curl_error($ch)));
        exit();
    }

    // Menutup cURL
    curl_close($ch);

    // Menangani respons dari API
    $dataAdmin = json_decode($response, true);
    if (!$dataAdmin || !isset($dataAdmin['data'])) {
        header("Location: admin.php?status=error&message=Data tidak ditemukan");
        exit();
    }

    // Mendapatkan data biodata
    $row = $dataAdmin['data'];
} else {
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/admin.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <title>Edit Biodata - Admin</title>
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
                <li>
                    <a href="admin_page.php"><i class="uil uil-estate"></i><span class="link-name">Karya</span></a>
                </li>
                <li>
                    <a href="content.php"><i class="uil uil-plus-circle"></i><span class="link-name">Tambah Karya</span></a>
                </li>
                <li>
                    <a href="Biodata.php"><i class="uil uil-user"></i><span class="link-name">Biodata Mahasiswa</span></a>
                </li>
                <li>
                    <a href="admin.php"><i class="uil uil-user"></i><span class="link-name">Admin Desk</span></a>
                </li>
            </ul>
            <ul class="logout-mode">
                <li>
                    <a href="../login/login.php"><i class="uil uil-signout"></i><span class="link-name">Logout</span></a>
                </li>
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            <img src="images/profile.jpg" alt="" />
        </div>
        <div class="dash-content">
            <div class="overview"></div>
            <div class="project-form">
                <h2>Edit Biodata</h2>
                <form id="biodataForm" action="put_admin.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="username" value="<?php echo htmlspecialchars($row['username']); ?>" />

    <label for="email">Email:</label>
    <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required />
    <label for="password">Password:</label>
    <input type="text" id="password" name="password" value="<?php echo htmlspecialchars($row['password']); ?>" required />
    <button type="submit">Update UserAdmin</button>
</form>

            </div>
        </div>
    </section>
</body>

</html>