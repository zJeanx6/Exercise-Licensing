<?php
$title = "Dashboard";
require_once __DIR__ . '../../../config/route.php';
require_once __DIR__ . '../../../config/db_config.php';
session_start();

$conex = new Database;
$pdo = $conex->conectar();

// Obtener información del empleado y la empresa
$empleadoCedula = $_SESSION['user']['cedula'] ?? null;
$stmt = $pdo->prepare("
    SELECT u.nombre AS nombre_usuario, u.rol_id, e.nombre AS nombre_empresa 
    FROM usuarios u 
    INNER JOIN empresas e ON u.nit_empresa = e.nit 
    WHERE u.cedula = ?
");
$stmt->execute([$empleadoCedula]);
$empleado = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$empleado) {
    echo "No se pudo determinar la información del empleado.";
    exit;
}

$nombreUsuario = $empleado['nombre_usuario'];
$nombreEmpresa = $empleado['nombre_empresa'];
$rol = $empleado['rol_id'] == 3 ? 'Empleado' : 'Desconocido';

// Contadores de recetas e ingredientes
$totalRecetas = $pdo->query("SELECT COUNT(*) AS total FROM recetas")->fetch(PDO::FETCH_ASSOC)['total'];
$totalIngredientes = $pdo->query("SELECT COUNT(*) AS total FROM ingredientes")->fetch(PDO::FETCH_ASSOC)['total'];

// Configurar la zona horaria a Bogotá, Colombia
date_default_timezone_set('America/Bogota');
$fechaActual = date('d/m/Y');
$horaActual = date('H:i:s');
?>

<!DOCTYPE html>
<html lang="es">
<?php include '../../partials/head.php'; ?>

<body class="flex">
    <?php include '../../partials/sidebaremple.php'; ?>

    <main class="p-6 w-full md:ml-64">
        <div class="mb-6">
            <h1 class="text-3xl font-bold">Dashboard del Empleado</h1>
            <p class="text-gray-600">Bienvenido, <?= htmlspecialchars($nombreUsuario) ?></p>
        </div>

        <!-- Información del usuario y empresa -->
        <div class="bg-white p-6 rounded-xl shadow-md mb-6">
            <h2 class="text-2xl font-bold mb-4">Información General</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-lg font-semibold text-gray-800">Nombre del Usuario:</p>
                    <p class="text-md text-gray-600"><?= htmlspecialchars($nombreUsuario) ?></p>
                </div>
                <div>
                    <p class="text-lg font-semibold text-gray-800">Rol:</p>
                    <p class="text-md text-gray-600"><?= htmlspecialchars($rol) ?></p>
                </div>
                <div>
                    <p class="text-lg font-semibold text-gray-800">Nombre de la Empresa:</p>
                    <p class="text-md text-gray-600"><?= htmlspecialchars($nombreEmpresa) ?></p>
                </div>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-bold text-gray-800">Total Recetas</h2>
                <p class="text-3xl font-semibold text-gray-900"><?= $totalRecetas ?></p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-bold text-gray-800">Total Ingredientes</h2>
                <p class="text-3xl font-semibold text-gray-900"><?= $totalIngredientes ?></p>
            </div>
        </div>

        <!-- Calendario -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-2xl font-bold mb-4">Fecha y Hora Actual</h2>
            <div class="text-start">
                <p class="text-lg font-semibold text-gray-800" id="fecha"><?= $fechaActual ?></p>
                <p class="text-md text-gray-600" id="hora"><?= $horaActual ?></p>
            </div>
        </div>
    </main>

    <script>
        // Actualizar la hora en tiempo real
        function actualizarHora() {
            const fecha = new Date();
            const opcionesFecha = { day: '2-digit', month: '2-digit', year: 'numeric' };
            const opcionesHora = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };

            document.getElementById('fecha').textContent = fecha.toLocaleDateString('es-CO', opcionesFecha);
            document.getElementById('hora').textContent = fecha.toLocaleTimeString('es-CO', opcionesHora);
        }

        setInterval(actualizarHora, 1000); // Actualizar cada segundo
    </script>
</body>
</html>
