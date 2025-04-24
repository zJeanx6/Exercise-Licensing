<?php
require_once('../config/db_config.php');
$conex = new Database;
$pdo = $conex->conectar();
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $nit_empresa = $_POST['nit_empresa'] ?: null; // opcional
    $password = $_POST['password'];
    $rol_id = $_POST['rol_id'];

    if ($cedula === '' || $nombre === '' || $correo === '' || $password === '' || $rol_id === '') {
        $mensaje = "Todos los campos excepto NIT son obligatorios.";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO usuarios (cedula, nombre, correo, nit_empresa, contraseña, rol_id) VALUES (?, ?, ?, ?, ?, ?)");

        try {
            $stmt->execute([$cedula, $nombre, $correo, $nit_empresa, $hash, $rol_id]);
            $mensaje = "✅ Usuario registrado exitosamente.";
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
  <title>Registro Usuario</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <form action="" method="POST" class="bg-white p-6 rounded-2xl shadow-md w-full max-w-sm">
    <h1 class="text-2xl font-bold mb-4 text-center">Registro de Usuario</h1>

    <?php if (isset($mensaje)): ?>
      <div class="mb-4 text-center text-sm font-medium text-red-500"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <label class="block mb-2 text-sm font-medium">Cédula</label>
    <input type="text" name="cedula" required class="w-full p-2 border rounded-xl mb-4">

    <label class="block mb-2 text-sm font-medium">Nombre</label>
    <input type="text" name="nombre" required class="w-full p-2 border rounded-xl mb-4">

    <label class="block mb-2 text-sm font-medium">Correo</label>
    <input type="email" name="correo" required class="w-full p-2 border rounded-xl mb-4">

    <label class="block mb-2 text-sm font-medium">NIT de Empresa (opcional)</label>
    <input type="text" name="nit_empresa" class="w-full p-2 border rounded-xl mb-4">

    <label class="block mb-2 text-sm font-medium">Contraseña</label>
    <input type="password" name="password" required class="w-full p-2 border rounded-xl mb-4">

    <label class="block mb-2 text-sm font-medium">Rol</label>
    <select name="rol_id" required class="w-full p-2 border rounded-xl mb-6">
      <option value="">Selecciona un rol</option>
      <option value="1">Super Admin</option>
      <option value="2">Admin</option>
      <option value="3">Empleado</option>
    </select>

    <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 rounded-xl hover:bg-blue-700">
      Registrar Usuario
    </button>
  </form>
</body>
</html>
