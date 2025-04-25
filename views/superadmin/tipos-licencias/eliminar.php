<?php
require_once __DIR__ . '../../../../config/route.php';
require_once __DIR__ . '../../../../config/db_config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'] ?? null;

    if ($id) {
        $conex = new Database;
        $pdo = $conex->conectar();

        $stmt = $pdo->prepare("DELETE FROM tipos_licencias WHERE id = ?");
        $stmt->execute([$id]);
    }
}

header('Location: index.php');
exit;
