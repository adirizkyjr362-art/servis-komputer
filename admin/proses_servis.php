<?php
session_start();

require '../config/koneksi.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}


// ======================================================
// TAMBAH SERVIS
// ======================================================
if (isset($_POST['tambah'])) {

    // -----------------------------
    // DATA PELANGGAN BARU
    // -----------------------------
    $nama_pelanggan = mysqli_real_escape_string(
        $conn,
        $_POST['nama_pelanggan']
    );

    $no_hp = mysqli_real_escape_string(
        $conn,
        $_POST['no_hp']
    );

    $alamat = mysqli_real_escape_string(
        $conn,
        $_POST['alamat']
    );


    // -----------------------------
    // DATA BARANG SERVIS
    // -----------------------------
    $jenis_barang = mysqli_real_escape_string(
        $conn,
        $_POST['jenis_barang']
    );

    $merek = mysqli_real_escape_string(
        $conn,
        $_POST['merek']
    );

    $kelengkapan = mysqli_real_escape_string(
        $conn,
        $_POST['kelengkapan']
    );

    $keluhan = mysqli_real_escape_string(
        $conn,
        $_POST['keluhan']
    );

    $estimasi_biaya = (int) $_POST['estimasi_biaya'];

    $tanggal_masuk = mysqli_real_escape_string(
        $conn,
        $_POST['tanggal_masuk']
    );

    $status = mysqli_real_escape_string(
        $conn,
        $_POST['status']
    );

    $catatan = mysqli_real_escape_string(
        $conn,
        $_POST['catatan']
    );


    // ==================================================
    // SIMPAN PELANGGAN BARU
    // ==================================================
    mysqli_query(
        $conn,
        "INSERT INTO pelanggan (nama, no_hp, alamat)
         VALUES (
            '$nama_pelanggan',
            '$no_hp',
            '$alamat'
         )"
    ) or die(mysqli_error($conn));

    $id_pelanggan = mysqli_insert_id($conn);


    // ==================================================
    // GENERATE KODE SERVIS
    // ==================================================
    $tahun = date('y');
    $prefix = "S$tahun";

    $q = mysqli_query(
        $conn,
        "SELECT MAX(
            CAST(
                SUBSTRING(kode_servis, 4)
                AS UNSIGNED
            )
        ) AS no_akhir
        FROM servis
        WHERE SUBSTRING(kode_servis, 2, 2) = '$tahun'"
    );

    $data = mysqli_fetch_assoc($q);

    $next = ($data['no_akhir'] ?? 0) + 1;

    $kode_servis = $prefix .
                   str_pad(
                       $next,
                       3,
                       '0',
                       STR_PAD_LEFT
                   );


    // ==================================================
    // SIMPAN DATA SERVIS
    // ==================================================
    mysqli_query(
        $conn,
        "INSERT INTO servis (
            kode_servis,
            id_pelanggan,
            jenis_barang,
            merek,
            kelengkapan,
            keluhan,
            estimasi_biaya,
            status,
            tanggal_masuk,
            catatan
        )
        VALUES (
            '$kode_servis',
            $id_pelanggan,
            '$jenis_barang',
            '$merek',
            '$kelengkapan',
            '$keluhan',
            $estimasi_biaya,
            '$status',
            '$tanggal_masuk',
            '$catatan'
        )"
    ) or die(mysqli_error($conn));


    // ==================================================
    // BERHASIL
    // ==================================================
    $_SESSION['success'] = "Data servis berhasil ditambahkan!";

    header("Location: daftar_servis.php");
    exit;
}


// ======================================================
// UPDATE TEKNISI
// ======================================================
if (isset($_POST['update_teknisi'])) {

    $id_servis = intval($_POST['id_servis']);

    $id_teknisi = !empty($_POST['id_teknisi'])
        ? intval($_POST['id_teknisi'])
        : 'NULL';


    mysqli_query(
        $conn,
        "UPDATE servis
         SET id_teknisi = $id_teknisi
         WHERE id_servis = $id_servis"
    ) or die(mysqli_error($conn));


    $_SESSION['success'] = "Teknisi berhasil diperbarui!";

    header(
        "Location: servis_detail.php?id=$id_servis"
    );

    exit;
}


// ======================================================
// HAPUS SERVIS
// ======================================================
if (isset($_GET['hapus'])) {

    $id = intval($_GET['hapus']);

    if ($id > 0) {

        mysqli_query(
            $conn,
            "DELETE FROM servis
             WHERE id_servis = $id
             LIMIT 1"
        );

        $_SESSION['success'] =
            "Servis berhasil dihapus.";
    }

    header("Location: daftar_servis.php");
    exit;
}


// ======================================================
// TAMBAH DETAIL SERVIS / SPAREPART
// ======================================================
if (isset($_POST['tambah_detail'])) {

    $id_servis = intval($_POST['id_servis']);

    $id_barang = intval($_POST['id_barang']);

    $qty = intval($_POST['qty']);

    $harga_satuan = intval($_POST['harga_satuan']);


    // Simpan sparepart ke servis_barang
    $q = "
        INSERT INTO servis_barang (
            id_servis,
            id_barang,
            jumlah,
            harga_satuan
        )
        VALUES (
            $id_servis,
            $id_barang,
            $qty,
            $harga_satuan
        )
    ";


    $simpan = mysqli_query($conn, $q);


    if ($simpan) {

        // Kurangi stok barang
        mysqli_query(
            $conn,
            "UPDATE barang
             SET stok = stok - $qty
             WHERE id_barang = $id_barang"
        );

        $_SESSION['success'] =
            "Berhasil menambahkan sparepart.";

    } else {

        $_SESSION['error'] =
            "Gagal menambahkan sparepart.";
    }


    header(
        "Location: servis_detail.php?id=$id_servis"
    );

    exit;
}


// ======================================================
// HAPUS DETAIL SERVIS / SPAREPART
// ======================================================
if (isset($_GET['hapus_detail'])) {

    $id_detail = intval(
        $_GET['hapus_detail']
    );

    $id_servis = intval(
        $_GET['servis']
    );


    // Ambil data terlebih dahulu
    $detail = mysqli_fetch_assoc(
        mysqli_query(
            $conn,
            "SELECT id_barang, jumlah
             FROM servis_barang
             WHERE id = $id_detail"
        )
    );


    if ($detail) {

        // Hapus detail servis
        mysqli_query(
            $conn,
            "DELETE FROM servis_barang
             WHERE id = $id_detail"
        );


        // Kembalikan stok
        mysqli_query(
            $conn,
            "UPDATE barang
             SET stok = stok + {$detail['jumlah']}
             WHERE id_barang = {$detail['id_barang']}"
        );


        $_SESSION['success'] =
            "Sparepart berhasil dihapus & stok dikembalikan.";
    }


    header(
        "Location: servis_detail.php?id=$id_servis"
    );

    exit;
}

?>
```
