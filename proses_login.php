<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require 'config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.phpl');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// Validasi input
if ($username === '' || $password === '') {
    $_SESSION['error'] = 'Username dan password wajib diisi.';
    header('Location: index.php');
    exit;
}

// Ambil data user dari tabel users
$stmt = $conn->prepare("SELECT id_user, username, password, role, nama FROM users WHERE username = ? LIMIT 1");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user']     = $user['username'];
    $_SESSION['role']     = $user['role'];
    $_SESSION['id_user']  = $user['id_user'];

    if ($user['role'] === 'admin') {
        $_SESSION['nama'] = $user['nama']; // Ambil langsung dari tabel users (admin)
        header('Location: admin/index.php');
        exit;
    } elseif ($user['role'] === 'teknisi') {
        // Ambil data teknisi dari tabel teknisi
        $qTek = $conn->prepare("SELECT id_teknisi, nama FROM teknisi WHERE id_user = ? LIMIT 1");
        $qTek->bind_param('i', $user['id_user']);
        $qTek->execute();
        $resTek = $qTek->get_result();
        $dataTek = $resTek->fetch_assoc();

        if ($dataTek) {
            $_SESSION['id_teknisi'] = (int) $dataTek['id_teknisi'];
            $_SESSION['nama'] = $dataTek['nama']; // Nama teknisi dari tabel teknisi
            header('Location: teknisi/index.php');
            exit;
        } else {
            echo "<script>alert('ID teknisi tidak ditemukan. Silakan hubungi admin.'); window.location.href='index.php';</script>";
            exit;
        }
    } else {
        $_SESSION['error'] = 'Role tidak dikenali.';
        header('Location: index.php');
        exit;
    }
}
?>
