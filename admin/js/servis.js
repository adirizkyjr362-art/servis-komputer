document.addEventListener("DOMContentLoaded", function () {

    const tabelServis = document.getElementById("datatablesSimple");

    // Array of Objects untuk menampung data servis dari tabel.
    const dataServis = [];

    if (tabelServis) {

        const baris = tabelServis.querySelectorAll("tbody tr");

        baris.forEach(function (row) {

            const kolom = row.querySelectorAll("td");
            if (kolom.length >= 7) {

                dataServis.push({
                    kode: kolom[1].innerText.trim(),
                    pelanggan: kolom[4].innerText.trim(),
                    status: kolom[6].innerText.trim()
                });

            }
        });

        // Menampilkan seluruh isi Array pada Console.
        console.log("Data servis:", dataServis);

        // Menampilkan jumlah data servis.
        console.log(
            "Jumlah data servis yang ditampilkan:",
            dataServis.length
        );

        // Menampilkan jumlah baris tabel.
        console.log(
            "Jumlah baris tabel yang ditemukan:",
            baris.length
        );

        // Pemeriksaan hasil debugging.
        if (dataServis.length > 0) {

            console.log(
                "Status debugging: Data servis berhasil dibaca."
            );

        } else {

            console.warn(
                "Status debugging: Tidak ada data servis yang berhasil dibaca."
            );
        }

    } else {

        console.error(
            "Debugging Error: Tabel dengan ID 'datatablesSimple' tidak ditemukan."
        );
    }


    // Validasi form tambah servis.
    const formServis = document.querySelector(
        'form[action="proses_servis.php"]'
    );

    if (formServis) {

        formServis.addEventListener("submit", function (event) {

            const namaPelanggan = formServis.querySelector(
                '[name="nama_pelanggan"]'
            );

            const keluhan = formServis.querySelector(
                '[name="keluhan"]'
            );

            if (
                !namaPelanggan ||
                !keluhan ||
                !namaPelanggan.value.trim() ||
                !keluhan.value.trim()
            ) {

                event.preventDefault();

                alert(
                    "Nama pelanggan dan keluhan wajib diisi."
                );

                console.warn(
                    "Validasi gagal: Nama pelanggan atau keluhan belum diisi."
                );

            } else {

                console.log(
                    "Validasi form berhasil."
                );
            }
        });

    }


    // Mengaktifkan DataTables.
    if (
        tabelServis &&
        typeof simpleDatatables !== "undefined"
    ) {

        new simpleDatatables.DataTable(tabelServis);

        console.log(
            "DataTables berhasil diaktifkan."
        );

    } else if (tabelServis) {

        console.warn(
            "Library Simple DataTables tidak ditemukan."
        );
    }


    // Informasi bahwa JavaScript berhasil dijalankan.
    console.log(
        "JavaScript halaman data servis berhasil dijalankan."
    );

});