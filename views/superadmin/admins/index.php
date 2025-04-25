<?php
$title = "Administradores";
require_once __DIR__ . '../../../../config/route.php';
require_once __DIR__ . '../../../../config/db_config.php';
$conex = new Database;
$pdo = $conex->conectar();

$stmt = $pdo->query("SELECT usuarios.cedula, usuarios.nombre, usuarios.correo, empresas.nombre AS empresa FROM usuarios LEFT JOIN empresas ON usuarios.nit_empresa = empresas.nit WHERE usuarios.rol_id = 2;");
$admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<?php include '../../../partials/head.php'; ?>

<body class="flex">
    <?php include '../../../partials/sidebaradm.php'; ?>

    <main class="p-6 w-full md:ml-64">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold pl-10">Gestión de Administradores</h1>
            <a href="<?= BASE_URL ?>views/superadmin/admins/crear.php"
               class="bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 px-4 rounded-xl transition">
                Crear nuevo administrador
            </a>
        </div>

        <div class="overflow-x-auto rounded-xl shadow-md bg-white">
            <table class="min-w-full">
                <thead class="bg-gray-800 text-white text-left">
                    <tr>
                        <th class="px-4 py-2">Cédula</th>
                        <th class="px-4 py-2">Nombre</th>
                        <th class="px-4 py-2">Correo</th>
                        <th class="px-4 py-2">Empresa</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admins as $admin): ?>
                        <tr class="border-b hover:bg-gray-100">
                            <td class="px-4 py-2"><?= htmlspecialchars($admin['cedula']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($admin['nombre']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($admin['correo']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($admin['empresa'] ?? 'Sin asignar') ?></td>
                            <td class="px-4 py-2">
                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                    <a href="<?= BASE_URL ?>views/superadmin/admins/editar.php?cedula=<?= urlencode($admin['cedula']) ?>"
                                       class="px-4 py-2 text-sm font-medium text-white bg-blue-500 border border-blue-500 rounded-l-lg hover:bg-blue-600 focus:z-10 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                        Editar
                                    </a>
                                    <form action="<?= BASE_URL ?>views/superadmin/admins/eliminar.php" method="POST" class="inline">
                                        <input type="hidden" name="cedula" value="<?= htmlspecialchars($admin['cedula']) ?>">
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
</html>
