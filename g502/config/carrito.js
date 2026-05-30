// carrito.js - Lógica JavaScript para el control de cantidad y añadir al carrito

document.addEventListener('DOMContentLoaded', () => {
    // --- Lógica para botones de cantidad (ajusta esto si ya lo tienes) ---
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', (event) => {
            const productId = event.target.dataset.id;
            const quantityInput = document.getElementById(`quantity-${productId}`);
            let quantity = parseInt(quantityInput.value);

            if (event.target.classList.contains('increase-quantity')) {
                quantity++;
            } else if (event.target.classList.contains('decrease-quantity') && quantity > 1) {
                quantity--;
            }
            quantityInput.value = quantity;
        });
    });

    // --- Manejo del botón "Agregar al carrito" ---
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', (event) => {
            const productId = event.target.dataset.id;
            const quantityInput = document.getElementById(`quantity-${productId}`);
            const quantity = parseInt(quantityInput.value);

            console.log(`Producto ID: ${productId}, Cantidad: ${quantity} - Preparando envío a add_to_cart.php...`);

            // ¡¡¡¡RUTA CORREGIDA AQUÍ!!!!
            // Esta ruta es relativa desde la página HTML que carga este JS (ej. index.php en Publico1)
            // Sube un nivel (de Publico1 a PUBLIC), luego baja a Config.
            fetch('../config/add_to_cart.php', { 
                method: 'POST', // Esto es clave: la solicitud debe ser POST
                headers: {
                    'Content-Type': 'application/json', // Informa al servidor que enviamos JSON
                },
                body: JSON.stringify({ // Convierte los datos a JSON antes de enviarlos
                    product_id: productId,
                    quantity: quantity
                }),
            })
            .then(response => {
                // Si la respuesta no es OK (ej. 404, 500), leemos el texto para diagnosticar errores HTML/PHP
                if (!response.ok) {
                    return response.text().then(text => {
                        throw new Error(`Error HTTP: ${response.status}. Respuesta del servidor: ${text}`);
                    });
                }
                // Si la respuesta es OK, intentamos parsearla como JSON
                return response.json();
            })
            .then(data => {
                console.log('Respuesta del servidor:', data);
                if (data.success) {
                    alert('Producto añadido al carrito con éxito!');
                    // Aquí podrías actualizar un contador de artículos en el carrito si tu PHP lo devuelve
                    // if (data.cart_total_items !== undefined) {
                    //     document.getElementById('cart-counter').textContent = data.cart_total_items;
                    // }
                } else {
                    // Si el servidor envía { success: false, message: "..." }
                    alert('Hubo un error al añadir el producto: ' + data.message);
                }
            })
            .catch((error) => {
                // Esto captura errores de red o errores al procesar la respuesta (ej. JSON inválido)
                console.error('Error en la solicitud Fetch o al procesar la respuesta:', error);
                alert('Hubo un problema de conexión o con la respuesta del servidor. Revisa la consola (F12) para más detalles.');
            });
        });
    });
});