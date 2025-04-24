<?php
$title = "Crear Licencia";
require_once __DIR__ . '../../../config/route.php';
require_once __DIR__ . '../../../config/db_config.php';

$conex = new Database;
$pdo = $conex->conectar();

// Obtener empresas y tipos de licencias
$empresas = $pdo->query("SELECT nit, nombre FROM empresas")->fetchAll(PDO::FETCH_ASSOC);
$tiposLicencias = $pdo->query("SELECT id, nombre, duracion FROM tipos_licencias")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nit_empresa = $_POST['nit_empresa'];
    $id_tipo_licencia = $_POST['id_tipo_licencia'];
    $fecha_compra = date('Y-m-d');
    $fecha_fin = date('Y-m-d', strtotime("+{$_POST['duracion']} days"));
    $licencia = $_POST['licencia'];

    // Insertar licencia
    $stmt = $pdo->prepare("INSERT INTO licencias (licencia, nit_empresa, fecha_compra, fecha_fin, id_estado, id_tipo_licencia) 
                           VALUES (?, ?, ?, ?, 1, ?)");
    $stmt->execute([$licencia, $nit_empresa, $fecha_compra, $fecha_fin, $id_tipo_licencia]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<?php include '../../partials/head.php'; ?>

<body class="flex">
    <?php include '../../partials/sidebaradm.php'; ?>

    <main class="p-6 w-full md:ml-64">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold pl-10">Crear Nueva Licencia</h1>
        </div>

        <form method="POST" class="bg-white p-6 rounded-lg shadow-md space-y-4">
            <div>
                <label for="licencia" class="block text-sm font-medium text-gray-700">Licencia</label>
                <div class="flex items-center space-x-2">
                    <input type="text" id="licencia" name="licencia" class="border-gray-300 rounded-lg w-full" readonly required>
                    <button type="button" onclick="generarLicencia()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                        Generar Key
                    </button>
                </div>
            </div>

            <div>
                <label for="nit_empresa" class="block text-sm font-medium text-gray-700">Empresa</label>
                <select id="nit_empresa" name="nit_empresa" class="border-gray-300 rounded-lg w-full" required>
                    <option value="">Seleccione una empresa</option>
                    <?php foreach ($empresas as $empresa): ?>
                        <option value="<?= htmlspecialchars($empresa['nit']) ?>"><?= htmlspecialchars($empresa['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="id_tipo_licencia" class="block text-sm font-medium text-gray-700">Tipo de Licencia</label>
                <select id="id_tipo_licencia" name="id_tipo_licencia" class="border-gray-300 rounded-lg w-full" required onchange="actualizarDuracion()">
                    <option value="">Seleccione un tipo de licencia</option>
                    <?php foreach ($tiposLicencias as $tipo): ?>
                        <option value="<?= htmlspecialchars($tipo['id']) ?>" data-duracion="<?= htmlspecialchars($tipo['duracion']) ?>">
                            <?= htmlspecialchars($tipo['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" id="duracion" name="duracion">
            </div>

            <div>
                <label for="fecha_compra" class="block text-sm font-medium text-gray-700">Fecha de Compra</label>
                <input type="text" id="fecha_compra" name="fecha_compra" class="border-gray-300 rounded-lg w-full" value="<?= date('Y-m-d') ?>" readonly>
            </div>

            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                Guardar Licencia
            </button>
        </form>
    </main>

    <script>
        function generarLicencia() {
            const key = 'XXXX-XXXX-XXXX-XXXX'.replace(/X/g, () => Math.floor(Math.random() * 16).toString(16).toUpperCase());
            document.getElementById('licencia').value = key;
        }

        function actualizarDuracion() {
            const select = document.getElementById('id_tipo_licencia');
            const duracion = select.options[select.selectedIndex].getAttribute('data-duracion');
            document.getElementById('duracion').value = duracion;
        }
    </script>
</body>

</html>
