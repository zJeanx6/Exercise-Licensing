<?php

$title = "Dashboard";
require_once __DIR__ . '../../../config/route.php';
require_once __DIR__ . '../../../config/db_config.php';

$conex = new Database;
$pdo = $conex->conectar();

// Obtener estadísticas
$totalEmpresas = $pdo->query("SELECT COUNT(*) AS total FROM empresas")->fetch(PDO::FETCH_ASSOC)['total'];
$totalLicencias = $pdo->query("SELECT COUNT(*) AS total FROM licencias")->fetch(PDO::FETCH_ASSOC)['total'];
$licenciasActivas = $pdo->query("SELECT COUNT(*) AS total FROM licencias WHERE id_estado = 1")->fetch(PDO::FETCH_ASSOC)['total'];
$licenciasExpiradas = $pdo->query("SELECT COUNT(*) AS total FROM licencias WHERE id_estado = 2")->fetch(PDO::FETCH_ASSOC)['total'];
?>

<!DOCTYPE html>
<html lang="es">
<?php include '../../partials/head.php'; ?>

<body class="flex">
    <?php include '../../partials/sidebaradm.php'; ?>

    <main class="p-6 w-full md:ml-64">
        <div class="mb-6">
            <h1 class="text-3xl font-bold">Dashboard del Superadmin</h1>
            <p class="text-gray-600">Resumen general del sistema</p>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-bold text-gray-800">Total Empresas</h2>
                <p class="text-3xl font-semibold text-gray-900"><?= $totalEmpresas ?></p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-bold text-gray-800">Total Licencias</h2>
                <p class="text-3xl font-semibold text-gray-900"><?= $totalLicencias ?></p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-bold text-gray-800">Licencias Activas</h2>
                <p class="text-3xl font-semibold text-green-600"><?= $licenciasActivas ?></p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-bold text-gray-800">Licencias Expiradas</h2>
                <p class="text-3xl font-semibold text-red-600"><?= $licenciasExpiradas ?></p>
            </div>
        </div>

        <!-- Enlaces rápidos -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-2xl font-bold mb-4">Enlaces Rápidos</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <a href="<?= BASE_URL ?>views/superadmin/empresas/index.php"
                   class="block bg-gray-800 hover:bg-gray-900 text-white font-semibold py-4 px-6 rounded-xl text-center transition">
                    Gestionar Empresas
                </a>
                <a href="<?= BASE_URL ?>views/superadmin/licencias/index.php"
                   class="block bg-gray-800 hover:bg-gray-900 text-white font-semibold py-4 px-6 rounded-xl text-center transition">
                    Gestionar Licencias
                </a>
            </div>
        </div>
    </main>
</body>
</html>