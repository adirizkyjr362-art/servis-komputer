window.addEventListener("DOMContentLoaded", () => {
    const table = document.getElementById("datatablesSimple");
    if (table && typeof simpleDatatables !== "undefined") {
        new simpleDatatables.DataTable(table);
    }
});
