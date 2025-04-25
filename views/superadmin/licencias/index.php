<?php
$title = "Licencias";
require_once __DIR__ . '../../../../config/route.php';
require_once __DIR__ . '../../../../config/db_config.php';
?>

<!DOCTYPE html>
<html lang="es">
<?php include '../../../partials/head.php'; ?>

<body class="flex">
    <?php include '../../../partials/sidebaradm.php'; ?>

    <div id="overlay"
        class="fixed inset-0 bg-[rgba(0,0,0,0.4)] z-30 hidden md:hidden"
        onclick="toggleSidebar()">
    </div>

    <main class="p-6 w-full md:ml-64">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold pl-10">Gestión de Licencias</h1>
            <a href="<?= BASE_URL ?>views/superadmin/licencias/crear.php"
                class="bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 px-4 rounded-xl transition">
                Crear nueva licencia
            </a>
        </div>

        <div class="overflow-x-auto rounded-xl shadow-md bg-white">
            <table class="min-w-full">
                <thead class="bg-gray-800 text-white text-left">
                    <tr>
                        <th scope="col" class="px-6 py-3">Licencia</th>
                        <th scope="col" class="px-6 py-3">Empresa</th>
                        <th scope="col" class="px-6 py-3">Fecha Compra</th>
                        <th scope="col" class="px-6 py-3">Fecha Fin</th>
                        <th scope="col" class="px-6 py-3">Estado</th>
                        <th scope="col" class="px-6 py-3">Tipo</th>
                        <th scope="col" class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí se iterarán las licencias desde la base de datos -->
                    <?php
                    $conex = new Database;
                    $pdo = $conex->conectar();
                    $stmt = $pdo->query("SELECT l.licencia, e.nombre AS empresa, l.fecha_compra, l.fecha_fin, es.nombre AS estado, t.nombre AS tipo 
                               FROM licencias l
                               LEFT JOIN empresas e ON l.nit_empresa = e.nit
                               LEFT JOIN estados es ON l.id_estado = es.id
                               LEFT JOIN tipos_licencias t ON l.id_tipo_licencia = t.id");
                    while ($licencia = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4"><?= htmlspecialchars($licencia['licencia']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($licencia['empresa']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($licencia['fecha_compra']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($licencia['fecha_fin']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($licencia['estado']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($licencia['tipo']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                    <a href="<?= BASE_URL ?>views/superadmin/licencias/editar.php?id=<?= urlencode($licencia['licencia']) ?>"
                                        class="px-4 py-2 text-sm font-medium text-white bg-blue-500 border border-blue-500 rounded-l-lg hover:bg-blue-600 focus:z-10 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                        Editar
                                    </a>
                                    <form action="<?= BASE_URL ?>views/superadmin/licencias/eliminar.php" method="POST" class="inline">
                                        <input type="hidden" name="licencia" value="<?= htmlspecialchars($licencia['licencia']) ?>">
                                        <button type="submit"
                                            class="px-4 py-2 text-sm font-medium text-white bg-red-500 border border-red-500 rounded-r-lg hover:bg-red-600 focus:z-10 focus:ring-2 focus:ring-red-500 focus:outline-none">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>