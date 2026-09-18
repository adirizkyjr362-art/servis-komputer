```php
<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require '../config/koneksi.php';

/* QUERY DATA SERVIS + PELANGGAN */
$sql = "
    SELECT
        s.id_servis,
        s.kode_servis,
        s.tanggal_masuk,
        s.tanggal_selesai,
        s.jenis_barang,
        s.status,
        p.nama AS nama_pelanggan
    FROM servis s
    JOIN pelanggan p ON p.id_pelanggan = s.id_pelanggan
    ORDER BY s.tanggal_masuk DESC
";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<?php include 'partials/header.php'; ?>

<body class="sb-nav-fixed">

    <?php include 'partials/navbar.php'; ?>

    <div id="layoutSidenav">

        <!-- SIDEBAR -->
        <div id="layoutSidenav_nav">
            <?php include 'partials/sidebar.php'; ?>
        </div>

        <!-- CONTENT -->
        <div id="layoutSidenav_content">

            <main>

                <div class="container-fluid px-4">

                    <!-- JUDUL -->
                    <h1 class="mt-4">Daftar Servis</h1>

                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item">
                            <a href="index.php">Dashboard</a>
                        </li>

                        <li class="breadcrumb-item active">
                            Daftar Servis
                        </li>
                    </ol>

                    <!-- CARD -->
                    <div class="card mb-4">

                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data Servis
                        </div>

                        <div class="card-body">

                            <table id="datatablesSimple">

                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Tgl Masuk</th>
                                        <th>Tgl Selesai</th>
                                        <th>Pelanggan</th>
                                        <th>Barang</th>
                                        <th>Status</th>
                                        <th width="110">Aksi</th>
                                    </tr>
                                </thead>

                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Tgl Masuk</th>
                                        <th>Tgl Selesai</th>
                                        <th>Pelanggan</th>
                                        <th>Barang</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>

                                <tbody>

                                    <?php
                                    if ($result && mysqli_num_rows($result) > 0):

                                        $no = 1;

                                        while ($row = mysqli_fetch_assoc($result)):
                                    ?>

                                        <tr>

                                            <!-- NO -->
                                            <td>
                                                <?= $no++; ?>
                                            </td>

                                            <!-- KODE -->
                                            <td>
                                                <?= htmlspecialchars($row['kode_servis']); ?>
                                            </td>

                                            <!-- TANGGAL MASUK -->
                                            <td>
                                                <?= !empty($row['tanggal_masuk'])
                                                    ? date(
                                                        'd-m-Y H:i:s',
                                                        strtotime($row['tanggal_masuk'])
                                                    )
                                                    : '-';
                                                ?>
                                            </td>

                                            <!-- TANGGAL SELESAI -->
                                            <td>
                                                <?php
                                                if (!empty($row['tanggal_selesai'])) {
                                                    echo date(
                                                        'd-m-Y H:i:s',
                                                        strtotime($row['tanggal_selesai'])
                                                    );
                                                } else {
                                                    echo '<span class="text-muted">-</span>';
                                                }
                                                ?>
                                            </td>

                                            <!-- PELANGGAN -->
                                            <td>
                                                <?= htmlspecialchars(
                                                    $row['nama_pelanggan']
                                                ); ?>
                                            </td>

                                            <!-- BARANG -->
                                            <td>
                                                <?= htmlspecialchars(
                                                    $row['jenis_barang']
                                                ); ?>
                                            </td>

                                            <!-- STATUS -->
                                            <td>

                                                <?php

                                                $badge = [
                                                    'menunggu' => 'badge-menunggu',
                                                    'masuk'    => 'badge-masuk',
                                                    'proses'   => 'badge-proses',
                                                    'selesai'  => 'badge-selesai',
                                                    'diambil'  => 'badge-diambil',
                                                    'batal'    => 'badge-batal'
                                                ][$row['status']] ?? 'bg-secondary';

                                                ?>

                                                <span class="badge <?= $badge ?>">
                                                    <?= ucfirst(
                                                        htmlspecialchars($row['status'])
                                                    ); ?>
                                                </span>

                                            </td>

                                            <!-- AKSI -->
                                            <td>

                                                <div class="d-flex gap-1">

                                                    <!-- DETAIL -->
                                                    <a
                                                        href="servis_detail.php?id=<?= $row['id_servis']; ?>"
                                                        class="btn btn-sm btn-info"
                                                        title="Detail Servis"
                                                    >
                                                        <i class="bi bi-eye"></i>
                                                    </a>

                                                    <!-- HAPUS -->
                                                    <a
                                                        href="proses_servis.php?hapus=<?= $row['id_servis']; ?>"
                                                        onclick="return confirm('Yakin ingin menghapus data ini?')"
                                                        class="btn btn-sm btn-danger"
                                                        title="Hapus Servis"
                                                    >
                                                        <i class="bi bi-trash"></i>
                                                    </a>

                                                </div>

                                            </td>

                                        </tr>

                                    <?php
                                        endwhile;

                                    else:
                                    ?>

                                        <tr>
                                            <td colspan="8" class="text-center">
                                                <span class="text-muted">
                                                    Belum ada data servis.
                                                </span>
                                            </td>
                                        </tr>

                                    <?php endif; ?>

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
