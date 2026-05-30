/**
 * @param {string} tipo - 'ver' o 'eliminar'
 * @param {string} dato - Ruta del archivo o ID
 * @param {string} passCorrecta - La clave que viene de la DB
 */
function verificarAccion(tipo, dato, passCorrecta) {
    // Obtenemos el nombre de la bóveda del título para que el prompt sea profesional
    const nombreBoveda = document.title.split(' - ')[0];
    
    const inputPass = prompt(`🔐 ${nombreBoveda.toUpperCase()}: Ingrese su clave de acceso:`);

    if (inputPass === null) return; // Usuario canceló

    if (inputPass === passCorrecta) {
        if (tipo === 'ver') {
            window.open(dato, '_blank');
        } else if (tipo === 'eliminar') {
            if (confirm("¿Seguro que desea eliminar este documento?")) {
                window.location.href = `subirarchivos.php?delete_id=${dato}`;
            }
        }
    } else {
        alert("❌ Contraseña incorrecta. Acceso denegado.");
    }
}