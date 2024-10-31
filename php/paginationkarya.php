<?php
include 'koneksi.php'; // Connect to your database

$limit = 4; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$offset = ($page - 1) * $limit; // Calculate offset

// Get category and year filters from the URL
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$year = isset($_GET['year']) ? $_GET['year'] : '';

// Construct the SQL query
$sql = "SELECT id_karya, nama_karya, gambar_karya, tahun_rilis FROM karya";

// Add conditions if filters are applied
$conditions = [];
if (!empty($kategori)) {
    $conditions[] = "id_kategori = '$kategori'";
}
if (!empty($year)) {
    $conditions[] = "tahun_rilis = '$year'";
}

// Combine conditions if any
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

// Count total records for pagination
$sql_total = "SELECT COUNT(*) as total FROM karya" . (!empty($conditions) ? " WHERE " . implode(" AND ", $conditions) : "");
$result_total = $conn->query($sql_total);
$total_records = $result_total->fetch_assoc()['total'];
$total_pages = ceil($total_records / $limit);

// Fetch records for the current page
$sql .= " ORDER BY tahun_rilis DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// Display records
if ($result->num_rows > 0) {
    echo "<div class='card-list'>";
    while ($row = $result->fetch_assoc()) {
        $gambar_karya = explode(',', $row['gambar_karya'])[0];
        echo "<a href='detail/detail.php?id_karya=" . $row['id_karya'] . "' class='card-item'>";
        echo "<img src='uploads/" . $gambar_karya . "' alt='Card Image' />";
        echo "<h3>" . $row['nama_karya'] . "</h3>";
        echo "<p>Tahun Rilis: " . $row['tahun_rilis'] . "</p>";
        echo "<div class='arrow'><i class='fas fa-arrow-right card-icon'></i></div>";
        echo "</a>";
    }
    echo "</div>"; // Close card-list
} else {
    echo "<p>Tidak ada data karya yang ditemukan.</p>";
}

// Generate pagination links
echo "<div class='pagination' style='text-align: right;'>";
if ($total_pages > 5) {
    if ($page > 1) {
        echo "<a href='karya.php?page=1&kategori=$kategori&year=$year'>&lt;&lt;</a> "; // First page link
        echo "<a href='karya.php?page=" . ($page - 1) . "&kategori=$kategori&year=$year'>&lt;</a> "; // Previous page link
    }
}

for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++) {
    if ($i == $page) {
        echo "<strong>$i</strong> "; // Current page
    } else {
        echo "<a href='karya.php?page=$i&kategori=$kategori&year=$year'>$i</a> "; // Other pages
    }
}

if ($total_pages > 5) {
    if ($page < $total_pages) {
        echo "<a href='karya.php?page=" . ($page + 1) . "&kategori=$kategori&year=$year'>&gt;</a> "; // Next page link
        echo "<a href='karya.php?page=$total_pages&kategori=$kategori&year=$year'>&gt;&gt;</a>"; // Last page link
    }
}
echo "</div>";

$conn->close();
