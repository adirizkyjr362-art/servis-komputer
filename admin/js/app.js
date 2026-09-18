async function lacakServis(form) {
    let kode = form.kode_servis.value.trim();
    if (!kode) {
        alert("Masukkan kode servis dulu!");
        return;
    }
    let res = await fetchData("admin/ajax/lacak.php?kode=" + kode);
    let box = document.getElementById("hasilLacak");
    box.innerHTML = "";

    if (res.status === "ok") {
        let d = res.data;
        box.innerHTML = `
            <div class="card mt-3">
              <div class="card-body">
                <h5>Kode Servis: ${d.kode_servis}</h5>
                <p><strong>Pelanggan:</strong> ${d.nama_pelanggan} (${d.no_hp})</p>
                <p><strong>Keluhan:</strong> ${d.keluhan}</p>
                <p><strong>Teknisi:</strong> ${d.nama_teknisi}</p>
                <p><strong>Jasa:</strong> ${d.nama_jasa ?? '-'}</p>
                <p><strong>Status:</strong> <span class="badge bg-info">${d.status}</span></p>
                <p><strong>Tanggal Masuk:</strong> ${d.tanggal_masuk}</p>
                <p><strong>Tanggal Selesai:</strong> ${d.tanggal_selesai ?? '-'}</p>
              </div>
            </div>
        `;
    } else {
        box.innerHTML = `<div class="alert alert-danger">${res.message}</div>`;
    }
}
