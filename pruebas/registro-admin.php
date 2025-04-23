<?php
require_once('../config/db_config.php');
$conex = new Database;
$pdo = $conex->conectar();
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cedula = $_POST['cedula'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validar campos vacíos
    if ($cedula === '' || $nombre === '' || $correo === '' || $password === '') {
        $mensaje = "Todos los campos son obligatorios.";
    } else {
        // Hashear contraseña
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // Insertar en la base de datos
        $stmt = $pdo->prepare("INSERT INTO admin (cedula, nombre, correo, contraseña) VALUES (?, ?, ?, ?)");

        try {
            $stmt->execute([$cedula, $nombre, $correo, $hash]);
            $mensaje = "✅ Admin registrado exitosamente.";
        } catch (PDOException $e) {
            $mensaje = "❌ Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registrar Admin</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <form action="" method="POST" class="bg-white p-6 rounded-2xl shadow-md w-full max-w-sm">
    <h1 class="text-2xl font-bold mb-4 text-center">Registro Admin</h1>

    <?php if (isset($mensaje)): ?>
      <div class="mb-4 text-center text-sm font-medium text-red-500"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <label class="block mb-2 text-sm font-medium">Cédula</label>
    <input type="text" name="cedula" required class="w-full p-2 border rounded-xl mb-4">

    <label class="block mb-2 text-sm font-medium">Nombre</label>
    <input type="text" name="nombre" required class="w-full p-2 border rounded-xl mb-4">

    <label class="block mb-2 text-sm font-medium">Correo</label>
    <input type="email" name="correo" required class="w-full p-2 border rounded-xl mb-4">

    <label class="block mb-2 text-sm font-medium">Contraseña</label>
    <input type="password" name="password" required class="w-full p-2 border rounded-xl mb-6">

    <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 rounded-xl hover:bg-blue-700">
      Registrar Admin
    </button>
  </form>
</body>
</html>
