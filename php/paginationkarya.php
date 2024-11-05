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
    echo "<div class='card-list'>";

    foreach ($data['data'] as $row) {
        $gambar_karya = isset($row['gambar_karya']) && $row['gambar_karya'] ? explode(',', $row['gambar_karya'])[0] : 'default.jpg';
        echo "<a href='detail/detail.php?id_karya=" . $row['id_karya'] . "' class='card-item'>";
        echo "<img src='uploads/" . htmlspecialchars($gambar_karya) . "' alt='Card Image' />";
        echo "<h3>" . htmlspecialchars($row['nama_karya']) . "</h3>";
        echo "<p>Tahun Rilis: " . htmlspecialchars($row['tahun_rilis']) . "</p>";
        echo "<div class='arrow'><i class='fas fa-arrow-right card-icon'></i></div>";
        echo "</a>";
    }

    echo "</div>"; // Close card-list
} else {
    echo "<p>Tidak ada data karya yang ditemukan.</p>";
}
// Generate pagination links
// echo "<div class='pagination' style='text-align: right;'>";
// if ($total_pages > 5) {
//     if ($page > 1) {
//         echo "<a href='karya.php?page=1&kategori=$kategori&year=$year'>&lt;&lt;</a> "; // First page link
//         echo "<a href='karya.php?page=" . ($page - 1) . "&kategori=$kategori&year=$year'>&lt;</a> "; // Previous page link
//     }
// }

// for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++) {
//     if ($i == $page) {
//         echo "<strong>$i</strong> "; // Current page
//     } else {
//         echo "<a href='karya.php?page=$i&kategori=$kategori&year=$year'>$i</a> "; // Other pages
//     }
// }

// if ($total_pages > 5) {
//     if ($page < $total_pages) {
//         echo "<a href='karya.php?page=" . ($page + 1) . "&kategori=$kategori&year=$year'>&gt;</a> "; // Next page link
//         echo "<a href='karya.php?page=$total_pages&kategori=$kategori&year=$year'>&gt;&gt;</a>"; // Last page link
//     }
// }
// echo "</div>";
