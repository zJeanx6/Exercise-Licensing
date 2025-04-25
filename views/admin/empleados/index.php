<?php
$title = "Usuarios";
require_once __DIR__ . '../../../../config/route.php';
require_once __DIR__ . '../../../../config/db_config.php';
session_start();

$conex = new Database;
$pdo = $conex->conectar();

// Obtener el NIT de la empresa del administrador
$adminCedula = $_SESSION['user']['cedula'] ?? null;
$stmt = $pdo->prepare("SELECT nit_empresa FROM usuarios WHERE cedula = ? AND rol_id = 2");
$stmt->execute([$adminCedula]);
$adminEmpresa = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$adminEmpresa) {
    echo "No se pudo determinar la empresa del administrador.";
    exit;
}

$nitEmpresa = $adminEmpresa['nit_empresa'];

// Consultar usuarios relacionados con la empresa
$stmt = $pdo->prepare("SELECT cedula, nombre, correo FROM usuarios WHERE nit_empresa = ? AND rol_id = 3");
$stmt->execute([$nitEmpresa]);
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<?php include '../../../partials/head.php'; ?>

<body class="flex">
    <?php include '../../../partials/sidebar.php'; ?>

    <main class="p-6 w-full md:ml-64">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold pl-10">Gestión de Usuarios</h1>
            <a href="<?= BASE_URL ?>views/admin/empleados/crear.php"
               class="bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 px-4 rounded-xl transition">
                Crear nuevo usuario
            </a>
        </div>

        <div class="overflow-x-auto rounded-xl shadow-md bg-white">
            <table class="min-w-full">
                <thead class="bg-gray-800 text-white text-left">
                    <tr>
                        <th class="px-4 py-2">Cédula</th>
                        <th class="px-4 py-2">Nombre</th>
                        <th class="px-4 py-2">Correo</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr class="border-b hover:bg-gray-100">
                            <td class="px-4 py-2"><?= htmlspecialchars($usuario['cedula']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($usuario['nombre']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($usuario['correo']) ?></td>
                            <td class="px-4 py-2">
                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                    <a href="<?= BASE_URL ?>views/admin/empleados/editar.php?cedula=<?= urlencode($usuario['cedula']) ?>"
                                       class="px-4 py-2 text-sm font-medium text-white bg-blue-500 border border-blue-500 rounded-l-lg hover:bg-blue-600">
                                        Editar
                                    </a>
                                    <form action="<?= BASE_URL ?>views/admin/empleados/eliminar.php" method="POST" class="inline">
                                        <input type="hidden" name="cedula" value="<?= htmlspecialchars($usuario['cedula']) ?>">
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
