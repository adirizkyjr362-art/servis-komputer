<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

<script src="js/scripts.js"></script>

<!-- Chart.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

<!-- Simple DataTables -->
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="js/datatables-simple-demo.js"></script>

<!-- JavaScript Data Servis -->
<script src="js/servis.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Animasi -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css"/>

<!-- Notifikasi Berhasil -->
<?php if (isset($_SESSION['success'])): ?>

<script>
Swal.fire({
    toast: true,
    position: 'top',
    icon: 'success',
    title: '<?= htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8') ?>',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    background: '#ecfdf5',
    iconColor: '#16a34a',
    customClass: {
        popup: 'animate__animated animate__fadeInDown'
    }
});
</script>

<?php
unset($_SESSION['success']);
endif;
?>

<!-- Notifikasi Error -->
<?php if (isset($_SESSION['error'])): ?>

<script>
Swal.fire({
    toast: true,
    position: 'top',
    icon: 'error',
    title: '<?= htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8') ?>',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    background: '#fef2f2',
    iconColor: '#dc2626',
    customClass: {
        popup: 'animate__animated animate__fadeInDown'
    }
});
</script>

<?php
unset($_SESSION['error']);
endif;
?>

<script>
function togglePelanggan() {
    const jenis = document.getElementById('jenis_pelanggan').value;
    const formLama = document.getElementById('formPelangganLama');
    const formBaru = document.querySelectorAll('.form-pelanggan-baru');

    if (jenis === 'lama') {
        formLama.style.display = 'block';
        formBaru.forEach(f => f.style.display = 'none');
    } else {
        formLama.style.display = 'none';
        formBaru.forEach(f => f.style.display = 'block');
    }
}

function isiDataPelanggan(select) {
    const nama = select.options[select.selectedIndex].getAttribute('data-nama');
    const nohp = select.options[select.selectedIndex].getAttribute('data-nohp');
    const alamat = select.options[select.selectedIndex].getAttribute('data-alamat');

    document.getElementById('nama_pelanggan').value = nama || '';
    document.getElementById('no_hp').value = nohp || '';
    document.getElementById('alamat').value = alamat || '';
}
</script>