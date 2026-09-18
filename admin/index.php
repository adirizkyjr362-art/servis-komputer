<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include '../config/koneksi.php';

// Jumlah servis berdasarkan status
$totMasuk = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) j FROM servis WHERE status='masuk'")
)['j'] ?? 0;

$totProses = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) j FROM servis WHERE status='proses'")
)['j'] ?? 0;

$totSelesai = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) j FROM servis WHERE status='selesai'")
)['j'] ?? 0;

// Data servis terbaru
$recent = mysqli_query($conn, "
    SELECT 
        s.kode_servis,
        p.nama,
        s.keluhan,
        s.status,
        DATE_FORMAT(s.tanggal_masuk,'%d-%m-%Y') AS tgl
    FROM servis s
    JOIN pelanggan p ON p.id_pelanggan = s.id_pelanggan
    ORDER BY s.tanggal_masuk DESC
    LIMIT 8
");
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

                    <h1 class="mt-4">
                        Selamat Datang <?= htmlspecialchars($_SESSION['nama']); ?>
                    </h1>

                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>

                    <!-- 3 KARTU STATUS SERVIS -->
                    <div class="row">

                        <!-- SERVIS MASUK -->
                        <div class="col-xl-4 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">
                                    SERVIS MASUK
                                    <h3 class="mb-0 fw-bold">
                                        <?= $totMasuk ?>
                                    </h3>
                                </div>

                                <div class="card-footer d-flex align-items-center justify-content-between">
                                </div>
                            </div>
                        </div>

                        <!-- PROSES -->
                        <div class="col-xl-4 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">
                                    PROSES
                                    <h3 class="mb-0 fw-bold">
                                        <?= $totProses ?>
                                    </h3>
                                </div>

                                <div class="card-footer d-flex align-items-center justify-content-between">
                                </div>
                            </div>
                        </div>

                        <!-- SELESAI -->
                        <div class="col-xl-4 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">
                                    SELESAI
                                    <h3 class="mb-0 fw-bold">
                                        <?= $totSelesai ?>
                                    </h3>
                                </div>

                                <div class="card-footer d-flex align-items-center justify-content-between">
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- DATA SERVIS -->
                    <div class="card mb-4">

                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data Servis
                        </div>

                        <div class="card-body">

                            <table id="datatablesSimple">

                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Kerusakan</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php while ($row = mysqli_fetch_assoc($recent)): ?>

                                        <tr>

                                            <td>
                                                <?= htmlspecialchars($row['kode_servis']) ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($row['nama']) ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($row['keluhan']) ?>
                                            </td>

                                            <td>

                                                <span class="badge text-bg-<?=
                                                    $row['status'] == 'masuk'
                                                        ? 'info'
                                                        : (
                                                            $row['status'] == 'proses'
                                                                ? 'warning'
                                                                : (
                                                                    $row['status'] == 'selesai'
                                                                        ? 'success'
                                                                        : 'secondary'
                                                                )
                                                        )
                                                ?>">

                                                    <?= ucfirst($row['status']) ?>

                                                </span>

                                            </td>

                                            <td>
                                                <?= $row['tgl'] ?>
                                            </td>

                                        </tr>

                                    <?php endwhile; ?>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </main>

            <?php include 'partials/footer.php'; ?>

        </div>

    </div>

    <?php include 'partials/scripts.php'; ?>

</body>
</html>