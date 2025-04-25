<?php
require_once __DIR__ . '../../../../config/route.php';
require_once __DIR__ . '../../../../config/db_config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cedula = $_POST['cedula'] ?? null;

    if ($cedula) {
        $conex = new Database;
        $pdo = $conex->conectar();

        // Eliminar administrador
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE cedula = ? AND rol_id = 2");
        $stmt->execute([$cedula]);
    }
}

header('Location: index.php');
exit;
