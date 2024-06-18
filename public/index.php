<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos del Minimarket</title>
    <link href="./css/tailwind.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <!-- Header -->
    <header class="bg-blue-600 text-white p-4 mb-6">
        <h1 class="text-3xl font-bold">Gestión de Productos del Minimarket</h1>
    </header>

    <!-- Form Section -->
    <div class="container mx-auto mb-6">
        <form id="product-form" class="bg-white p-6 rounded shadow-md">
            <div class="mb-4">
                <label for="nombre" class="block text-gray-700">Nombre del Producto:</label>
                <input type="text" id="nombre" name="nombre" class="w-full p-2 border border-gray-300 rounded mt-2" required>
                <span id="error-nombre" class="text-red-500 text-sm hidden"></span>
            </div>
            <div class="mb-4">
                <label for="precio" class="block text-gray-700">Precio por Unidad:</label>
                <input type="number" id="precio" name="precio" class="w-full p-2 border border-gray-300 rounded mt-2" step="0.01" required>
                <span id="error-precio" class="text-red-500 text-sm hidden"></span>
            </div>
            <div class="mb-4">
                <label for="cantidad" class="block text-gray-700">Cantidad en Inventario:</label>
                <input type="number" id="cantidad" name="cantidad" class="w-full p-2 border border-gray-300 rounded mt-2" required>
                <span id="error-cantidad" class="text-red-500 text-sm hidden"></span>
            </div>
            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Agregar Producto</button>
        </form>
    </div>

    <!-- Product List Section -->
    <div class="container mx-auto">
        <div id="product-list" class="bg-white p-6 rounded shadow-md">
            <h2 class="text-2xl font-bold mb-4">Productos en Inventario</h2>
            <table id="products-table" class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2">Nombre del Producto</th>
                        <th class="border border-gray-300 px-4 py-2">Precio por Unidad</th>
                        <th class="border border-gray-300 px-4 py-2">Cantidad en Inventario</th>
                        <th class="border border-gray-300 px-4 py-2">Valor Total</th>
                        <th class="border border-gray-300 px-4 py-2">Estado</th>
                    </tr>
                </thead>
                <tbody id="products-body"></tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white p-4 mt-6 text-center">
        <p>&copy; 2024 Minimarket</p>
    </footer>

    <script src="./js/main.js"></script>
</body>
</html>

<?php
session_start();

if (!isset($_SESSION['productos'])) {
    $_SESSION['productos'] = [];
}

function agregarProducto($nombre, $precio, $cantidad) {
    $producto = [
        'nombre' => $nombre,
        'precio' => $precio,
        'cantidad' => $cantidad
    ];

    $_SESSION['productos'][] = $producto;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];

    agregarProducto($nombre, $precio, $cantidad);

    echo json_encode(['success' => true, 'productos' => $_SESSION['productos']]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode(['productos' => $_SESSION['productos']]);
    exit;
}
?>
