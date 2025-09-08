<!-- resources/views/includes/footer.blade.php -->

<footer class="bg-gray-100 border-t border-gray-300 mt-10">
  <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-10">

    <!-- Logo y descripción -->
    <div>
      <h2 class="text-2xl font-extrabold text-orange-500 flex items-center gap-2">
        <i data-lucide="shopping-bag" class="w-7 h-7 text-orange-500"></i>
        MiTienda
      </h2>
      <p class="mt-4 text-gray-600 text-sm leading-relaxed">
        Tu tienda de confianza para encontrar los mejores productos al mejor precio.
      </p>
    </div>

    <!-- Enlaces rápidos -->
    <div>
      <h3 class="text-lg font-semibold text-gray-800 mb-4">Enlaces</h3>
      <ul class="space-y-2">
        <li>
          <a href="{{ url('/') }}" class="flex items-center gap-2 hover:text-orange-500 transition-colors">
            <i data-lucide="home" class="w-4 h-4"></i> Inicio
          </a>
        </li>
        <li>
          <a href="{{ url('/products') }}" class="flex items-center gap-2 hover:text-orange-500 transition-colors">
            <i data-lucide="box" class="w-4 h-4"></i> Productos
          </a>
        </li>
        <li>
          <a href="{{ url('/about') }}" class="flex items-center gap-2 hover:text-orange-500 transition-colors">
            <i data-lucide="users" class="w-4 h-4"></i> Nosotros
          </a>
        </li>
        <li>
          <a href="{{ url('/contact') }}" class="flex items-center gap-2 hover:text-orange-500 transition-colors">
            <i data-lucide="mail" class="w-4 h-4"></i> Contacto
          </a>
        </li>
      </ul>
    </div>

    <!-- Contacto -->
    <div>
      <h3 class="text-lg font-semibold text-gray-800 mb-4">Contáctanos</h3>
      <ul class="space-y-3 text-sm text-gray-600">
        <li class="flex items-center gap-2">
          <i data-lucide="map-pin" class="w-5 h-5 text-orange-500"></i>
          Calle 123, Ciudad
        </li>
        <li class="flex items-center gap-2">
          <i data-lucide="phone" class="w-5 h-5 text-orange-500"></i>
          +57 300 123 4567
        </li>
        <li class="flex items-center gap-2">
          <i data-lucide="mail" class="w-5 h-5 text-orange-500"></i>
          contacto@mitienda.com
        </li>
      </ul>
    </div>

    <!-- Redes sociales -->
    <div>
      <h3 class="text-lg font-semibold text-gray-800 mb-4">Síguenos</h3>
      <div class="flex space-x-4">
        <a href="#" class="p-3 bg-gray-200 rounded-full hover:bg-orange-500 hover:text-white transition-colors">
          <i data-lucide="globe" class="w-5 h-5"></i>
        </a>
        <a href="#" class="p-3 bg-gray-200 rounded-full hover:bg-blue-600 hover:text-white transition-colors">
          <i data-lucide="facebook" class="w-5 h-5"></i>
        </a>
        <a href="#" class="p-3 bg-gray-200 rounded-full hover:bg-pink-500 hover:text-white transition-colors">
          <i data-lucide="instagram" class="w-5 h-5"></i>
        </a>
        <a href="#" class="p-3 bg-gray-200 rounded-full hover:bg-sky-500 hover:text-white transition-colors">
          <i data-lucide="twitter" class="w-5 h-5"></i>
        </a>
      </div>
    </div>

  </div>

  <!-- Línea final -->
  <div class="bg-orange-500 py-4 mt-8">
    <p class="text-center text-white text-sm font-medium">
      © {{ date('Y') }} <span class="font-semibold">MiTienda</span> - Todos los derechos reservados.
    </p>
  </div>
</footer>

<!-- Lucide Icons -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
  lucide.createIcons();
</script>


