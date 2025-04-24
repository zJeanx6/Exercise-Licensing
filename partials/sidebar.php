<!-- Botón Hamburguesa (solo visible en pantallas pequeñas) -->
<button onclick="toggleSidebar()" class="md:hidden fixed top-4 left-4 z-50 bg-gray-900 text-white p-2 rounded">
  ☰
</button>

<!-- Sidebar -->
<aside id="sidebar"
  class="h-screen w-64 bg-gray-900 text-white fixed top-0 left-0 flex flex-col transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-40">
  <div class="text-center py-4 text-xl font-bold border-b border-gray-700">
    Recetas App
  </div>
  <nav class="flex-1 px-4 py-6 space-y-3 text-sm">
    <a href="<?= BASE_URL ?>views/recetas/index.php" class="block px-3 py-2 rounded hover:bg-gray-700">Recetas</a>
    <a href="<?= BASE_URL ?>views/ingredientes/index.php" class="block px-3 py-2 rounded hover:bg-gray-700">Ingredientes</a>
  </nav>
</aside>
<script>
  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const isOpen = !sidebar.classList.contains('-translate-x-full');

    if (isOpen) {
      sidebar.classList.add('-translate-x-full');
      overlay.classList.add('hidden');
    } else {
      sidebar.classList.remove('-translate-x-full');
      overlay.classList.remove('hidden');
    }
  }
</script>
