<?php

$title = "Dashboard";
require_once __DIR__ . '../../config/route.php';
require_once __DIR__ . '../../config/db_config.php';
?>

<!DOCTYPE html>
<html lang="es">
<?php include '../partials/head.php'; ?>

<body class="flex">
  <?php include '../partials/sidebaradm.php'; ?>

  <main class="p-6 w-full md:ml-64">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold pl-10">Bienvenido al Dashboard</h1>
    </div>
  </main>
</body>

</html>