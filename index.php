<?php
require 'config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>MegaBit</title>

  <!-- Favicons -->
  <link href="assets/img/logo.png" rel="icon">
  <link href="assets/img/logo.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&family=Raleway:wght@400;600;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- CSS -->
  <link href="assets/css/main.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    /* Pastikan hero pakai background */
    #hero {
      background: url("assets/img/5.png") no-repeat center center;
      background-size: cover;
      min-height: 100vh;
    }
    #hero img {
      display: none; /* sembunyikan img bawaan */
    }
  </style>
</head>

<body class="index-page">

  <!-- HEADER -->
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">
      <a href="index.php" class="logo d-flex align-items-center me-auto">
        <img src="assets/img/logo.png" alt="Logo CV. Megabit Rizki Abadi">
        <h1 class="sitename">CV. Megabit Rizki Abadi</h1>
      </a>
      <nav id="navmenu" class="navmenu">
        <i class="mobile-nav-toggle d-xl-none bi-person"></i>
      </nav>
      <a href="#" class="cta-btn" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
    </div>
  </header>

  <!-- MAIN -->
  <main class="main">
    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">
      <div class="container d-flex flex-column align-items-center">
        <h2 data-aos="fade-up" data-aos-delay="100">Selamat Datang Di CV. Megabit Rizki Abadi</h2>
        <p data-aos="fade-up" data-aos-delay="200">Lihat Status Servismu Di Bawah Ini</p>
        <div class="d-flex mt-4" data-aos="fade-up" data-aos-delay="300">
          <a href="lacak.php" class="btn-get-started">Check Your Service</a>
        </div>
      </div>
    </section>
  </main>

  <!-- Modal Login -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 rounded-4 overflow-hidden shadow-lg">
        <div class="modal-header py-3 bg-primary bg-gradient text-white">
          <h4 class="modal-title d-flex align-items-center gap-2" id="loginModalLabel">
            <i class="bi bi-person-circle fs-3"></i>
            Login
          </h4>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
          <form method="POST" action="proses_login.php" autocomplete="off">
            <div class="mb-3">
              <label class="form-label fw-semibold">Username</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" name="username" class="form-control" required autofocus>
              </div>
            </div>
            <div class="mb-4">
              <label class="form-label fw-semibold">Password</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" id="loginPassword" class="form-control" required>
                <span class="input-group-text" onclick="togglePassword()" style="cursor: pointer;">
                  <i class="bi bi-eye" id="toggleIcon"></i>
                </span>
              </div>
            </div>
            <button class="btn btn-primary w-100 py-2 fw-semibold" name="login">Masuk</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Script toggle password -->
  <script>
    function togglePassword() {
      const pass = document.getElementById("loginPassword");
      const icon = document.getElementById("toggleIcon");
      if (pass.type === "password") {
        pass.type = "text";
        icon.classList.replace("bi-eye", "bi-eye-slash");
      } else {
        pass.type = "password";
        icon.classList.replace("bi-eye-slash", "bi-eye");
      }
    }
  </script>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Main JS File (dicegah error null) -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const el = document.querySelector("#navmenu");
      if (el) {
        // isi main.js Anda bisa ditempatkan di sini
      }
    });
  </script>
</body>
</html>
