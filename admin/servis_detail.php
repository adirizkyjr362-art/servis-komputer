<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

require '../config/koneksi.php';


/* =========================================================
   PROSES UPDATE DATA SERVIS
   ========================================================= */

if (isset($_POST['update_servis'])) {

    $id_servis = intval($_POST['id_servis']);
    $id_pelanggan = intval($_POST['id_pelanggan']);

    $nama_pelanggan = mysqli_real_escape_string(
        $conn,
        $_POST['nama_pelanggan']
    );

    $no_hp = mysqli_real_escape_string(
        $conn,
        $_POST['no_hp']
    );

    $keluhan = mysqli_real_escape_string(
        $conn,
        $_POST['keluhan']
    );

    $status = mysqli_real_escape_string(
        $conn,
        $_POST['status']
    );

    $tanggal_masuk = mysqli_real_escape_string(
        $conn,
        $_POST['tanggal_masuk']
    );


    /* =====================================================
       TANGGAL SELESAI OTOMATIS
       ===================================================== */

    if ($status == 'selesai') {

        // Jika status selesai, tanggal selesai menggunakan waktu sekarang
        $tanggal_selesai = date('Y-m-d H:i:s');

        $tanggal_selesai_sql = "'$tanggal_selesai'";

    } else {

        // Jika belum selesai, tanggal selesai dikosongkan
        $tanggal_selesai_sql = "NULL";

    }


    /* =====================================================
       UPDATE DATA PELANGGAN
       ===================================================== */

    $update_pelanggan = mysqli_query($conn, "
        UPDATE pelanggan
        SET
            nama = '$nama_pelanggan',
            no_hp = '$no_hp'
        WHERE id_pelanggan = $id_pelanggan
    ");


    /* =====================================================
       UPDATE DATA SERVIS
       ===================================================== */

    $update_servis = mysqli_query($conn, "
        UPDATE servis
        SET
            keluhan = '$keluhan',
            status = '$status',
            tanggal_masuk = '$tanggal_masuk',
            tanggal_selesai = $tanggal_selesai_sql
        WHERE id_servis = $id_servis
    ");


    /* =====================================================
       CEK HASIL UPDATE
       ===================================================== */

    if ($update_pelanggan && $update_servis) {

        $_SESSION['success'] =
            "Data servis berhasil diperbarui.";

    } else {

        $_SESSION['error'] =
            "Data servis gagal diperbarui.";

    }


    header("Location: servis_detail.php?id=$id_servis");
    exit;
}


/* =========================================================
   AMBIL ID SERVIS
   ========================================================= */

$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {

    header("Location: daftar_servis.php");
    exit;

}


/* =========================================================
   QUERY DATA SERVIS
   ========================================================= */

$sql = "
    SELECT
        s.id_servis,
        s.kode_servis,
        s.id_pelanggan,
        s.jenis_barang,
        s.merek,
        s.kelengkapan,
        s.status,
        s.keluhan,
        s.estimasi_biaya,
        s.tanggal_masuk,
        s.tanggal_selesai,
        s.catatan,

        p.nama AS nama_pelanggan,
        p.no_hp,
        p.alamat

    FROM servis s

    JOIN pelanggan p
        ON p.id_pelanggan = s.id_pelanggan

    WHERE s.id_servis = $id
";


$result = mysqli_query($conn, $sql);

$data = mysqli_fetch_assoc($result);


/* =========================================================
   CEK DATA
   ========================================================= */

if (!$data) {

    header("Location: daftar_servis.php");
    exit;

}

?>

<!DOCTYPE html>
<html lang="id">

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


                <!-- =================================================
                     JUDUL
                     ================================================= -->

                <h1 class="mt-4">
                    Detail Servis
                </h1>


                <!-- =================================================
                     BREADCRUMB
                     ================================================= -->

                <ol class="breadcrumb mb-4">

                    <li class="breadcrumb-item">

                        <a href="daftar_servis.php">

                            <i class="bi bi-arrow-left"></i>

                            Kembali

                        </a>

                    </li>

                    <li class="breadcrumb-item active">

                        Detail Servis

                    </li>

                </ol>



                <!-- =================================================
                     FORM EDIT DATA
                     ================================================= -->

                <div class="card mb-4">


                    <div class="card-header">

                        <h5 class="mb-0">

                            <i class="bi bi-pencil-square"></i>

                            Edit Data Servis

                        </h5>

                    </div>


                    <div class="card-body">


                        <form method="POST">


                            <!-- ID SERVIS -->

                            <input
                                type="hidden"
                                name="id_servis"
                                value="<?= $data['id_servis'] ?>"
                            >


                            <!-- ID PELANGGAN -->

                            <input
                                type="hidden"
                                name="id_pelanggan"
                                value="<?= $data['id_pelanggan'] ?>"
                            >



                            <div class="row">


                                <!-- =================================================
                                     KODE SERVIS
                                     ================================================= -->

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">

                                        Kode Servis

                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        value="<?= htmlspecialchars($data['kode_servis']) ?>"
                                        readonly
                                    >

                                </div>



                                <!-- =================================================
                                     TANGGAL MASUK
                                     ================================================= -->

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">

                                        Tanggal Masuk

                                    </label>

                                    <input
                                        type="datetime-local"
                                        name="tanggal_masuk"
                                        class="form-control"
                                        value="<?= date(
                                            'Y-m-d\TH:i',
                                            strtotime($data['tanggal_masuk'])
                                        ) ?>"
                                        required
                                    >

                                </div>



                                <!-- =================================================
                                     TANGGAL SELESAI
                                     ================================================= -->

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">

                                        Tanggal Selesai

                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        value="<?=
                                            !empty($data['tanggal_selesai'])
                                            ? date(
                                                'd-m-Y H:i:s',
                                                strtotime($data['tanggal_selesai'])
                                            )
                                            : '-'
                                        ?>"
                                        readonly
                                    >

                                    <small class="text-muted">

                                        Tanggal selesai akan terisi otomatis
                                        ketika status diubah menjadi Selesai.

                                    </small>

                                </div>



                                <!-- =================================================
                                     NAMA PELANGGAN
                                     ================================================= -->

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">

                                        Nama Pelanggan

                                    </label>

                                    <input
                                        type="text"
                                        name="nama_pelanggan"
                                        class="form-control"
                                        value="<?= htmlspecialchars(
                                            $data['nama_pelanggan']
                                        ) ?>"
                                        required
                                    >

                                </div>



                                <!-- =================================================
                                     NO HP
                                     ================================================= -->

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">

                                        No. HP

                                    </label>

                                    <input
                                        type="text"
                                        name="no_hp"
                                        class="form-control"
                                        value="<?= htmlspecialchars(
                                            $data['no_hp']
                                        ) ?>"
                                        required
                                    >

                                </div>



                                <!-- =================================================
                                     JENIS BARANG
                                     ================================================= -->

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">

                                        Jenis Barang

                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        value="<?= htmlspecialchars(
                                            $data['jenis_barang']
                                        ) ?>"
                                        readonly
                                    >

                                </div>



                                <!-- =================================================
                                     MEREK / MODEL
                                     ================================================= -->

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">

                                        Merek / Model

                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        value="<?= htmlspecialchars(
                                            $data['merek']
                                        ) ?>"
                                        readonly
                                    >

                                </div>



                                <!-- =================================================
                                     STATUS SERVIS
                                     ================================================= -->

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">

                                        Status Servis

                                    </label>

                                    <select
                                        name="status"
                                        class="form-select"
                                        required
                                    >

                                        <option
                                            value="masuk"
                                            <?= $data['status'] == 'masuk'
                                                ? 'selected'
                                                : '' ?>
                                        >
                                            Masuk
                                        </option>


                                        <option
                                            value="proses"
                                            <?= $data['status'] == 'proses'
                                                ? 'selected'
                                                : '' ?>
                                        >
                                            Proses
                                        </option>


                                        <option
                                            value="selesai"
                                            <?= $data['status'] == 'selesai'
                                                ? 'selected'
                                                : '' ?>
                                        >
                                            Selesai
                                        </option>

                                    </select>

                                </div>



                                <!-- =================================================
                                     KELENGKAPAN
                                     ================================================= -->

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">

                                        Kelengkapan

                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        value="<?= htmlspecialchars(
                                            $data['kelengkapan']
                                        ) ?>"
                                        readonly
                                    >

                                </div>



                                <!-- =================================================
                                     KELUHAN
                                     ================================================= -->

                                <div class="col-md-12 mb-3">

                                    <label class="form-label">

                                        Keluhan / Kerusakan

                                    </label>

                                    <textarea
                                        name="keluhan"
                                        class="form-control"
                                        rows="4"
                                        required
                                    ><?= htmlspecialchars(
                                        $data['keluhan']
                                    ) ?></textarea>

                                </div>


                            </div>



                            <!-- =================================================
                                 BUTTON
                                 ================================================= -->

                            <div class="d-flex gap-2">

                                <button
                                    type="submit"
                                    name="update_servis"
                                    class="btn btn-primary"
                                >

                                    <i class="bi bi-save"></i>

                                    Simpan Perubahan

                                </button>


                                <a
                                    href="daftar_servis.php"
                                    class="btn btn-secondary"
                                >

                                    <i class="bi bi-x-circle"></i>

                                    Batal

                                </a>

                            </div>


                        </form>

                    </div>

                </div>



                <!-- =================================================
                     INFORMASI SERVIS
                     ================================================= -->

                <div class="card mb-4">


                    <div class="card-header">

                        <h5 class="mb-0">

                            <i class="bi bi-info-circle"></i>

                            Informasi Servis

                        </h5>

                    </div>


                    <div class="card-body">


                        <table class="table table-bordered">


                            <tr>

                                <th width="30%">
                                    Kode Servis
                                </th>

                                <td>
                                    <?= htmlspecialchars(
                                        $data['kode_servis']
                                    ) ?>
                                </td>

                            </tr>


                            <tr>

                                <th>
                                    Nama Pelanggan
                                </th>

                                <td>
                                    <?= htmlspecialchars(
                                        $data['nama_pelanggan']
                                    ) ?>
                                </td>

                            </tr>


                            <tr>

                                <th>
                                    No. HP
                                </th>

                                <td>
                                    <?= htmlspecialchars(
                                        $data['no_hp']
                                    ) ?>
                                </td>

                            </tr>


                            <tr>

                                <th>
                                    Jenis Barang
                                </th>

                                <td>
                                    <?= htmlspecialchars(
                                        $data['jenis_barang']
                                    ) ?>
                                </td>

                            </tr>


                            <tr>

                                <th>
                                    Merek / Model
                                </th>

                                <td>
                                    <?= htmlspecialchars(
                                        $data['merek']
                                    ) ?>
                                </td>

                            </tr>


                            <tr>

                                <th>
                                    Kelengkapan
                                </th>

                                <td>
                                    <?= htmlspecialchars(
                                        $data['kelengkapan']
                                    ) ?>
                                </td>

                            </tr>


                            <tr>

                                <th>
                                    Keluhan
                                </th>

                                <td>
                                    <?= nl2br(
                                        htmlspecialchars(
                                            $data['keluhan']
                                        )
                                    ) ?>
                                </td>

                            </tr>


                            <tr>

                                <th>
                                    Status
                                </th>

                                <td>

                                    <?php

                                    $badge = [

                                        'masuk'   => 'badge-masuk',
                                        'proses'  => 'badge-proses',
                                        'selesai' => 'badge-selesai'

                                    ][$data['status']] ?? 'bg-secondary';

                                    ?>


                                    <span class="badge <?= $badge ?>">

                                        <?= ucfirst(
                                            $data['status']
                                        ) ?>

                                    </span>

                                </td>

                            </tr>


                            <tr>

                                <th>
                                    Tanggal Masuk
                                </th>

                                <td>

                                    <?= date(
                                        'd-m-Y H:i:s',
                                        strtotime(
                                            $data['tanggal_masuk']
                                        )
                                    ) ?>

                                </td>

                            </tr>


                            <tr>

                                <th>
                                    Tanggal Selesai
                                </th>

                                <td>

                                    <?php if (!empty($data['tanggal_selesai'])): ?>

                                        <?= date(
                                            'd-m-Y H:i:s',
                                            strtotime(
                                                $data['tanggal_selesai']
                                            )
                                        ) ?>

                                    <?php else: ?>

                                        <span class="text-muted">
                                            -
                                        </span>

                                    <?php endif; ?>

                                </td>

                            </tr>


                        </table>

                    </div>

                </div>


            </div>

        </main>


        <?php include 'partials/footer.php'; ?>

    </div>

</div>


<?php include 'partials/scripts.php'; ?>


<!-- =========================================================
     SWEETALERT SUCCESS
     ========================================================= -->

<?php if (isset($_SESSION['success'])): ?>

<script>

Swal.fire({

    toast: true,

    position: 'top',

    icon: 'success',

    title: '<?= htmlspecialchars(
        $_SESSION['success']
    ) ?>',

    showConfirmButton: false,

    timer: 3000,

    timerProgressBar: true

});

</script>

<?php unset($_SESSION['success']); endif; ?>



<!-- =========================================================
     SWEETALERT ERROR
     ========================================================= -->

<?php if (isset($_SESSION['error'])): ?>

<script>

Swal.fire({

    toast: true,

    position: 'top',

    icon: 'error',

    title: '<?= htmlspecialchars(
        $_SESSION['error']
    ) ?>',

    showConfirmButton: false,

    timer: 3000,

    timerProgressBar: true

});

</script>

<?php unset($_SESSION['error']); endif; ?>


</body>
</html>