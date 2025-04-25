<?php
$title = "Editar Licencia";
require_once __DIR__ . '../../../../config/route.php';
require_once __DIR__ . '../../../../config/db_config.php';
$conex = new Database;
$pdo = $conex->conectar();

$licenciaId = $_GET['id'] ?? null;

if (!$licenciaId) {
    header('Location: index.php');
    exit;
}

// Obtener datos de la licencia
$stmt = $pdo->prepare("SELECT * FROM licencias WHERE licencia = ?");
$stmt->execute([$licenciaId]);
$licencia = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$licencia) {
    header('Location: index.php');
    exit;
}

// Obtener empresas y tipos de licencias
$empresas = $pdo->query("SELECT nit, nombre FROM empresas")->fetchAll(PDO::FETCH_ASSOC);
$tiposLicencias = $pdo->query("SELECT id, nombre, duracion FROM tipos_licencias")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nit_empresa = $_POST['nit_empresa'];
    $id_tipo_licencia = $_POST['id_tipo_licencia'];

    // Verificar si se cambió el tipo de licencia
    if ($id_tipo_licencia != $licencia['id_tipo_licencia']) {
        $fecha_fin = date('Y-m-d', strtotime("+{$_POST['duracion']} days"));
    } else {
        $fecha_fin = $licencia['fecha_fin']; // Mantener la fecha de fin actual
    }

    // Actualizar licencia
    $stmt = $pdo->prepare("UPDATE licencias SET nit_empresa = ?, fecha_fin = ?, id_tipo_licencia = ? WHERE licencia = ?");
    $stmt->execute([$nit_empresa, $fecha_fin, $id_tipo_licencia, $licenciaId]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<?php include '../../../partials/head.php'; ?>

<body class="flex">
    <?php include '../../../partials/sidebaradm.php'; ?>

    <main class="p-6 w-full md:ml-64">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold pl-10">Editar Licencia</h1>
            <a href="<?= BASE_URL ?>views/superadmin/licencias/index.php"
               class="bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 px-4 rounded-xl transition">
                Volver
            </a>
        </div>

        <form method="POST" class="space-y-6 bg-white p-6 rounded-xl shadow-md">
            <div>
                <label for="licencia" class="block font-medium mb-1">Licencia</label>
                <input type="text" id="licencia" name="licencia" readonly
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none bg-gray-100"
                       value="<?= htmlspecialchars($licencia['licencia']) ?>">
            </div>

            <div>
                <label for="nit_empresa" class="block font-medium mb-1">Empresa</label>
                <select id="nit_empresa" name="nit_empresa" required
                        class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800">
                    <?php foreach ($empresas as $empresa): ?>
                        <option value="<?= $empresa['nit'] ?>" <?= $empresa['nit'] === $licencia['nit_empresa'] ? 'selected' : '' ?>>
                            <?= $empresa['nombre'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="id_tipo_licencia" class="block font-medium mb-1">Tipo de Licencia</label>
                <select id="id_tipo_licencia" name="id_tipo_licencia" required onchange="actualizarDuracion()"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800">
                    <?php foreach ($tiposLicencias as $tipo): ?>
                        <option value="<?= $tipo['id'] ?>" data-duracion="<?= $tipo['duracion'] ?>" <?= $tipo['id'] === $licencia['id_tipo_licencia'] ? 'selected' : '' ?>>
                            <?= $tipo['nombre'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" id="duracion" name="duracion">
            </div>

            <div>
                <label for="fecha_compra" class="block font-medium mb-1">Fecha de Compra</label>
                <input type="text" id="fecha_compra" name="fecha_compra"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none bg-gray-100"
                       value="<?= htmlspecialchars($licencia['fecha_compra']) ?>" readonly>
            </div>

            <button type="submit"
                    class="w-full bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 rounded-xl transition">
                Guardar Cambios
            </button>
        </form>
    </main>

    <script>
        function actualizarDuracion() {
            const select = document.getElementById('id_tipo_licencia');
            const duracion = select.options[select.selectedIndex].getAttribute('data-duracion');
            document.getElementById('duracion').value = duracion;
        }
    </script>
</body>
</html>
