<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Karya</title>
    <link rel="stylesheet" href="../css/tes.css">
</head>
<body>
<nav>
        <div class="navbar">
            <i class="bx bx-menu"></i>
            <div class="logo"><a href="index.html">SiKarya</a></div>
            <div class="nav-links">
                <div class="sidebar-logo">
                    <span class="logo-name">SiKarya</span>
                    <i class="bx bx-x"></i>
                </div>
                <ul class="links">
                    <li><a href="../beranda.php">Beranda</a></li>
                    <li><a href="../karya.php">Karya</a></li>
                    <li><a href="login/login.html">Login</a></li>
                </ul>
            </div>
            <div class="search-box">
                <i class="bx bx-search"></i>
                <div class="input-box">
                    <input type="text" placeholder="Search..." />
                </div>
            </div>
        </div>
    </nav>
    <div class="project-container">
        <h1 id="nama_karya"></h1>

        <!-- Slideshow Gambar -->
        <div class="slideshow-container" id="slideshow">
            <!-- Gambar akan dimuat di sini melalui JavaScript -->
        </div>

        <!-- Kontainer untuk Gambar, Deskripsi, dan Biodata Mahasiswa -->
        <div class="layout">
            <div class="description" id="description">
                <h2>Deskripsi</h2>
                <p></p>
            </div>

            <!-- Profil Mahasiswa -->
            <div class="student-profile" id="student-profile">
                <h3>Profil Mahasiswa</h3>
                <img src="" alt="Foto Mahasiswa" id="foto_mahasiswa">
                <h4>Nama Mahasiswa: <span id="mahasiswa_nama"></span></h4>
                <h4>Prodi: <span id="prodi_mahasiswa"></span></h4>
                <h4>Jurusan: <span id="jurusan_mahasiswa"></span></h4>
                <h4>Email: <span id="email_mahasiswa"></span></h4>
            </div>
        </div>
    </div>

    <script>
        // Mengambil ID karya dari URL
        const urlParams = new URLSearchParams(window.location.search);
        const id_karya = urlParams.get('id_karya');

        // Memuat data dari get_detail.php
        fetch(`get_detail.php?id_karya=${id_karya}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                    return;
                }

                // Mengisi elemen HTML dengan data
                document.getElementById('nama_karya').innerText = data.nama_karya;
                document.getElementById('description').querySelector('p').innerText = data.desc_karya;
                document.getElementById('mahasiswa_nama').innerText = data.nama_mhs;
                document.getElementById('prodi_mahasiswa').innerText = data.prodi;
                document.getElementById('jurusan_mahasiswa').innerText = data.jurusan;
                document.getElementById('foto_mahasiswa').src = `../php/uploads1/${data.foto}`;
                document.getElementById('email_mahasiswa').innerText = data.email;
                // Mengatur slideshow gambar
                const slideshow = document.getElementById('slideshow');
                data.gambar_karya.forEach(gambar => {
                    const slide = document.createElement('div');
                    slide.className = 'slides';
                    const img = document.createElement('img');
                    img.src = `../uploads/${gambar.trim()}`;
                    img.alt = data.nama_karya;
                    slide.appendChild(img);
                    slideshow.appendChild(slide);
                });

                // Menampilkan slide pertama
                let slideIndex = 1;
                showSlides(slideIndex);

                function plusSlides(n) {
                    showSlides(slideIndex += n);
                }

                function showSlides(n) {
                    let slides = document.getElementsByClassName("slides");
                    if (n > slides.length) { slideIndex = 1; }
                    if (n < 1) { slideIndex = slides.length; }

                    for (let i = 0; i < slides.length; i++) {
                        slides[i].style.display = "none";
                    }

                    slides[slideIndex - 1].style.display = "block";
                }

                // Menambahkan tombol navigasi
                const prev = document.createElement('a');
                prev.className = 'prev';
                prev.onclick = () => plusSlides(-1);
                prev.innerHTML = '&#10094;';
                slideshow.appendChild(prev);

                const next = document.createElement('a');
                next.className = 'next';
                next.onclick = () => plusSlides(1);
                next.innerHTML = '&#10095;';
                slideshow.appendChild(next);
            })
            .catch(error => console.error('Error fetching data:', error));
    </script>

<footer>
        <div class="main-content">
            <div class="left box">
                <h2>Tentang Kami</h2>
                <div class="content">
                    <p>
                        SIKARYA adalah platform yang didedikasikan untuk menampilkan karya
                        ilmiah dan tugas akhir mahasiswa dari Politeknik Negeri Pontianak.
                        Kami bertujuan untuk memberikan tempat bagi mahasiswa untuk
                        memamerkan hasil kerja mereka.
                    </p>
                    <br />
                    <p>
                        Kami percaya bahwa setiap karya memiliki cerita dan nilai yang
                        harus diapresiasi, dan melalui SIKARYA, kami berharap dapat
                        memberikan pengakuan yang layak bagi setiap karya mahasiswa.
                    </p>
                    <div class="social">
                        <a href="https://facebook.com/coding.np"><span class="fab fa-facebook-f"></span></a>
                        <a href="#"><span class="fab fa-twitter"></span></a>
                        <a href="https://instagram.com/coding.np"><span class="fab fa-instagram"></span></a>
                        <a href="https://youtube.com/c/codingnepal"><span class="fab fa-youtube"></span></a>
                    </div>
                </div>
            </div>

            <div class="center box">
                <h2>Alamat</h2>
                <div class="content">
                    <div class="place">
                        <span class="fas fa-map-marker-alt"></span>
                        <span class="text">Kalimantan Barat, Pontianak</span>
                    </div>
                    <div class="phone">
                        <span class="fas fa-phone-alt"></span>
                        <span class="text">+089-765432100</span>
                    </div>
                    <div class="email">
                        <span class="fas fa-envelope"></span>
                        <span class="text">Polnep@gmail.com</span>
                    </div>
                </div>
            </div>

            <div class="right box">
                <h2>Hubungi Kami</h2>
                <div class="content">
                    <form action="#">
                        <div class="email">
                            <div class="text">Email *</div>
                            <input type="email" required />
                        </div>
                        <div class="msg">
                            <div class="text">Message *</div>
                            <textarea rows="2" cols="25" required></textarea>
                        </div>
                        <div class="btn">
                            <button type="submit">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="bottom">
            <center>
                <span class="credit">Created By <a href="#">POLNEP</a> | </span>
                <span class="far fa-copyright"></span><span> 2024 All rights reserved.</span>
            </center>
        </div>
    </footer>
</body>
</html>
