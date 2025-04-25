<?php
$title = "Editar Tipo de Licencia";
require_once __DIR__ . '../../../../config/route.php';
require_once __DIR__ . '../../../../config/db_config.php';
$conex = new Database;
$pdo = $conex->conectar();

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM tipos_licencias WHERE id = ?");
$stmt->execute([$id]);
$tipo = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tipo) {
    header('Location: index.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $duracion = $_POST['duracion'];
    $precio = $_POST['precio'];

    $stmt = $pdo->prepare("UPDATE tipos_licencias SET nombre = ?, duracion = ?, precio = ? WHERE id = ?");
    $stmt->execute([$nombre, $duracion, $precio, $id]);

    header('Location: index.php');
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
            <h1 class="text-2xl font-bold pl-10">Editar Tipo de Licencia</h1>
            <a href="<?= BASE_URL ?>views/superadmin/tipos-licencias/index.php"
               class="bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 px-4 rounded-xl transition">
                Volver
            </a>
        </div>

        <form method="POST" class="space-y-6 bg-white p-6 rounded-xl shadow-md">
            <div>
                <label for="nombre" class="block font-medium mb-1">Nombre</label>
                <input type="text" id="nombre" name="nombre" required
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none"
                       value="<?= htmlspecialchars($tipo['nombre']) ?>">
            </div>
            <div>
                <label for="duracion" class="block font-medium mb-1">Duración (días)</label>
                <input type="number" id="duracion" name="duracion" required
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none"
                       value="<?= htmlspecialchars($tipo['duracion']) ?>">
            </div>
            <div>
                <label for="precio" class="block font-medium mb-1">Precio</label>
                <input type="number" step="0.01" id="precio" name="precio" required
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none"
                       value="<?= htmlspecialchars($tipo['precio']) ?>">
            </div>
            <button type="submit"
                    class="w-full bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 rounded-xl transition">
                Guardar Cambios
            </button>
        </form>
    </main>
</body>
</html>
