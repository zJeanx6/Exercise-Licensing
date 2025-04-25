<?php
$title = "Dashboard";
require_once __DIR__ . '../../../config/route.php';
require_once __DIR__ . '../../../config/db_config.php';
session_start();

$conex = new Database;
$pdo = $conex->conectar();
$adminCedula = $_SESSION['user']['cedula'];
$stmt = $pdo->prepare("SELECT u.nit_empresa, e.nombre AS nombre_empresa FROM usuarios u INNER JOIN empresas e ON u.nit_empresa = e.nit WHERE u.cedula = ? AND u.rol_id = 2");
$stmt->execute([$adminCedula]);
$adminEmpresa = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$adminEmpresa) {
  echo "No se pudo determinar la empresa del administrador.";
  exit;
}

$nitEmpresa = $adminEmpresa['nit_empresa'];
$nombreEmpresa = $adminEmpresa['nombre_empresa'];

$totalUsuarios = $pdo->prepare("SELECT COUNT(*) AS total FROM usuarios WHERE nit_empresa = ? AND rol_id = 3");
$totalUsuarios->execute([$nitEmpresa]);
$totalUsuarios = $totalUsuarios->fetch(PDO::FETCH_ASSOC)['total'];

// Obtener la fecha de fin de la licencia actual
$stmt = $pdo->prepare("SELECT fecha_fin FROM licencias WHERE nit_empresa = ? ORDER BY fecha_fin DESC LIMIT 1");
$stmt->execute([$nitEmpresa]);
$licencia = $stmt->fetch(PDO::FETCH_ASSOC);

$diasRestantes = null;
if ($licencia) {
  $fechaFin = new DateTime($licencia['fecha_fin']);
  $hoy = new DateTime();
  $intervalo = $hoy->diff($fechaFin);
  $diasRestantes = $intervalo->invert === 0 ? $intervalo->days : 0;
}

$fechaVencimiento = $licencia ? $fechaFin->format('d/m/Y') : null;

// Configurar la zona horaria a Bogotá, Colombia
date_default_timezone_set('America/Bogota');
$fechaActual = date('d/m/Y');
$horaActual = date('H:i:s');

$nombreUsuario = $_SESSION['user']['nombre'] ?? 'Usuario desconocido';
?>

<!DOCTYPE html>
<html lang="es">
<?php include '../../partials/head.php'; ?>

<body class="flex">
  <?php include '../../partials/sidebar.php'; ?>

  <main class="p-6 w-full md:ml-64">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold pl-10">Dashboard del Administrador</h1>
      <p class="text-gray-600">Bienvenido, <?= ($nombreUsuario) ?></p>
    </div>

    <!-- Información del usuario y empresa -->
    <div class="bg-white p-6 rounded-xl shadow-md mb-6">
      <h2 class="text-2xl font-bold mb-4">Información General</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <p class="text-lg font-semibold text-gray-800">NIT de la Empresa:</p>
          <p class="text-md text-gray-600"><?= ($nitEmpresa) ?></p>
        </div>
        <div>
          <p class="text-lg font-semibold text-gray-800">Nombre de la Empresa:</p>
          <p class="text-md text-gray-600"><?= ($nombreEmpresa) ?></p>
        </div>
      </div>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
      <div class="bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-xl font-bold text-gray-800">Total Empleados</h2>
        <p class="text-3xl font-semibold text-gray-900"><?= $totalUsuarios ?></p>
      </div>
      <div class="bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-xl font-bold text-gray-800">Días Restantes de Licencia</h2>
        <p class="text-3xl font-semibold <?= $diasRestantes === 0 ? 'text-red-600' : 'text-gray-900' ?>">
          <?= $diasRestantes !== null ? $diasRestantes . ' días' : 'Sin licencia activa' ?>
        </p>
      </div>
      <div class="bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-xl font-bold text-gray-800">Vencimiento de Licencia</h2>
        <p class="text-3xl font-semibold text-gray-900">
          <?= $fechaVencimiento !== null ? $fechaVencimiento : 'Sin licencia activa' ?>
        </p>
      </div>
    </div>

    <!-- Enlaces rápidos y calendario -->
    <div class="bg-white p-6 rounded-xl shadow-md">
      <h2 class="text-2xl font-bold mb-4">Enlaces Rápidos</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <a href="<?= BASE_URL ?>views/admin/empleados/index.php"
          class="block bg-gray-800 hover:bg-gray-900 text-white font-semibold py-12  px-6 rounded-xl text-center">
          Gestionar Usuarios
        </a>
        <div class="bg-gray-100 p-4 rounded-xl shadow-md text-center">
          <h3 class="text-xl font-bold text-gray-800 mb-2">Fecha y Hora Actual</h3>
          <p class="text-lg font-semibold text-gray-800" id="fecha"><?= $fechaActual ?></p>
          <p class="text-md text-gray-600" id="hora"><?= $horaActual ?></p>
        </div>
      </div>
    </div>
  </main>

  <script>
    // Actualizar la hora en tiempo real
    function actualizarHora() {
      const fecha = new Date();
      const opcionesFecha = {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
      };
      const opcionesHora = {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
      };

      document.getElementById('fecha').textContent = fecha.toLocaleDateString('es-CO', opcionesFecha);
      document.getElementById('hora').textContent = fecha.toLocaleTimeString('es-CO', opcionesHora);
    }

    setInterval(actualizarHora, 1000); // Actualizar cada segundo
  </script>
</body>

</html>