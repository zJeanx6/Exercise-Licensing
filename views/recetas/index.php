<?php
require_once __DIR__ . '/../../config/route.php';
require_once __DIR__ . '/../../config/db_config.php'; // conexión PDO
$title = "Recetas";
$conex = new Database;
$pdo = $conex->conectar();

// Consulta recetas
$stmt = $pdo->query("SELECT * FROM recetas");
$recetas = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold pl-10">Lista de Recetas</h1>
      <a href="<?= BASE_URL ?>views/recetas/crear.php"
        class="bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 px-4 rounded-xl transition">
        Crear nueva Receta
      </a>
    </div>


    <div class="overflow-x-auto rounded-xl shadow-md bg-white">
      <table class="min-w-full">
        <thead class="bg-gray-800 text-white text-left">
          <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">Nombre</th>
            <th class="px-4 py-2">Instrucciones</th>
            <th class="px-4 py-2">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($recetas as $receta): ?>
            <tr class="border-b hover:bg-gray-100">
              <td class="px-4 py-2"><?= htmlspecialchars($receta['id']) ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($receta['nombre']) ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($receta['instrucciones']) ?></td>
              <td class="px-4 py-2">
                <div class="inline-flex rounded-md shadow-sm" role="group">
                  <a href="<?= BASE_URL ?>views/recetas/editar.php?id=<?= $receta['id'] ?>"
                     class="px-4 py-2 text-sm font-medium text-white bg-gray-800 border border-gray-800 rounded-l-lg hover:bg-gray-900">
                    Editar
                  </a>
                  <form action="<?= BASE_URL ?>views/recetas/eliminar.php" method="POST" class="inline">
                    <input type="hidden" name="id" value="<?= $receta['id'] ?>">
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-red-500 border border-red-500 rounded-r-lg hover:bg-red-600">
                      Eliminar
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

  </main>
</body>

</html>