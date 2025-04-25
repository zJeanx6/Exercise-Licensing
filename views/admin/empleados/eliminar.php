<?php
require_once __DIR__ . '../../../../config/route.php';
require_once __DIR__ . '../../../../config/db_config.php';
session_start();

$conex = new Database;
$pdo = $conex->conectar();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cedula = $_POST['cedula'] ?? null;

    if ($cedula) {
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
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE cedula = ? AND nit_empresa = ? AND rol_id = 3");
        $stmt->execute([$cedula, $nitEmpresa]);
    }
}

header('Location: index.php');
exit;
