<?php
require_once __DIR__ . '../../../../config/route.php';
require_once __DIR__ . '../../../../config/db_config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nit = $_POST['nit'] ?? null;

    if ($nit) {
        $conex = new Database;
        $pdo = $conex->conectar();

        // Eliminar empresa
        $stmt = $pdo->prepare("DELETE FROM empresas WHERE nit = ?");
        $stmt->execute([$nit]);
    }
}

header('Location: index.php');
exit;
