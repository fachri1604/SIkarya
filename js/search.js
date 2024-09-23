// document.addEventListener("DOMContentLoaded", function () {
//   const searchInput = document.getElementById("searchInput");
//   const searchResults = document.getElementById("searchResults");
//   const cardItems = document.querySelectorAll(".card-item");

//   searchInput.addEventListener("input", function () {
//     const query = searchInput.value.toLowerCase();
//     searchResults.innerHTML = "";

//     if (query) {
//       let matches = 0;
//       cardItems.forEach(function (item) {
//         const title = item.querySelector("h3").innerText.toLowerCase();

//         if (title.includes(query)) {
//           const listItem = document.createElement("li");
//           listItem.textContent = title;
//           listItem.onclick = function () {
//             window.location.href = item.href;
//           };
//           searchResults.appendChild(listItem);
//           matches++;
//         }
//       });

//       if (matches === 0) {
//         searchResults.innerHTML = "<li>No results found</li>";
//       }
//     }
//   });
// });

document.getElementById('searchForm').addEventListener('submit', function (event) {
  event.preventDefault();

  // Get search term and filter values
  const searchTerm = document.getElementById('searchInput').value.toLowerCase();
  const yearFilter = document.getElementById('yearFilter').value;
  const typeFilter = document.getElementById('typeFilter').value;

  // Filter results
  filterResults(searchTerm, yearFilter, typeFilter);
});

function filterResults(searchTerm, year, type) {
  const resultsContainer = document.getElementById('resultsContainer');
  const allCards = document.querySelectorAll('.card-item');

  allCards.forEach((card) => {
    // Get data attributes from each card
    const cardTitle = card.querySelector('h3').textContent.toLowerCase();
    const cardYear = card.getAttribute('data-year');
    const cardType = card.getAttribute('data-type');

    // Check if the card matches the filters
    const matchesSearch = searchTerm === '' || cardTitle.includes(searchTerm);
    const matchesYear = year === '' || cardYear === year;
    const matchesType = type === '' || cardType === type;

    // Show or hide the card based on the filter match
    if (matchesSearch && matchesYear && matchesType) {
      card.style.display = 'block';
    } else {
      card.style.display = 'none';
    }
  });
}
