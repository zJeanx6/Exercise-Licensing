<?php
$title = "Editar Administrador";
require_once __DIR__ . '../../../../config/route.php';
require_once __DIR__ . '../../../../config/db_config.php';
$conex = new Database;
$pdo = $conex->conectar();

$cedula = $_GET['cedula'] ?? null;

if (!$cedula) {
    header('Location: index.php');
    exit;
}

// Obtener datos del administrador
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE cedula = ? AND rol_id = 2");
$stmt->execute([$cedula]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$admin) {
    header('Location: index.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, correo = ?, contraseña = ? WHERE cedula = ? AND rol_id = 2");
        $stmt->execute([$nombre, $correo, $hashedPassword, $cedula]);
    } else {
        $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, correo = ? WHERE cedula = ? AND rol_id = 2");
        $stmt->execute([$nombre, $correo, $cedula]);
    }

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
            <h1 class="text-2xl font-bold pl-10">Editar Administrador</h1>
            <a href="<?= BASE_URL ?>views/superadmin/admins/index.php"
               class="bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 px-4 rounded-xl transition">
                Volver
            </a>
        </div>

        <form method="POST" class="space-y-6 bg-white p-6 rounded-xl shadow-md">
            <div>
                <label for="cedula" class="block font-medium mb-1">Cédula</label>
                <input type="text" id="cedula" name="cedula" readonly
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none bg-gray-100"
                       value="<?= htmlspecialchars($admin['cedula']) ?>">
            </div>

            <div>
                <label for="nombre" class="block font-medium mb-1">Nombre</label>
                <input type="text" id="nombre" name="nombre" required
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800"
                       value="<?= htmlspecialchars($admin['nombre']) ?>">
            </div>

            <div>
                <label for="correo" class="block font-medium mb-1">Correo</label>
                <input type="email" id="correo" name="correo" required
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800"
                       value="<?= htmlspecialchars($admin['correo']) ?>">
            </div>

            <div>
                <label for="password" class="block font-medium mb-1">Nueva Contraseña (opcional)</label>
                <input type="password" id="password" name="password"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800"
                       placeholder="Dejar en blanco para no cambiar">
            </div>

            <button type="submit"
                    class="w-full bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 rounded-xl transition">
                Guardar Cambios
            </button>
        </form>
    </main>
</body>
</html>
