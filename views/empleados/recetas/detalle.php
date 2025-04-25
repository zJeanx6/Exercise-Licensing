<?php
require_once __DIR__ . '../../../../config/route.php';
require_once __DIR__ . '../../../../config/db_config.php'; // conexión PDO
$title = "Detalle de Receta";
$conex = new Database;
$pdo = $conex->conectar();

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID de receta no proporcionado.";
    exit;
}

// Obtener datos de la receta
$stmt = $pdo->prepare("SELECT * FROM recetas WHERE id = ?");
$stmt->execute([$id]);
$receta = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$receta) {
    echo "Receta no encontrada.";
    exit;
}

// Obtener ingredientes de la receta
$stmtIngredientes = $pdo->prepare("
    SELECT dr.cantidad, dr.unidad_medida, i.nombre 
    FROM detalle_recetas dr
    INNER JOIN ingredientes i ON dr.id_ingrediente = i.id
    WHERE dr.id_receta = ?
");
$stmtIngredientes->execute([$id]);
$ingredientes = $stmtIngredientes->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<?php include '../../../partials/head.php'; ?>

<body class="flex">
    <?php include '../../../partials/sidebaremple.php'; ?>

    <main class="p-6 w-full md:ml-64">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold pl-10">Detalle de la Receta</h1>
            <a href="<?= BASE_URL ?>views/empleados/recetas/index.php"
                class="bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 px-4 rounded-xl transition">
                Volver
            </a>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md space-y-6">
            <div>
                <h2 class="text-xl font-bold">Nombre de la Receta</h2>
                <p class="text-gray-600"><?= htmlspecialchars($receta['nombre']) ?></p>
            </div>
            <div>
                <h2 class="text-xl font-bold">Instrucciones</h2>
                <p class="text-gray-600"><?= nl2br(htmlspecialchars($receta['instrucciones'])) ?></p>
            </div>
            <div>
                <h2 class="text-xl font-bold">Ingredientes</h2>
                <table class="min-w-full bg-white border border-gray-300 rounded-xl">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-4 py-2 ">Ingrediente</th>
                            <th class="px-4 py-2">Cantidad</th>
                            <th class="px-4 py-2">Unidad de Medida</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ingredientes as $ingrediente): ?>
                            <tr class="border-b hover:bg-gray-100">
                                <td class="px-4 py-2 text-center"><?= htmlspecialchars($ingrediente['nombre']) ?></td>
                                <td class="px-4 py-2 text-center"><?= htmlspecialchars($ingrediente['cantidad']) ?></td>
                                <td class="px-4 py-2 text-center"><?= htmlspecialchars($ingrediente['unidad_medida']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>

</html>
