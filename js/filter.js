// Tangkap elemen-elemen penting
const searchForm = document.getElementById('searchForm');
const searchInput = document.getElementById('searchInput');
const yearFilter = document.getElementById('yearFilter');
const typeFilter = document.getElementById('typeFilter');
const cards = document.querySelectorAll('.card-item');

// Event listener ketika form disubmit
searchForm.addEventListener('submit', function (event) {
  event.preventDefault();
  applyFilters();
});

// Fungsi untuk melakukan filtering
function applyFilters() {
  const searchText = searchInput.value.toLowerCase();
  const selectedYear = yearFilter.value;
  const selectedType = typeFilter.value;

  cards.forEach((card) => {
    const cardTitle = card.querySelector('h3').textContent.toLowerCase();
    const cardYear = card.getAttribute('data-year');
    const cardType = card.getAttribute('data-type');

    // Cek apakah card memenuhi semua kondisi filter
    const matchesSearch = cardTitle.includes(searchText);
    const matchesYear = selectedYear === '' || cardYear === selectedYear;
    const matchesType = selectedType === '' || cardType === selectedType;

    // Jika memenuhi semua filter, tampilkan card, jika tidak sembunyikan
    if (matchesSearch && matchesYear && matchesType) {
      card.style.display = 'block';
    } else {
      card.style.display = 'none';
    }
  });
}
