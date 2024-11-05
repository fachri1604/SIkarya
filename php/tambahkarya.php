<?php
$url = "https://raishaapi1.v-project.my.id/api/karya";

$nama_karya = $_POST['nama_karya'];
$nim_mhs = $_POST['nim_mhs']; // NIM diambil dari form karya
$desc_karya = $_POST['desc_karya'];
$tahun_rilis = $_POST['tahun_rilis'];
$id_kategori = $_POST['id_kategori'];


$data = [
  "nama_karya" => $nama_karya,
  "nim_mhs" => $nim_mhs,
  "desc_karya" => $desc_karya,
  "tahun_rilis" => $tahun_rilis,
  "id_kategori" => $id_kategori,
  "gambar_karya" => null
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);

curl_setopt($ch, CURLOPT_POST, true);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
  'Content-Type: application/json',
]);

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if (curl_errno($ch)) {
  die('Curl error: ' . curl_error($ch));
}

curl_close($ch);

$responseData = json_decode($response, true);

if (isset($responseData['success']) && $responseData['success']) {
  echo "Tamabh Karya berhasil baru ditambahkan.\n";
  echo "<script>alert('$action_message'); window.location.href='../admin/content.php';</script>";
} else {
  echo "Error : " . json_encode($responseData) . "\n";
}
