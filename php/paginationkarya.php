<?php
// Get filter parameters from the URL
$id_kategori = isset($_GET['id_kategori']) ? $_GET['id_kategori'] : '';
$tahun_rilis = isset($_GET['tahun_rilis']) ? $_GET['tahun_rilis'] : '';

$url = "https://raishaapi1.v-project.my.id/api/karya";

// Optionally, add filters to the API request if the API supports filtering
if ($id_kategori || $tahun_rilis) {
    $url .= "?";
    if ($id_kategori) {
        $url .= "id_kategori=" . urlencode($id_kategori);
    }
    if ($tahun_rilis) {
        if ($id_kategori) {
            $url .= "&";
        }
        $url .= "tahun_rilis=" . urlencode($tahun_rilis);
    }
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

if (curl_errno($ch)) {
    die('Error: ' . curl_error($ch));
}
curl_close($ch);

$data = json_decode($response, true);

if (isset($data['success']) && $data['success']) {
    echo "<div class='card-list'>";

    foreach ($data['data'] as $row) {
        // Check if the current artwork matches the filters
        if (($id_kategori === '' || $row['id_kategori'] == $id_kategori) &&
            ($tahun_rilis === '' || $row['tahun_rilis'] == $tahun_rilis)) {
            
            $gambar_karya = isset($row['gambar_karya']) && $row['gambar_karya'] ? explode(',', $row['gambar_karya'])[0] : 'default.jpg';
            echo "<a href='detail/detail.php?id_karya=" . $row['id_karya'] . "' class='card-item'>";
            echo "<img src='http://raishaapi1.v-project.my.id/storage/uploads/" . htmlspecialchars($gambar_karya) . "' alt='Card Image' />";
            echo "<h3>" . htmlspecialchars($row['nama_karya']) . "</h3>";
            echo "<p>Tahun Rilis: " . htmlspecialchars($row['tahun_rilis']) . "</p>";
            echo "<div class='arrow'><i class='fas fa-arrow-right card-icon'></i></div>";
            echo "</a>";
        }
    }

    echo "</div>"; // Close card-list
} else {
    echo "<p>Tidak ada data karya yang ditemukan.</p>";
}
?>
