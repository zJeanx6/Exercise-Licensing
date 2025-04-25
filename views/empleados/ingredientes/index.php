<?php
require_once __DIR__ . '../../../../config/route.php';
require_once __DIR__ . '../../../../config/db_config.php'; // conexión PDO
$title = "Ingredientes";
$conex = new Database;
$pdo = $conex->conectar();

// Consulta ingredientes
$stmt = $pdo->query("SELECT * FROM ingredientes");
$ingredientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<?php include '../../../partials/head.php'; ?>

<body class="flex">
    <?php include '../../../partials/sidebaremple.php'; ?>

    <main class="p-6 w-full md:ml-64">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold pl-10">Lista de ingredientes</h1>
            <a href="<?= BASE_URL ?>views/empleados/ingredientes/crear.php"
                class="bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 px-4 rounded-xl transition">
                Crear nuevo ingrediente
            </a>
        </div>

        <div class="mb-4">
            <input type="text" id="searchInput" placeholder="Buscar por ID o Nombre"
                class="w-full p-2 border border-gray-300 rounded-lg">
        </div>

        <div class="overflow-x-auto rounded-xl shadow-md bg-white">
            <table class="min-w-full" id="ingredientesTable">
                <thead class="bg-gray-800 text-white text-left">
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Nombre</th>
                        <th class="px-4 py-2">Código de Barras</th>
                        <th class="px-4 py-2">PNG</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ingredientes as $ingrediente): ?>
                        <tr class="border-b hover:bg-gray-100">
                            <td class="px-4 py-2"><?= htmlspecialchars($ingrediente['id']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($ingrediente['nombre']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($ingrediente['codigo_barras']) ?></td>
                            <td class="px-4 py-2">
                                <img src="<?= BASE_URL ?>views/empleados/ingredientes/barcodes/<?= $ingrediente['codigo_barras'] ?>.png"
                                    alt="Código de Barras"
                                    class="h-16 mx-auto">
                            </td>
                            <td class="px-4 py-2">
                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                    <a href="<?= BASE_URL ?>views/empleados/ingredientes/editar.php?id=<?= $ingrediente['id'] ?>"
                                        class="px-4 py-2 text-sm font-medium text-white bg-blue-500 border border-blue-500 rounded-l-lg hover:bg-blue-600 focus:z-10 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                        Editar
                                    </a>
                                    <a href="<?= BASE_URL ?>views/empleados/ingredientes/barcodes/<?= $ingrediente['codigo_barras'] ?>.png"
                                        download="<?= $ingrediente['codigo_barras'] ?>.png"
                                        class="px-4 py-2 text-sm font-medium text-white bg-green-500 border border-green-500 hover:bg-green-600 focus:z-10 focus:ring-2 focus:ring-green-500 focus:outline-none">
                                        Descargar
                                    </a>
                                    <form action="<?= BASE_URL ?>views/empleados/ingredientes/eliminar.php" method="POST" class="inline">
                                        <input type="hidden" name="id" value="<?= $ingrediente['id'] ?>">
                                        <button type="submit"
                                            class="px-4 py-2 text-sm font-medium text-white bg-red-500 border border-red-500 rounded-r-lg hover:bg-red-600 focus:z-10 focus:ring-2 focus:ring-red-500 focus:outline-none">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </main>
</body>

<script>
    document.getElementById('searchInput').addEventListener('input', function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#ingredientesTable tbody tr');

        rows.forEach(row => {
            const id = row.cells[0].textContent.toLowerCase();
            const nombre = row.cells[1].textContent.toLowerCase();
            const codigoBarras = row.cells[2].textContent.toLowerCase();

            if (id.includes(filter) || nombre.includes(filter) || codigoBarras.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

</html>