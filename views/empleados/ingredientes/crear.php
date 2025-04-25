<?php
// Cargo la configuración y la conexión a base de datos.
require_once __DIR__ . '../../../../config/route.php';
require_once __DIR__ . '../../../../config/db_config.php';
require_once __DIR__ . '../../../../vendor/autoload.php';

use Picqer\Barcode\BarcodeGeneratorPNG;

$title = "Crear Ingrediente";
$conex = new Database;
$pdo = $conex->conectar();

// Si el formulario fue enviado (POST), proceso los datos.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombres = $_POST['nombre'] ?? [];
    $codigosBarras = $_POST['codigo_barras'] ?? [];

    foreach ($nombres as $index => $nombre) {
        $nombre = trim($nombre);
        $codigoBarrasManual = trim($codigosBarras[$index] ?? '');

        if ($nombre !== '') {
            // Paso 1: Inserto el nombre del ingrediente y obtengo su ID
            $stmt = $pdo->prepare("INSERT INTO ingredientes (nombre) VALUES (?)");
            $stmt->execute([$nombre]);
            $id = $pdo->lastInsertId();

            // Paso 2: Genero o uso el código de barras (manual o automático)
            $codigo_barras = $codigoBarrasManual !== '' ? $codigoBarrasManual : generarCodigoBarras($id);

            // Paso 3: Genero la imagen del código de barras en formato PNG
            $generator = new BarcodeGeneratorPNG();
            $imagen = $generator->getBarcode($codigo_barras, $generator::TYPE_CODE_128, 2, 80);

            // Paso 4: Guardo la imagen en la carpeta local /barcodes
            $ruta = __DIR__ . '/barcodes/' . $codigo_barras . '.png';
            file_put_contents($ruta, $imagen);

            // Paso 5: Actualizo el ingrediente con el código de barras
            $stmt = $pdo->prepare("UPDATE ingredientes SET codigo_barras = ? WHERE id = ?");
            $stmt->execute([$codigo_barras, $id]);
        }
    }

    // Redirijo a la lista de ingredientes
    header('Location: index.php');
    exit;
}

// Esta función genera un código de barras con formato "INGRE-XYZ0001"
function generarCodigoBarras(int $id): string {
    $letras = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3));
    return 'INGRE-' . $letras . str_pad($id, 4, '0', STR_PAD_LEFT);
}
?>

?>

<!DOCTYPE html>
<html lang="es">
<?php include '../../../partials/head.php'; ?>

<body class="flex">
    <?php include '../../../partials/sidebaremple.php'; ?>

    <div id="overlay"
        class="fixed inset-0 bg-[rgba(0,0,0,0.4)] z-30 hidden md:hidden"
        onclick="toggleSidebar()">
    </div>

    <main class="p-6 w-full md:ml-64">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold pl-10">Crear un nuevo ingrediente</h1>
            <a href="<?= BASE_URL ?>views/ingredientes/index.php"
                class="bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 px-4 rounded-xl transition">
                Volver
            </a>
        </div>

        <form action="" method="POST" class="space-y-6 bg-white p-6 rounded-xl shadow-md">
            <div id="ingredientes-container" class="space-y-4">
                <div class="grupo-ingrediente relative">
                    <label class="block font-medium mb-1">Nombre del ingrediente</label>
                    <input type="text" name="nombre[]" required
                        class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800">
                    <label class="block font-medium mb-1 mt-4">Código de Barras (opcional)</label>
                    <input type="text" name="codigo_barras[]"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800">
                </div>
            </div>

            <button type="button" onclick="agregarIngrediente()"
                class="bg-gray-200 hover:bg-gray-300 text-sm text-gray-800 font-medium py-1 px-3 rounded-xl transition">
                + Agregar otro ingrediente
            </button>

            <button type="submit"
                class="w-full bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 rounded-xl transition">
                Guardar Ingredientes
            </button>
        </form>
    </main>

    <script>
        function agregarIngrediente() {
            const contenedor = document.getElementById('ingredientes-container');

            const nuevoInput = document.createElement('div');
            nuevoInput.classList.add('grupo-ingrediente', 'relative');
            nuevoInput.innerHTML = `
                <button type="button" onclick="eliminarIngrediente(this)"
                    class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center">
                    &times;
                </button>
                <label class="block font-medium mb-1">Nombre del ingrediente</label>
                <input type="text" name="nombre[]" required
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800">
                <label class="block font-medium mb-1 mt-4">Código de Barras (opcional)</label>
                <input type="text" name="codigo_barras[]"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800">
            `;

            contenedor.appendChild(nuevoInput);
        }

        function eliminarIngrediente(button) {
            const grupo = button.parentElement;
            grupo.remove();
        }
    </script>
</body>

</html>