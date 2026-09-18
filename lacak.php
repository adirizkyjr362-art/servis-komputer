<?php
require 'config/koneksi.php';

$kode = trim($_GET['kode'] ?? '');
$data = null;

if ($kode !== '') {

    // Mengambil data servis dan nama pelanggan
    // Sesuai struktur database:
    // servis.id_pelanggan -> pelanggan.id_pelanggan

    $stmt = $conn->prepare("
        SELECT
            s.id_servis,
            s.kode_servis,
            s.status,
            s.tanggal_masuk,
            s.tanggal_selesai,
            s.jenis_barang,
            s.merek,
            s.kelengkapan,
            s.keluhan,
            s.estimasi_biaya,
            s.catatan,
            p.nama AS nama_pelanggan
        FROM servis s
        LEFT JOIN pelanggan p
            ON p.id_pelanggan = s.id_pelanggan
        WHERE s.kode_servis = ?
    ");

    $stmt->bind_param("s", $kode);
    $stmt->execute();

    $data = $stmt->get_result()->fetch_assoc();

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Lacak Servis</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body class="bg-light">

<div class="container py-5">

    <!-- JUDUL -->

    <div class="text-center mb-4">

        <h2 class="fw-bold text-primary">

            <i class="fas fa-search"></i>

            Lacak Status Servis

        </h2>

        <p class="text-muted">

            Masukkan kode servis Anda untuk melihat status terkini.

        </p>

    </div>


    <!-- FORM PENCARIAN -->

    <form method="GET"
          class="row g-2 justify-content-center mb-4">

        <div class="col-sm-5">

            <input
                type="text"
                name="kode"
                class="form-control text-uppercase"
                placeholder="Masukkan Kode Servis"
                value="<?= htmlspecialchars($kode); ?>"
                required>

        </div>

        <div class="col-auto">

            <button
                type="submit"
                class="btn btn-outline-primary">

                <i class="fas fa-search"></i>

                Cek Status

            </button>

        </div>

    </form>


    <?php if ($kode !== ''): ?>

        <?php if ($data): ?>


            <!-- INFORMASI SERVIS -->

            <div class="card shadow-sm mb-4 border-success">

                <div class="card-header bg-success text-white">

                    <strong>

                        Status Servis:

                        <?= strtoupper(
                            htmlspecialchars($data['status'])
                        ); ?>

                    </strong>

                </div>


                <div class="card-body">

                    <ul class="list-group list-group-flush">


                        <!-- KODE -->

                        <li class="list-group-item">

                            <strong>Kode Servis:</strong>

                            <?= htmlspecialchars(
                                $data['kode_servis']
                            ); ?>

                        </li>


                        <!-- PELANGGAN -->

                        <li class="list-group-item">

                            <strong>Nama Pelanggan:</strong>

                            <?= htmlspecialchars(
                                $data['nama_pelanggan'] ?? '-'
                            ); ?>

                        </li>


                        <!-- BARANG -->

                        <li class="list-group-item">

                            <strong>Jenis Barang:</strong>

                            <?= htmlspecialchars(
                                $data['jenis_barang'] ?? '-'
                            ); ?>

                        </li>


                        <!-- MEREK -->

                        <li class="list-group-item">

                            <strong>Merek / Model:</strong>

                            <?= htmlspecialchars(
                                $data['merek'] ?? '-'
                            ); ?>

                        </li>


                        <!-- KELENGKAPAN -->

                        <li class="list-group-item">

                            <strong>Kelengkapan:</strong>

                            <?= htmlspecialchars(
                                $data['kelengkapan'] ?? '-'
                            ); ?>

                        </li>


                        <!-- KELUHAN -->

                        <li class="list-group-item">

                            <strong>Keluhan / Kerusakan:</strong>

                            <?= htmlspecialchars(
                                $data['keluhan'] ?? '-'
                            ); ?>

                        </li>


                        <!-- ESTIMASI -->

                        <li class="list-group-item">

                            <strong>Estimasi Biaya:</strong>

                            Rp

                            <?= number_format(
                                (int)($data['estimasi_biaya'] ?? 0),
                                0,
                                ',',
                                '.'
                            ); ?>

                        </li>


                        <!-- TANGGAL MASUK -->

                        <li class="list-group-item">

                            <strong>Tanggal Masuk:</strong>

                            <?php if (!empty($data['tanggal_masuk'])): ?>

                                <?= date(
                                    'd-m-Y H:i',
                                    strtotime(
                                        $data['tanggal_masuk']
                                    )
                                ); ?>

                            <?php else: ?>

                                -

                            <?php endif; ?>

                        </li>


                        <!-- TANGGAL SELESAI -->

                        <?php if (!empty($data['tanggal_selesai'])): ?>

                            <li class="list-group-item">

                                <strong>Tanggal Selesai:</strong>

                                <?= date(
                                    'd-m-Y H:i',
                                    strtotime(
                                        $data['tanggal_selesai']
                                    )
                                ); ?>

                            </li>

                        <?php endif; ?>


                        <!-- CATATAN -->

                        <?php if (!empty($data['catatan'])): ?>

                            <li class="list-group-item">

                                <strong>Catatan:</strong>

                                <?= htmlspecialchars(
                                    $data['catatan']
                                ); ?>

                            </li>

                        <?php endif; ?>


                    </ul>

                </div>

            </div>


            <!-- KETERANGAN STATUS -->

            <div class="alert alert-info text-center">

                <?php

                $status = strtolower(
                    trim($data['status'])
                );

                if ($status === 'masuk') {

                    echo '
                        <i class="fas fa-inbox"></i>
                        Servis telah diterima dan menunggu proses.
                    ';

                } elseif ($status === 'proses') {

                    echo '
                        <i class="fas fa-tools"></i>
                        Servis sedang dalam proses pengerjaan.
                    ';

                } elseif ($status === 'selesai') {

                    echo '
                        <i class="fas fa-check-circle"></i>
                        Servis telah selesai dan dapat diambil.
                    ';

                } elseif ($status === 'batal') {

                    echo '
                        <i class="fas fa-times-circle"></i>
                        Servis dibatalkan.
                    ';

                } else {

                    echo '
                        Status servis:
                        ' .
                        htmlspecialchars(
                            $data['status']
                        );

                }

                ?>

            </div>


            <!-- KEMBALI -->

            <div class="text-center mt-4">

                <a
                    href="index.php"
                    class="btn btn-secondary">

                    <i class="fas fa-arrow-left"></i>

                    Kembali

                </a>

            </div>


        <?php else: ?>


            <!-- DATA TIDAK DITEMUKAN -->

            <div class="alert alert-warning text-center">

                <i class="fas fa-exclamation-triangle"></i>

                Kode

                <strong>
                    <?= htmlspecialchars($kode); ?>
                </strong>

                tidak ditemukan.

                <br>

                Silakan periksa kembali kode servis Anda.

            </div>


        <?php endif; ?>

    <?php endif; ?>

</div>

</body>

</html>