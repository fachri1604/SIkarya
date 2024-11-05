<?php
// content.php
// include '../php/koneksi.php';

// // Tambahkan ini di awal file untuk debugging
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// // Fungsi untuk generate ID baru yang lebih aman
// function generateNewId($conn)
// {
//     // Cek ID terakhir
//     $sql = "SELECT id_karya FROM karya ORDER BY id_karya DESC LIMIT 1";
//     $result = $conn->query($sql);

//     if ($result && $result->num_rows > 0) {
//         $row = $result->fetch_assoc();
//         $lastId = $row['id_karya'];
//         // Ambil angka dari ID terakhir
//         $number = intval(substr($lastId, 1));
//         $newNumber = $number + 1;
//     } else {
//         // Jika belum ada data, mulai dari 1
//         $newNumber = 1;
//     }

//     // Format ID baru dengan padding 3 digit
//     return 'K' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
// }

// // Proses form jika di-submit
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     try {
//         // Generate ID baru
//         $id_karya = generateNewId($conn);

//         // Ambil data dari form
//         $nama_karya = $_POST['nama_karya'];
//         $nim_mhs = $_POST['nim_mhs'];
//         $desc_karya = $_POST['desc_karya'];
//         $tahun_rilis = $_POST['tahun_rilis'];
//         $id_kategori = $_POST['id_kategori'];

//         // Handle upload gambar
//         $gambar_karya = [];
//         if (isset($_FILES['gambar_karya'])) {
//             $target_dir = "../uploads/";
//             if (!file_exists($target_dir)) {
//                 mkdir($target_dir, 0777, true);
//             }

//             foreach ($_FILES['gambar_karya']['tmp_name'] as $key => $tmp_name) {
//                 if ($_FILES['gambar_karya']['error'][$key] == 0) {
//                     $file_extension = pathinfo($_FILES['gambar_karya']['name'][$key], PATHINFO_EXTENSION);
//                     $new_filename = $id_karya . '_' . ($key + 1) . '.' . $file_extension; // Menggunakan nomor urut untuk nama file
//                     $target_file = $target_dir . $new_filename;

//                     if (move_uploaded_file($tmp_name, $target_file)) {
//                         $gambar_karya[] = $new_filename; // Menyimpan nama file gambar
//                     }
//                 }
//             }
//         }

//         // Gabungkan nama gambar menjadi string (jika ingin disimpan sebagai satu string di DB)
//         $gambar_karya_string = implode(',', $gambar_karya);

//         // Insert ke database dengan prepared statement
//         $stmt = $conn->prepare("INSERT INTO karya (id_karya, nama_karya, nim_mhs, desc_karya, tahun_rilis, id_kategori, gambar_karya) VALUES (?, ?, ?, ?, ?, ?, ?)");

//         if (!$stmt) {
//             throw new Exception("Prepare failed: " . $conn->error);
//         }

//         $stmt->bind_param("sssssss", $id_karya, $nama_karya, $nim_mhs, $desc_karya, $tahun_rilis, $id_kategori, $gambar_karya_string);

//         // Eksekusi query
//         if ($stmt->execute()) {
//             echo "<script>
//                     alert('Karya berhasil ditambahkan!');
//                     window.location.href = 'admin_page.php';
//                   </script>";
//         } else {
//             throw new Exception("Error saat menambahkan data: " . $stmt->error);
//         }

//         $stmt->close();
//     } catch (Exception $e) {
//         echo "<script>
//                 alert('Error: " . addslashes($e->getMessage()) . "');
//                 window.history.back();
//               </script>";
//     }
// }
?>

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
                <li>
                    <a href="admin_page.php"><i class="uil uil-estate"></i><span class="link-name">Karya</span></a>
                </li>
                <li>
                    <a href="content.php"><i class="uil uil-plus-circle"></i><span class="link-name">Tambah Karya</span></a>
                </li>
                <li>
                    <a href="Biodata.php"><i class="uil uil-user"></i><span class="link-name">Biodata Mahasiswa</span></a>
                </li>
                <li><a href="admin.php"><i class="uil uil-user"></i><span class="link-name">Admin Desk</span></a></li>
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
            <!-- <i class="uil uil-bars sidebar-toggle"></i> -->
            <img src="images/profile.jpg" alt="" />
        </div>
        <div class="dash-content">
            <div class="overview"></div>
            <div class="project-form">
                <h2>Add/Edit Project</h2>
                <form id="projectForm" action="../php/tambahkarya.php" method="POST" enctype="multipart/form-data">
                    <label for="projectTitle">Judul Karya:</label>
                    <input type="text" id="projectTitle" name="nama_karya" required />

                    <label for="nim">NIM Mahasiswa:</label>
                    <select id="nim" name="nim_mhs" required>
                        <option value="">Pilih NIM</option>
                        <?php
                        // API endpoint for fetching student data
                        $url = "https://raishaapi1.v-project.my.id/api/biodata"; // Adjust this URL to point to your actual API endpoint for students
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $response = curl_exec($ch);

                        if (curl_errno($ch)) {
                            die('Error: ' . curl_error($ch));
                        }
                        curl_close($ch);

                        $data = json_decode($response, true);

                        // Check if the response is successful and has biodata
                        // Check if the response is successful
                        if (isset($data['success']) && $data['success']) {
                            // Loop through the categories and create options
                            foreach ($data['data'] as $row) {
                                echo "<option value='" . htmlspecialchars($row['nim_mhs']) . "'>" . htmlspecialchars($row['nim_mhs']) . " - " . htmlspecialchars($row['nama_mhs']) . "</option>";
                            }
                        } else {
                            echo "<option value=''>Tidak ada data nim</option>";
                        }
                        ?>
                    </select>


                    <label for="projectDescription">Deskripsi Karya:</label>
                    <textarea id="projectDescription" name="desc_karya" required></textarea>

                    <label for="releaseYear">Tahun Rilis:</label>
                    <input type="text" id="releaseYear" name="tahun_rilis" required />

                    <label for="categoryId">ID Kategori:</label>
                    <select id="categoryId" name="id_kategori" required>
                        <option value="">Pilih Kategori</option>
                        <?php
                        // API endpoint for categories
                        $url = "https://raishaapi1.v-project.my.id/api/kategori";
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $response = curl_exec($ch);

                        if (curl_errno($ch)) {
                            die('Error: ' . curl_error($ch));
                        }
                        curl_close($ch);

                        $data = json_decode($response, true);

                        // Check if the response is successful
                        if (isset($data['success']) && $data['success']) {
                            // Loop through the categories and create options
                            foreach ($data['data'] as $row) {
                                echo "<option value='" . htmlspecialchars($row['id_kategori']) . "'>" . htmlspecialchars($row['id_kategori']) . " - " . htmlspecialchars($row['jenis_karya']) . "</option>";
                            }
                        } else {
                            echo "<option value=''>Tidak ada data kategori</option>";
                        }
                        ?>
                    </select>


                    <label for="mainImage">Gambar Karya:</label>
                    <input type="file" id="image" name="image" multiple required />

                    <button type="submit">Save Project</button>
                </form>
            </div>
        </div>
    </section>
</body>

</html>