<?php
$title = "Tipos de Licencias";
require_once __DIR__ . '../../../../config/route.php';
require_once __DIR__ . '../../../../config/db_config.php';
$conex = new Database;
$pdo = $conex->conectar();

// Consultar tipos de licencias
$stmt = $pdo->query("SELECT * FROM tipos_licencias");
$tiposLicencias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<?php include '../../../partials/head.php'; ?>

<body class="flex">
    <?php include '../../../partials/sidebaradm.php'; ?>

    <main class="p-6 w-full md:ml-64">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold pl-10">Gestión de Tipos de Licencias</h1>
            <a href="<?= BASE_URL ?>views/superadmin/tipos-licencias/crear.php"
               class="bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 px-4 rounded-xl transition">
                Crear nuevo tipo de licencia
            </a>
        </div>

        <div class="overflow-x-auto rounded-xl shadow-md bg-white">
            <table class="min-w-full">
                <thead class="bg-gray-800 text-white text-left">
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Nombre</th>
                        <th class="px-4 py-2">Duración (días)</th>
                        <th class="px-4 py-2">Precio</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tiposLicencias as $tipo): ?>
                        <tr class="border-b hover:bg-gray-100">
                            <td class="px-4 py-2"><?= htmlspecialchars($tipo['id']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($tipo['nombre']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($tipo['duracion']) ?></td>
                            <td class="px-4 py-2">$<?= htmlspecialchars(number_format($tipo['precio'], 2)) ?></td>
                            <td class="px-4 py-2">
                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                    <a href="<?= BASE_URL ?>views/superadmin/tipos-licencias/editar.php?id=<?= $tipo['id'] ?>"
                                       class="px-4 py-2 text-sm font-medium text-white bg-blue-500 border border-blue-500 rounded-l-lg hover:bg-blue-600">
                                        Editar
                                    </a>
                                    <form action="<?= BASE_URL ?>views/superadmin/tipos-licencias/eliminar.php" method="POST" class="inline">
                                        <input type="hidden" name="id" value="<?= $tipo['id'] ?>">
                                        <button type="submit"
                                                class="px-4 py-2 text-sm font-medium text-white bg-red-500 border border-red-500 rounded-r-lg hover:bg-red-600">
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
</html>
