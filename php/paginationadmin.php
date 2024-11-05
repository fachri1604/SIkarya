<?php
// Mendapatkan parameter filter dari URL
$id_kategori = isset($_GET['id_kategori']) ? $_GET['id_kategori'] : '';
$tahun_rilis = isset($_GET['tahun_rilis']) ? $_GET['tahun_rilis'] : '';
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$rows_per_page = 8; // Jumlah karya per halaman

// Inisialisasi URL untuk permintaan API
$url = "https://raishaapi1.v-project.my.id/api/karya";

// Menyusun parameter query untuk filter
$query_params = [];
if ($id_kategori) {
    $query_params['id_kategori'] = $id_kategori;
}
if ($tahun_rilis) {
    $query_params['tahun_rilis'] = $tahun_rilis;
}

// Tambahkan parameter filter ke URL jika ada
if (!empty($query_params)) {
    $url .= '?' . http_build_query($query_params);
}

// Membuat permintaan ke API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

if (curl_errno($ch)) {
    die('Error: ' . curl_error($ch));
}
curl_close($ch);

// Mengubah respons API menjadi array
$data = json_decode($response, true);

if (isset($data['success']) && $data['success']) {
    // Filter data hasil API berdasarkan kategori dan tahun rilis
    $filtered_data = array_filter($data['data'], function ($row) use ($id_kategori, $tahun_rilis) {
        $match_kategori = !$id_kategori || $row['id_kategori'] == $id_kategori;
        $match_tahun = !$tahun_rilis || $row['tahun_rilis'] == $tahun_rilis;
        return $match_kategori && $match_tahun;
    });

    $total_rows = count($filtered_data);
    $total_pages = ceil($total_rows / $rows_per_page);
    $offset = ($current_page - 1) * $rows_per_page;

    // Mengambil karya yang akan ditampilkan berdasarkan pagination
    $displayed_rows = array_slice($filtered_data, $offset, $rows_per_page);

    echo "<div class='card-list'>";
    foreach ($displayed_rows as $row) {
        $gambar_karya = $row['gambar_karya']; // Assuming this is the correct key for image path
        echo "<div class='card-item'>
                <div class='card-content'>
                    <img src='../uploads/" . htmlspecialchars($gambar_karya) . "' alt='Gambar Karya' />
                    <h3>" . htmlspecialchars($row['nama_karya']) . "</h3>
                    <p>NIM: " . htmlspecialchars($row['nim_mhs']) . "</p>
                    <p>Deskripsi: " . htmlspecialchars($row['desc_karya']) . "</p>
                    <p>Tahun Rilis: " . htmlspecialchars($row['tahun_rilis']) . "</p>
                    <p>ID Kategori: " . htmlspecialchars($row['id_kategori']) . "</p>
                </div>
                <div class='card-actions'>
                    <div class='button-group'>
                        <a href='edit_karya.php?id_karya=" . htmlspecialchars($row['id_karya']) . "' class='edit-btn'>Edit</a>
                        <form action='../php/delete_karya.php' method='POST' style='display: inline;'>
                            <input type='hidden' name='id_karya' value='" . htmlspecialchars($row['id_karya']) . "'>
                            <button type='submit' name='delete' class='delete-btn' onclick=\"return confirm('Apakah kamu yakin ingin menghapus karya ini?')\">Hapus</button>
                        </form>
                    </div>
                </div>
              </div>";
    }
    echo "</div>";

    // Membuat tautan pagination
    echo "<div class='pagination' style='text-align: right;'>";
    for ($i = 1; $i <= $total_pages; $i++) {
        // Menyertakan filter dalam tautan pagination
        $link = 'admin_page.php?page=' . $i;
        if ($id_kategori) {
            $link .= '&id_kategori=' . urlencode($id_kategori);
        }
        if ($tahun_rilis) {
            $link .= '&tahun_rilis=' . urlencode($tahun_rilis);
        }
        echo "<a href='$link' class='" . ($i == $current_page ? 'active' : '') . "'>$i</a>";
    }
    echo "</div>";
} else {
    echo "<p>Tidak ada data karya yang ditemukan.</p>";
}
