<?php
require_once __DIR__ . '/../../config/route.php';
require_once __DIR__ . '/../../config/db_config.php'; // conexión PDO
$title = "Crear Ingrediente";
$conex = new Database;
$pdo = $conex->conectar();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombres = $_POST['nombre'] ?? [];

    foreach ($nombres as $nombre) {
        $nombre = trim($nombre);
        if ($nombre !== '') {
            $stmt = $pdo->prepare("INSERT INTO ingredientes (nombre) VALUES (?)");
            $stmt->execute([$nombre]);
        }
    }

    // Redirigir para evitar reenviar formulario al recargar
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<?php include '../../partials/head.php'; ?>

<body class="flex">
    <?php include '../../partials/sidebar.php'; ?>

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
                <div class="grupo-ingrediente">
                    <label class="block font-medium mb-1">Nombre del ingrediente</label>
                    <input type="text" name="nombre[]" required
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
            nuevoInput.classList.add('grupo-ingrediente');
            nuevoInput.innerHTML = `
                <label class="block font-medium mb-1">Nombre del ingrediente</label>
                <input type="text" name="nombre[]" required
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800">
            `;

            contenedor.appendChild(nuevoInput);
        }
    </script>
</body>

</html>