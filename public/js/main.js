document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('product-form');
    const productsTableBody = document.getElementById('products-body');
    const nombreInput = document.getElementById('nombre');
    const precioInput = document.getElementById('precio');
    const cantidadInput = document.getElementById('cantidad');
    const errorNombre = document.getElementById('error-nombre');
    const errorPrecio = document.getElementById('error-precio');
    const errorCantidad = document.getElementById('error-cantidad');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        let valid = true;

        // Validación del nombre
        if (!/^[a-zA-Z\s]+$/.test(nombreInput.value.trim())) {
            errorNombre.textContent = 'El nombre solo debe contener letras.';
            errorNombre.classList.remove('hidden');
            valid = false;
        } else {
            errorNombre.classList.add('hidden');
        }

        // Validación del precio
        if (!/^\d+(\.\d+)?$/.test(precioInput.value) || parseFloat(precioInput.value) <= 0) {
            errorPrecio.textContent = 'El precio debe ser un número positivo.';
            errorPrecio.classList.remove('hidden');
            valid = false;
        } else {
            errorPrecio.classList.add('hidden');
        }

        // Validación de la cantidad
        if (!/^\d+$/.test(cantidadInput.value) || parseInt(cantidadInput.value) <= 0) {
            errorCantidad.textContent = 'La cantidad debe ser un número entero positivo.';
            errorCantidad.classList.remove('hidden');
            valid = false;
        } else {
            errorCantidad.classList.add('hidden');
        }

        if (!valid) {
            return;
        }

        const formData = new FormData(form);
        const response = await fetch('index.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();
        if (result.success) {
            updateProductTable(result.productos);
            form.reset();
        } else {
            alert('Error al agregar el producto');
        }
    });

    async function loadProducts() {
        const response = await fetch('index.php', {
            method: 'GET'
        });
        const result = await response.json();
        updateProductTable(result.productos);
    }

    function updateProductTable(productos) {
        productsTableBody.innerHTML = '';
        productos.forEach(producto => {
            const valorTotal = producto.precio * producto.cantidad;
            const estado = producto.cantidad > 0 ? 'En Stock' : 'Agotado';
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="border border-gray-300 px-4 py-2">${producto.nombre}</td>
                <td class="border border-gray-300 px-4 py-2">$${producto.precio}</td>
                <td class="border border-gray-300 px-4 py-2">${producto.cantidad}</td>
                <td class="border border-gray-300 px-4 py-2">$${valorTotal.toFixed(2)}</td>
                <td class="border border-gray-300 px-4 py-2">${estado}</td>
            `;
            productsTableBody.appendChild(row);
        });
    }

    loadProducts();
});
