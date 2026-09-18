<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Utama</div>
            <a class="nav-link" href="index.php"><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>Dashboard</a>
            <a class="nav-link" href="tambah_servis.php"><div class="sb-nav-link-icon"><i class="fa-solid fa-plus"></i></div>Servis</a>
            <a class="nav-link" href="daftar_servis.php"><div class="sb-nav-link-icon"><i class="fa-solid fa-clipboard-list"></i></div>Daftar Servis</a>
        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="small">Logged in as:</div>
        <?= htmlspecialchars($_SESSION['nama']); ?>
    </div>
</nav>
