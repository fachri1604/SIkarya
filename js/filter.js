function applyFilters() {
  const kategori = document.getElementById('categoryFilter').value;
  const year = document.getElementById('yearFilter').value;
  const url = `karya.php?kategori=${kategori}&year=${year}`;
  window.location.href = url;
}
