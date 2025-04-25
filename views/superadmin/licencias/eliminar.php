<?php
require_once __DIR__ . '../../../../config/route.php';
require_once __DIR__ . '../../../../config/db_config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $licencia = $_POST['licencia'] ?? null;

    if ($licencia) {
        $conex = new Database;
        $pdo = $conex->conectar();

        // Eliminar licencia
        $stmt = $pdo->prepare("DELETE FROM licencias WHERE licencia = ?");
        $stmt->execute([$licencia]);
    }
}

header('Location: index.php');
exit;
