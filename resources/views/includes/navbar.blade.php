<nav class="fixed top-0 w-full bg-white shadow-md z-50" x-data="{ mostrarMenu: false, query: '', results: [] }">
  <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between gap-4">

    <!-- Logo -->
    <a href="{{ url('/') }}" class="flex items-center text-2xl font-bold text-gray-800 hover:text-[#D2691E] transition">
      <span class="text-[#D2691E] mr-2">🛒</span> Comercio Plus
    </a>

    <!-- Buscador desktop -->
    <div class="hidden sm:flex flex-grow max-w-lg relative" @click.away="results = []">
      <input type="text"
             x-model="query"
             @input.debounce.400ms="
               if(query.length > 0){
                 fetch('{{ route('products.search') }}?query=' + query)
                   .then(res => res.json())
                   .then(data => results = data)
                   .catch(() => results = [])
               } else { results = [] }
             "
             placeholder="Buscar productos, marcas..."
             class="w-full pl-4 pr-32 py-2 rounded-l-full border border-gray-300 bg-gray-50 
                    text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-[#D2691E] focus:bg-white outline-none transition">

      <button @click="
          if(query.length > 0){
            fetch('{{ route('products.search') }}?query=' + query)
              .then(res => res.json())
              .then(data => results = data)
          } else { results = [] }
        "
        class="absolute right-0 top-0 h-full px-6 bg-[#D2691E] text-white font-medium rounded-r-full hover:bg-[#b75515] transition">
        🔍
      </button>

      <div x-show="results.length > 0" x-transition
           class="absolute left-0 right-0 mt-2 bg-white shadow-2xl rounded-lg overflow-y-auto max-h-80 z-50">
        <template x-for="item in results" :key="item.id">
          <a :href="`/products/${item.id}`"
             class="flex items-center gap-3 px-4 py-3 hover:bg-[#D2691E] hover:text-white transition">
            <img :src="item.image" alt="" class="w-12 h-12 object-cover rounded border">
            <div class="flex flex-col">
              <span x-text="item.name" class="font-medium"></span>
              <span x-text="`$${item.price}`" class="text-sm text-gray-500 group-hover:text-white"></span>
            </div>
          </a>
        </template>
      </div>
    </div>

    <!-- Links desktop -->
 

    <!-- Botón menú (desktop y móvil) -->
    <button @click="mostrarMenu = !mostrarMenu"
            class="text-gray-800 text-2xl hover:text-[#D2691E] transition">
      ☰
    </button>
  </div>

  <!-- Menú desplegable -->
  <div x-show="mostrarMenu" x-transition
       class="absolute right-6 top-full bg-white border border-gray-200 py-4 text-gray-800 space-y-3 shadow-lg rounded-lg min-w-[200px]">
    <a href="{{ route('categories.index') }}" class="block hover:text-white hover:bg-[#D2691E] transition rounded px-2 py-1">Categorías</a>
    <a href="{{ route('carts.index')  }}" class="block hover:text-white hover:bg-[#D2691E] transition rounded px-2 py-1">Carritos</a>
    <a href="{{ url('/contact') }}" class="block hover:text-white hover:bg-[#D2691E] transition rounded px-2 py-1">Productos en Carrito</a>
    <a href="{{ route('channels.index') }}" class="block hover:text-white hover:bg-[#D2691E] transition rounded px-2 py-1">Canales</a>
    <a href="{{ url('/account') }}" class="block hover:text-white hover:bg-[#D2691E] transition rounded px-2 py-1">Ubicaciones</a>
    <a href="{{ url('/account') }}" class="block hover:text-white hover:bg-[#D2691E] transition rounded px-2 py-1">Notificaciones</a>

  </div>


  
</nav>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

















