<?php
// config.php
session_start();

// Database connection
$conn = mysqli_connect("localhost", "username", "password", "sikarya_db");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Authentication middleware
function checkAuth() {
    if (!isset($_SESSION['admin_id'])) {
        header("Location: login/login.html");
        exit();
    }
}

// Function to get karya data
function getKaryaData($conn) {
    $query = "SELECT * FROM karya 
              JOIN kategori ON karya.id_kategori = kategori.id_kategori 
              JOIN mahasiswa ON karya.nim_mhs = mahasiswa.nim";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Function to format karya for display
function formatKaryaForDisplay($karya) {
    return [
        'id' => $karya['id_karya'],
        'title' => $karya['nama_karya'],
        'description' => $karya['desc_karya'],
        'image' => $karya['gambar_karya'],
        'year' => $karya['tahun_rilis'],
        'category' => $karya['nama_kategori'],
        'student_name' => $karya['nama_mhs']
    ];
}
?>