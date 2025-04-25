<?php
$title = "Crear Usuario";
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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Insertar usuario con rol predeterminado (rol_id = 3)
    $stmt = $pdo->prepare("INSERT INTO usuarios (cedula, nombre, correo, nit_empresa, contraseña, rol_id) VALUES (?, ?, ?, ?, ?, 3)");
    $stmt->execute([$cedula, $nombre, $correo, $nitEmpresa, $password]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<?php include '../../../partials/head.php'; ?>

<body onload="register.cedula.focus()" class="flex">
    <?php include '../../../partials/sidebar.php'; ?>

    <main class="p-6 w-full md:ml-64">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold pl-10">Crear Nuevo Usuario</h1>
            <a href="<?= BASE_URL ?>views/admin/empleados/index.php"
               class="bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 px-4 rounded-xl transition">
                Volver
            </a>
        </div>

        <form method="POST" class="space-y-6 bg-white p-6 rounded-xl shadow-md" name="register">
            <div>
                <label for="cedula" class="block font-medium mb-1">Cédula</label>
                <input type="text" id="cedula" name="cedula" required tabindex="1"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800">
            </div>

            <div>
                <label for="nombre" class="block font-medium mb-1">Nombre</label>
                <input type="text" id="nombre" name="nombre" required tabindex="3"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800">
            </div>

            <div>
                <label for="correo" class="block font-medium mb-1">Correo</label>
                <input type="email" id="correo" name="correo" required tabindex="2"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800">
            </div>

            <div>
                <label for="password" class="block font-medium mb-1">Contraseña</label>
                <input type="password" id="password" name="password" required tabindex="4"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800">
            </div>

            <button type="submit" tabindex="5"
                    class="w-full bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 rounded-xl transition">
                Guardar Usuario
            </button>
        </form>
    </main>
</body>
</html>
