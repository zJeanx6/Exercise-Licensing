<?php
require_once __DIR__ . '../../../../config/route.php';
require_once __DIR__ . '../../../../config/db_config.php'; // conexión PDO
$title = "Crear Receta";
$conex = new Database;
$pdo = $conex->conectar();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST['nombre']);
    $instrucciones = trim($_POST['instrucciones']);
    $ingredientes = $_POST['ingredientes'] ?? [];
    $cantidades = $_POST['cantidades'] ?? [];
    $unidades = $_POST['unidades'] ?? [];

    if ($nombre !== '' && $instrucciones !== '') {
        try {
            // Crear receta
            $stmt = $pdo->prepare("INSERT INTO recetas (nombre, instrucciones) VALUES (?, ?)");
            $stmt->execute([$nombre, $instrucciones]);
            $recetaId = $pdo->lastInsertId();

            // Verificar si la tabla detalle_receta existe, si no, crearla
            $pdo->exec("
                CREATE TABLE IF NOT EXISTS detalle_receta (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    id_receta INT NOT NULL,
                    id_ingrediente INT NOT NULL,
                                        FOREIGN KEY (id_receta) REFERENCES recetas(id),
                    FOREIGN KEY (id_ingrediente) REFERENCES ingredientes(id)
                )
            ");

            // Insertar ingredientes en detalle_receta
            foreach ($ingredientes as $index => $ingredienteId) {
                $cantidad = $cantidades[$index] ?? 0;
                $unidad = $unidades[$index] ?? '';
                $stmtDetalle = $pdo->prepare("INSERT INTO detalle_recetas (id_receta, id_ingrediente, cantidad, unidad_medida) VALUES (?, ?, ?, ?)");
                $stmtDetalle->execute([$recetaId, $ingredienteId, $cantidad, $unidad]);
            }

            header('Location: index.php');
            exit;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
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
            <h1 class="text-2xl font-bold pl-10">Crear una nueva receta</h1>
            <a href="<?= BASE_URL ?>views/recetas/index.php"
                class="bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 px-4 rounded-xl transition">
                Volver
            </a>
        </div>

        <form action="" method="POST" class="space-y-6 bg-white p-6 rounded-xl shadow-md">
            <div>
                <label class="block font-medium mb-1">Nombre de la receta</label>
                <input type="text" name="nombre" required
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800">
            </div>
            <div>
                <label class="block font-medium mb-1">Instrucciones</label>
                <textarea name="instrucciones" rows="5" required
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800"></textarea>
            </div>
            <div id="ingredientes-container" class="space-y-4">
                <div class="grupo-ingrediente flex items-center space-x-4">
                    <div class="flex-1">
                        <label class="block font-medium mb-1">Seleccionar Ingrediente</label>
                        <select name="ingredientes[]" required
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800">
                            <option value="" disabled selected>Selecciona un ingrediente</option>
                            <?php
                            $stmt = $pdo->query("SELECT id, nombre FROM ingredientes");
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['nombre']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="flex-1">
                        <label class="block font-medium mb-1">Cantidad</label>
                        <input type="number" name="cantidades[]" step="0.01" required
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800">
                    </div>
                    <div class="flex-1">
                        <label class="block font-medium mb-1">Unidad de Medida</label>
                        <select name="unidades[]" required
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800">
                            <option value="" disabled selected>Selecciona una unidad de medida</option>
                            <option value="gramos">Gramos</option>
                            <option value="kilogramos">Kilogramos</option>
                            <option value="mililitros">Mililitros</option>
                            <option value="litros">Litros</option>
                            <option value="cucharadas">Cucharadas</option>
                            <option value="tazas">Tazas</option>
                            <option value="unidades">Unidades</option>
                        </select>
                    </div>
                    <button type="button" onclick="eliminarIngrediente(this)"
                        class="text-red-500 hover:text-red-700 font-bold text-lg">
                        &times;
                    </button>
                </div>
            </div>
            <button type="button" onclick="agregarIngrediente()"
                class="bg-gray-200 hover:bg-gray-300 text-sm text-gray-800 font-medium py-1 px-3 rounded-xl transition">
                + Agregar ingrediente
            </button>
            <button type="submit"
                class="w-full bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 rounded-xl transition">
                Guardar Receta
            </button>
        </form>
    </main>

    <script>
        function agregarIngrediente() {
            const contenedor = document.getElementById('ingredientes-container');

            const nuevoGrupo = document.createElement('div');
            nuevoGrupo.classList.add('grupo-ingrediente', 'flex', 'items-center', 'space-x-4');
            nuevoGrupo.innerHTML = `
                <div class="flex-1">
                    <label class="block font-medium mb-1">Seleccionar Ingrediente</label>
                    <select name="ingredientes[]" required
                        class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800">
                        <option value="" disabled selected>Selecciona un ingrediente</option>
                        <?php
                        $stmt = $pdo->query("SELECT id, nombre FROM ingredientes");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['nombre']) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="flex-1">
                    <label class="block font-medium mb-1">Cantidad</label>
                    <input type="number" name="cantidades[]" step="0.01" required
                        class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800">
                </div>
                <div class="flex-1">
                    <label class="block font-medium mb-1">Unidad de Medida</label>
                    <select name="unidades[]" required
                        class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800">
                        <option value="" disabled selected>Selecciona una unidad de medida</option>
                        <option value="gramos">Gramos</option>
                        <option value="kilogramos">Kilogramos</option>
                        <option value="mililitros">Mililitros</option>
                        <option value="litros">Litros</option>
                        <option value="cucharadas">Cucharadas</option>
                        <option value="tazas">Tazas</option>
                        <option value="unidades">Unidades</option>
                    </select>
                </div>
                <button type="button" onclick="eliminarIngrediente(this)"
                    class="text-red-500 hover:text-red-700 font-bold text-lg">
                    &times;
                </button>
            `;

            contenedor.appendChild(nuevoGrupo);
        }

        function eliminarIngrediente(boton) {
            const grupo = boton.parentElement;
            grupo.remove();
        }
    </script>
</body>

</html>