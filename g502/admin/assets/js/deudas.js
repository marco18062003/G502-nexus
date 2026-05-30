function confirmarPago(id) {
    if (confirm("¿Confirmas que el cliente ya pagó esta deuda por completo?")) {
        window.location.href = `gestion_deudas.php?completar_id=${id}`;
    }
}