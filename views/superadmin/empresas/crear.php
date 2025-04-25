<?php
$title = "Crear Empresa";
require_once __DIR__ . '../../../../config/route.php';
require_once __DIR__ . '../../../../config/db_config.php';
$conex = new Database;
$pdo = $conex->conectar();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nit = $_POST['nit'];
    $nombre = $_POST['nombre'];

    // Insertar empresa
    $stmt = $pdo->prepare("INSERT INTO empresas (nit, nombre) VALUES (?, ?)");
    $stmt->execute([$nit, $nombre]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<?php include '../../../partials/head.php'; ?>

<body class="flex">
    <?php include '../../../partials/sidebaradm.php'; ?>

    <main class="p-6 w-full md:ml-64">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold pl-10">Crear Nueva Empresa</h1>
            <a href="<?= BASE_URL ?>views/superadmin/empresas/index.php"
               class="bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 px-4 rounded-xl transition">
                Volver
            </a>
        </div>

        <form method="POST" class="space-y-6 bg-white p-6 rounded-xl shadow-md">
            <div>
                <label for="nit" class="block font-medium mb-1">NIT</label>
                <input type="text" id="nit" name="nit" required
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800">
            </div>

            <div>
                <label for="nombre" class="block font-medium mb-1">Nombre</label>
                <input type="text" id="nombre" name="nombre" required
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800">
            </div>

            <button type="submit"
                    class="w-full bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 rounded-xl transition">
                Guardar Empresa
            </button>
        </form>
    </main>
</body>
</html>
