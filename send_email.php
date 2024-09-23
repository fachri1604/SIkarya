<?php
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $to = "yossacoc10@gmail.com";  // Alamat email tujuan
    $subject = "Pesan dari SIKARYA";  // Judul email
    $email = $_POST['email'];
    $message = $_POST['message'];
    
    // Mempersiapkan isi email
    $body = "Email: $email\n\nPesan:\n$message";
    
    // Mengirim email
    if(mail($to, $subject, $body)) {
      echo "Pesan berhasil dikirim!";
    } else {
      echo "Pesan gagal dikirim.";
    }
  }
?>
