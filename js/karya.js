function editData() {
    // Mengarahkan ke halaman PHP untuk update data
    document.getElementById('projectForm').action = '../php/editbio.php';
    document.getElementById('projectForm').submit();
  }
  
  function deleteData() {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
      // Mengarahkan ke halaman PHP untuk hapus data
      document.getElementById('projectForm').action = '../php/hapusbio.php';
      document.getElementById('projectForm').submit();
    }
  }
  