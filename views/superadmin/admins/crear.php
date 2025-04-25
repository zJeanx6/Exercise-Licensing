<?php
$title = "Crear Administrador";
require_once __DIR__ . '../../../../config/route.php';
require_once __DIR__ . '../../../../config/db_config.php';
$conex = new Database;
$pdo = $conex->conectar();

// Obtener empresas
$empresas = $pdo->query("SELECT nit, nombre FROM empresas")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $nit_empresa = $_POST['nit_empresa'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Insertar administrador
    $stmt = $pdo->prepare("INSERT INTO usuarios (cedula, nombre, correo, nit_empresa, contraseña, rol_id) VALUES (?, ?, ?, ?, ?, 2)");
    $stmt->execute([$cedula, $nombre, $correo, $nit_empresa, $password]);

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
            <h1 class="text-2xl font-bold pl-10">Crear Nuevo Administrador</h1>
            <a href="<?= BASE_URL ?>views/superadmin/admins/index.php"
               class="bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 px-4 rounded-xl transition">
                Volver
            </a>
        </div>

        <form method="POST" class="space-y-6 bg-white p-6 rounded-xl shadow-md">
            <div>
                <label for="cedula" class="block font-medium mb-1">Cédula</label>
                <input type="text" id="cedula" name="cedula" required
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800">
            </div>

            <div>
                <label for="nombre" class="block font-medium mb-1">Nombre</label>
                <input type="text" id="nombre" name="nombre" required
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800">
            </div>

            <div>
                <label for="correo" class="block font-medium mb-1">Correo</label>
                <input type="email" id="correo" name="correo" required
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800">
            </div>

            <div>
                <label for="nit_empresa" class="block font-medium mb-1">Empresa</label>
                <select id="nit_empresa" name="nit_empresa" required
                        class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800">
                    <option value="">Seleccione una empresa</option>
                    <?php foreach ($empresas as $empresa): ?>
                        <option value="<?= $empresa['nit'] ?>"><?= htmlspecialchars($empresa['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="password" class="block font-medium mb-1">Contraseña</label>
                <input type="password" id="password" name="password" required
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800">
            </div>

            <button type="submit"
                    class="w-full bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 rounded-xl transition">
                Guardar Administrador
            </button>
        </form>
    </main>
</body>
</html>
