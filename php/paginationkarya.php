<?php
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

if (isset($data['success']) && $data['success']) {
    $total_rows = count($data['data']);
    $rows_per_page = 8;
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $total_pages = ceil($total_rows / $rows_per_page);

    $offset = ($current_page - 1) * $rows_per_page;
    $displayed_rows = array_slice($data['data'], $offset, $rows_per_page);

    echo "<div class='card-list'>";
    foreach ($displayed_rows as $row) {
        $gambar_karya = isset($row['gambar_karya']) && $row['gambar_karya'] ? explode(',', $row['gambar_karya'])[0] : 'default.jpg';
        echo "<a href='detail/detail.php?id_karya=" . $row['id_karya'] . "' class='card-item'>";
        echo "<img src='uploads/" . htmlspecialchars($gambar_karya) . "' alt='Card Image' />";
        echo "<h3>" . htmlspecialchars($row['nama_karya']) . "</h3>";
        echo "<p>Tahun Rilis: " . htmlspecialchars($row['tahun_rilis']) . "</p>";
        echo "<div class='arrow'><i class='fas fa-arrow-right card-icon'></i></div>";
        echo "</a>";
    }
    echo "</div>";

    echo "<div class='pagination' style='text-align: right;'>";
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<a href='karya.php?page=$i" . (isset($_GET['kategori']) ? "&kategori=" . $_GET['kategori'] : "") . (isset($_GET['year']) ? "&year=" . $_GET['year'] : "") . "' class='" . ($i == $current_page ? 'active' : '') . "'>$i</a>";
    }
    echo "</div>";
} else {
    echo "<p>Tidak ada data karya yang ditemukan.</p>";
}
?>