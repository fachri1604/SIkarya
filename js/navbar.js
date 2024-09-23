// search-box open close js code
let navbar = document.querySelector(".navbar");
let searchBox = document.querySelector(".search-box .bx-search");

if (searchBox) {
  searchBox.addEventListener("click", () => {
    navbar.classList.toggle("showInput");
    if (navbar.classList.contains("showInput")) {
      searchBox.classList.replace("bx-search", "bx-x");
    } else {
      searchBox.classList.replace("bx-x", "bx-search");
    }
  });
}

// sidebar open close js code
let navLinks = document.querySelector(".nav-links");
let menuOpenBtn = document.querySelector(".navbar .bx-menu");
let menuCloseBtn = document.querySelector(".nav-links .bx-x");

if (menuOpenBtn) {
  menuOpenBtn.addEventListener("click", () => {
    navLinks.style.left = "0";
  });
}

if (menuCloseBtn) {
  menuCloseBtn.addEventListener("click", () => {
    navLinks.style.left = "-100%";
  });
}

// sidebar submenu open close js code
let htmlcssArrow = document.querySelector(".htmlcss-arrow");
if (htmlcssArrow) {
  htmlcssArrow.addEventListener("click", () => {
    navLinks.classList.toggle("show1");
  });
}

let moreArrow = document.querySelector(".more-arrow");
if (moreArrow) {
  moreArrow.addEventListener("click", () => {
    navLinks.classList.toggle("show2");
  });
}

let jsArrow = document.querySelector(".js-arrow");
if (jsArrow) {
  jsArrow.addEventListener("click", () => {
    navLinks.classList.toggle("show3");
  });
}
