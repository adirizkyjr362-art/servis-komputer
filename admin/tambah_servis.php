<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require '../config/koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'partials/header.php'; ?>

<body class="sb-nav-fixed">

    <?php include 'partials/navbar.php'; ?>

    <div id="layoutSidenav">

        <div id="layoutSidenav_nav">
            <?php include 'partials/sidebar.php'; ?>
        </div>

        <div id="layoutSidenav_content">

            <main>

                <div class="container-fluid px-4">

                    <h1 class="mt-4">Servis Masuk</h1>

                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item">
                            <a href="index.php">Dashboard</a>
                        </li>

                        <li class="breadcrumb-item active">
                            Servis
                        </li>
                    </ol>
                    <form
                        action="proses_servis.php"
                        method="POST"
                        class="row g-3"
                        novalidate
                    >
                        <div class="card mb-4">

                            <div class="card-header">
                                <h5>Data Pelanggan</h5>
                            </div>

                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6">

                                        <label
                                            for="nama_pelanggan"
                                            class="form-label"
                                        >
                                            Nama Pelanggan
                                        </label>
                                        <input
                                            type="text"
                                            name="nama_pelanggan"
                                            id="nama_pelanggan"
                                            class="form-control"
                                            placeholder="Masukkan nama pelanggan"
                                            required
                                        >
                                    </div>
                                    <div class="col-md-6">
                                        <label
                                            for="no_hp"
                                            class="form-label"
                                        >
                                            No HP
                                        </label>
                                        <input
                                            type="tel"
                                            name="no_hp"
                                            id="no_hp"
                                            class="form-control"
                                            placeholder="Contoh: 08123456789"
                                            required
                                        >
                                    </div>
                                    <div class="col-md-12 mt-3">

                                        <label
                                            for="alamat"
                                            class="form-label"
                                        >
                                            Alamat
                                        </label>
                                        <textarea
                                            name="alamat"
                                            id="alamat"
                                            class="form-control"
                                            rows="2"
                                            placeholder="Masukkan alamat pelanggan"
                                            required
                                        ></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5>Data Barang Servis</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label
                                            for="jenis_barang"
                                            class="form-label"
                                        >
                                            Jenis Barang
                                        </label>
                                        <input
                                            type="text"
                                            name="jenis_barang"
                                            id="jenis_barang"
                                            class="form-control"
                                            placeholder="Contoh: Laptop, PC"
                                            required
                                        >
                                    </div>
                                    <div class="col-md-4">
                                        <label
                                            for="merek"
                                            class="form-label"
                                        >
                                            Merek / Model
                                        </label>
                                        <input
                                            type="text"
                                            name="merek"
                                            id="merek"
                                            class="form-control"
                                            placeholder="Contoh: Asus A456U"
                                            required
                                        >
                                    </div>
                                    <div class="col-md-4">
                                        <label
                                            for="kelengkapan"
                                            class="form-label"
                                        >
                                            Kelengkapan
                                        </label>
                                        <input
                                            type="text"
                                            name="kelengkapan"
                                            id="kelengkapan"
                                            class="form-control"
                                            placeholder="Contoh: Charger, tas, mouse"
                                        >
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <label
                                            for="keluhan"
                                            class="form-label"
                                        >
                                            Keluhan / Kerusakan
                                        </label>
                                        <textarea
                                            name="keluhan"
                                            id="keluhan"
                                            class="form-control"
                                            rows="2"
                                            placeholder="Masukkan keluhan atau kerusakan"
                                            required
                                        ></textarea>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <label
                                            for="estimasi_biaya"
                                            class="form-label"
                                        >
                                            Estimasi Biaya (Rp)
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                Rp
                                            </span>
                                            <input
                                                type="number"
                                                name="estimasi_biaya"
                                                id="estimasi_biaya"
                                                class="form-control"
                                                placeholder="Contoh: 250000"
                                                min="0"
                                                required
                                            >
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <label
                                            for="tanggal_masuk"
                                            class="form-label"
                                        >
                                            Tanggal Masuk
                                        </label>
                                        <input
                                            type="datetime-local"
                                            name="tanggal_masuk"
                                            id="tanggal_masuk"
                                            class="form-control"
                                            value="<?= date('Y-m-d\TH:i'); ?>"
                                            required
                                        >
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <label
                                            for="status"
                                            class="form-label"
                                        >
                                            Status Servis
                                        </label>
                                        <select
                                            name="status"
                                            id="status"
                                            class="form-select"
                                            required
                                        >
                                            <option value="Menunggu">
                                                Menunggu
                                            </option>

                                            <option value="Selesai">
                                                Selesai
                                            </option>
                                            <option value="Batal">
                                                Batal
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <label
                                            for="catatan"
                                            class="form-label"
                                        >
                                            Catatan Tambahan (Opsional)
                                        </label>
                                        <textarea
                                            name="catatan"
                                            id="catatan"
                                            class="form-control"
                                            rows="2"
                                            placeholder="Masukkan catatan tambahan jika diperlukan"
                                        ></textarea>
                                    </div>
                                    <div class="col-12 pt-3">
                                        <button
                                            type="submit"
                                            class="btn btn-success"
                                            name="tambah"
                                        >
                                            <i class="bi bi-save"></i>
                                            Simpan Servis
                                        </button>
                                        <a
                                            href="index.php"
                                            class="btn btn-secondary"
                                        >
                                            <i class="bi bi-arrow-left"></i>
                                            Batal
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </main>
            <?php include 'partials/footer.php'; ?>
        </div>
    </div>
    <?php include 'partials/scripts.php'; ?>
</body>
</html>