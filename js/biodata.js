document.getElementById('projectForm').addEventListener('submit', function (e) {
  e.preventDefault(); // Mencegah reload halaman

  // Ambil nilai dari form
  const nim = document.getElementById('nim').value;
  const namaLengkap = document.getElementById('nama').value;
  const prodi = document.getElementById('prodi').value;
  const jurusan = document.getElementById('jurusan').value;
  const email = document.getElementById('email').value;
  const phone = document.getElementById('nomor').value;

  // Validasi input: pastikan semua field diisi
  if (!nim || !namaLengkap || !prodi || !jurusan || !email || !phone) {
    alert('Semua field harus diisi!');
    return;
  }

  // Dapatkan tabel dan tambahkan baris baru
  const table = document.getElementById('dataTable').getElementsByTagName('tbody')[0];
  const newRow = table.insertRow();

  // Tambahkan data ke kolom tabel
  const nimCell = newRow.insertCell(0);
  const namaLengkapCell = newRow.insertCell(1);
  const prodiCell = newRow.insertCell(2);
  const jurusanCell = newRow.insertCell(3);
  const emailCell = newRow.insertCell(4);
  const phoneCell = newRow.insertCell(5);

  nimCell.innerText = nim;
  namaLengkapCell.innerText = namaLengkap;
  prodiCell.innerText = prodi;
  jurusanCell.innerText = jurusan;
  emailCell.innerText = email;
  phoneCell.innerText = phone;

  // Reset form setelah submit
  document.getElementById('projectForm').reset();
});
