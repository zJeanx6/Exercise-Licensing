<?php
require_once __DIR__ . '/../../config/route.php';
require_once __DIR__ . '/../../config/db_config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'] ?? null;

    if ($id) {
        $conex = new Database;
        $pdo = $conex->conectar();

        // Eliminar registros relacionados en detalle_receta
        $stmtDetalle = $pdo->prepare("DELETE FROM detalle_recetas WHERE id_ingrediente = ?");
        $stmtDetalle->execute([$id]);

        // Eliminar ingrediente
        $stmt = $pdo->prepare("DELETE FROM ingredientes WHERE id = ?");
        $stmt->execute([$id]);
    }
}

header('Location: index.php');
exit;
