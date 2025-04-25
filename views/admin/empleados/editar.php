<?php
$title = "Editar Usuario";
require_once __DIR__ . '../../../../config/route.php';
require_once __DIR__ . '../../../../config/db_config.php';
session_start();

$conex = new Database;
$pdo = $conex->conectar();

$cedula = $_GET['cedula'] ?? null;

if (!$cedula) {
    header('Location: index.php');
    exit;
}

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

// Verificar que el usuario pertenece a la misma empresa
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE cedula = ? AND nit_empresa = ? AND rol_id = 3");
$stmt->execute([$cedula, $nitEmpresa]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    header('Location: index.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, correo = ?, contraseña = ? WHERE cedula = ? AND nit_empresa = ? AND rol_id = 3");
        $stmt->execute([$nombre, $correo, $hashedPassword, $cedula, $nitEmpresa]);
    } else {
        $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, correo = ? WHERE cedula = ? AND nit_empresa = ? AND rol_id = 3");
        $stmt->execute([$nombre, $correo, $cedula, $nitEmpresa]);
    }

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<?php include '../../../partials/head.php'; ?>

<body class="flex">
    <?php include '../../../partials/sidebar.php'; ?>

    <main class="p-6 w-full md:ml-64">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold pl-10">Editar Usuario</h1>
            <a href="<?= BASE_URL ?>views/admin/empleados/index.php"
               class="bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 px-4 rounded-xl transition">
                Volver
            </a>
        </div>

        <form method="POST" class="space-y-6 bg-white p-6 rounded-xl shadow-md">
            <div>
                <label for="cedula" class="block font-medium mb-1">Cédula</label>
                <input type="text" id="cedula" name="cedula" readonly
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none bg-gray-100"
                       value="<?= htmlspecialchars($usuario['cedula']) ?>">
            </div>

            <div>
                <label for="nombre" class="block font-medium mb-1">Nombre</label>
                <input type="text" id="nombre" name="nombre" required
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800"
                       value="<?= htmlspecialchars($usuario['nombre']) ?>">
            </div>

            <div>
                <label for="correo" class="block font-medium mb-1">Correo</label>
                <input type="email" id="correo" name="correo" required
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800"
                       value="<?= htmlspecialchars($usuario['correo']) ?>">
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
