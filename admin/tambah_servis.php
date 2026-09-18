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

                    <form action="proses_servis.php" method="POST" class="row g-3">

                        <!-- DATA PELANGGAN BARU -->
                        <div class="card mb-4">

                            <div class="card-header">
                                <h5>Data Pelanggan</h5>
                            </div>

                            <div class="card-body">

                                <div class="row">

                                    <!-- NAMA PELANGGAN -->
                                    <div class="col-md-6">

                                        <label class="form-label">
                                            Nama Pelanggan
                                        </label>

                                        <input
                                            type="text"
                                            name="nama_pelanggan"
                                            id="nama_pelanggan"
                                            class="form-control"
                                            required
                                        >

                                    </div>


                                    <!-- NO HP -->
                                    <div class="col-md-6">

                                        <label class="form-label">
                                            No HP
                                        </label>

                                        <input
                                            type="number"
                                            name="no_hp"
                                            id="no_hp"
                                            class="form-control"
                                            required
                                        >

                                    </div>


                                    <!-- ALAMAT -->
                                    <div class="col-md-12">

                                        <label class="form-label">
                                            Alamat
                                        </label>

                                        <textarea
                                            name="alamat"
                                            id="alamat"
                                            class="form-control"
                                            rows="2"
                                            required
                                        ></textarea>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <!-- DATA BARANG SERVIS -->
                        <div class="card mb-4">

                            <div class="card-header">
                                <h5>Data Barang Servis</h5>
                            </div>

                            <div class="card-body">

                                <div class="row">

                                    <!-- JENIS BARANG -->
                                    <div class="col-md-4">

                                        <label class="form-label">
                                            Jenis Barang
                                        </label>

                                        <input
                                            type="text"
                                            name="jenis_barang"
                                            class="form-control"
                                            placeholder="Contoh: Laptop, HP"
                                            required
                                        >

                                    </div>


                                    <!-- MEREK / MODEL -->
                                    <div class="col-md-4">

                                        <label class="form-label">
                                            Merek / Model
                                        </label>

                                        <input
                                            type="text"
                                            name="merek"
                                            class="form-control"
                                            placeholder="Contoh: Asus A456U"
                                            required
                                        >

                                    </div>


                                    <!-- KELENGKAPAN -->
                                    <div class="col-md-4">

                                        <label class="form-label">
                                            Kelengkapan
                                        </label>

                                        <input
                                            type="text"
                                            name="kelengkapan"
                                            class="form-control"
                                            placeholder="Contoh: charger, tas, mouse"
                                        >

                                    </div>


                                    <!-- KELUHAN -->
                                    <div class="col-md-6">

                                        <label class="form-label">
                                            Keluhan / Kerusakan
                                        </label>

                                        <textarea
                                            name="keluhan"
                                            class="form-control"
                                            rows="2"
                                            required
                                        ></textarea>

                                    </div>


                                    <!-- ESTIMASI BIAYA -->
                                    <div class="col-md-6">

                                        <label class="form-label">
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
                                                required
                                            >

                                        </div>

                                    </div>


                                    <!-- TANGGAL MASUK -->
                                    <div class="col-md-6">

                                        <label class="form-label">
                                            Tanggal Masuk
                                        </label>

                                        <input
                                            type="datetime-local"
                                            name="tanggal_masuk"
                                            class="form-control"
                                            value="<?= date('Y-m-d\TH:i'); ?>"
                                            required
                                        >

                                    </div>


                                    <!-- STATUS SERVIS -->
                                    <div class="col-md-6">

                                        <label class="form-label">
                                            Status Servis
                                        </label>

                                        <select
                                            name="status"
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


                                    <!-- CATATAN -->
                                    <div class="col-12">

                                        <label class="form-label">
                                            Catatan Tambahan (Opsional)
                                        </label>

                                        <textarea
                                            name="catatan"
                                            class="form-control"
                                            rows="2"
                                        ></textarea>

                                    </div>


                                    <!-- TOMBOL -->
                                    <div class="col-12 pt-3">

                                        <button
                                            type="submit"
                                            class="btn btn-success"
                                            name="tambah"
                                        >
                                            Simpan Servis
                                        </button>

                                        <a
                                            href="index.php"
                                            class="btn btn-secondary"
                                        >
                                            Batal
                                        </a>

                                    </div>

                                </div>

                            </div>
