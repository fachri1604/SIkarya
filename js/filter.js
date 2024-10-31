function applyFilters() {
  const kategori = document.getElementById('categoryFilter').value;
  const year = document.getElementById('yearFilter').value;
  const url = `karya.php?kategori=${kategori}&year=${year}`;
  window.location.href = url;
}
document.addEventListener('DOMContentLoaded', function () {
  const searchBox = document.getElementById('searchBox');
  const inputBox = document.getElementById('inputBox');
  const searchInput = document.getElementById('searchInput');

  // Tampilkan input box saat search box diklik
  searchBox.addEventListener('click', function () {
      inputBox.style.display = 'block'; // Tampilkan input box
      searchInput.focus(); // Fokus pada input box
  });

  // Sembunyikan input box saat mengklik di luar
  document.addEventListener('click', function (event) {
      if (!searchBox.contains(event.target) && !inputBox.contains(event.target)) {
          inputBox.style.display = 'none'; // Sembunyikan input box
      }
  });
});
