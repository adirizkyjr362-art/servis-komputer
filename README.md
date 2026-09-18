# Sistem Pemesanan dan Pelacakan Servis Komputer

Aplikasi web untuk pengelolaan dan pelacakan data servis komputer pada CV Megabit Rizki Abadi.

## Teknologi
- PHP
- MySQL / MariaDB
- HTML5 dan CSS3
- Bootstrap 5
- JavaScript
- Simple DataTables
- SweetAlert2

## Fitur Utama
- Login admin
- Dashboard jumlah servis
- Tambah data servis
- Daftar dan detail servis
- Perubahan status servis
- Pelacakan servis berdasarkan kode servis
- Notifikasi proses berhasil atau gagal

## JavaScript `admin/js/servis.js`

File ini digunakan pada halaman admin yang berkaitan dengan data servis.

### Array of Objects
Data yang sudah tampil pada tabel daftar servis dibaca oleh JavaScript dan disimpan dalam Array of Objects. Data yang disimpan terdiri dari kode servis, nama pelanggan, dan status.

Contoh struktur:

```javascript
const dataServis = [];
dataServis.push({
    kode: "S001",
    pelanggan: "Budi",
    status: "Proses"
});
```

Array digunakan sebagai struktur data untuk membaca dan mengolah data di sisi JavaScript. Database MySQL tetap menjadi tempat penyimpanan utama.

### Validasi Form
JavaScript memeriksa nama pelanggan dan keluhan sebelum form tambah servis dikirim ke server.

### DataTables
Simple DataTables digunakan pada tabel daftar servis untuk membantu pencarian, pengurutan, dan pembagian halaman.

### Debugging
`console.log()` digunakan untuk melihat isi Array of Objects melalui Developer Tools pada browser.

## Struktur Direktori

```text
daa/
├── admin/
│   ├── css/
│   ├── js/
│   │   ├── scripts.js
│   │   └── servis.js
│   ├── partials/
│   ├── index.php
│   ├── tambah_servis.php
│   ├── daftar_servis.php
│   ├── servis_detail.php
│   ├── proses_servis.php
│   └── logout.php
├── assets/
│   ├── css/
│   ├── img/
│   └── js/
├── config/
├── index.php
├── lacak.php
└── proses_login.php
```

## Menjalankan Aplikasi
1. Install XAMPP.
2. Aktifkan Apache dan MySQL.
3. Salin folder `daa` ke `htdocs`.
4. Buat/import database sesuai konfigurasi `config/koneksi.php`.
5. Buka aplikasi melalui `http://localhost/daa/`.

## Catatan
Data servis utama disimpan di MySQL. Array of Objects pada `servis.js` hanya digunakan untuk struktur dan pengolahan data di JavaScript, bukan sebagai pengganti database.
