@extends('layouts.app')
@section('title', 'Productos')

@php
    $defaultImages = [asset('https://images.pexels.com/photos/1915149/pexels-photo-1915149.jpeg'), asset('https://images.pexels.com/photos/33839051/pexels-photo-33839051.jpeg'), asset('images/img3.jpg')];
@endphp

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10 bg-gray-50">

    <!-- Botón para abrir modal de crear -->
    <div class="mb-6 flex justify-end">
        <button onclick="openModal('createModal')"
            class="bg-orange-600 hover:bg-orange-700 text-white font-semibold px-4 py-1.5 rounded-lg shadow transition-colors text-sm">
            Crear producto
        </button>
    </div>

    @if (count($products) === 0)
        <p class="text-center text-gray-500 text-lg">No hay productos disponibles.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
            @foreach ($products as $index => $product)
                <div class="bg-white border border-gray-200 rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 p-5 flex flex-col">

                    <!-- Imagen -->
                    <img src="{{ $product['images'] ?? $defaultImages[$index % count($defaultImages)] }}"
                        alt="{{ $product['name'] ?? 'Producto' }}" class="w-full h-44 object-cover rounded-lg mb-3">

                    <!-- Info -->
                    <div class="mb-2">
                        <h2 class="text-lg font-semibold text-gray-800">{{ $product['name'] ?? 'Nombre no disponible' }}</h2>
                        <p class="text-orange-600 font-bold mt-1 text-base">${{ $product['price'] ?? 0 }}</p>
                    </div>

                    <p class="text-gray-600 flex-1 mb-2 text-sm">{{ $product['description'] ?? 'Sin descripción' }}</p>
                    <p class="text-gray-500 font-medium mb-3 text-sm">Stock: {{ $product['stock'] ?? 0 }}</p>

                    <!-- Botones -->
                    <div class="mt-auto flex justify-between gap-2">
                        <!-- Ver -->
                        <button onclick="openViewModal({{ $product['id'] }}, '{{ $product['name'] }}', {{ $product['price'] ?? 0 }}, '{{ $product['description'] }}', {{ $product['stock'] ?? 0 }})"
                            class="flex-1 flex items-center justify-center border border-gray-400 text-gray-700 rounded-lg p-1 hover:bg-[#D2691E] hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>

                        <!-- Editar -->
                        <button onclick="openEditModal({{ $product['id'] }}, '{{ $product['name'] }}', {{ $product['price'] ?? 0 }}, '{{ $product['description'] }}', {{ $product['stock'] ?? 0 }}, {{ $product['category_id'] ?? 0 }}, {{ $product['store_id'] ?? 0 }}, {{ $product['offer'] ? 1 : 0 }})"
                            class="flex-1 flex items-center justify-center border border-gray-400 text-gray-700 rounded-lg p-1 hover:bg-[#D2691E] hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-7-7l7 7m0 0V5m0 7h-7" />
                            </svg>
                        </button>

                        <!-- Eliminar -->
                        <button onclick="openDeleteModal({{ $product['id'] }})"
                            class="flex-1 flex items-center justify-center border border-gray-400 text-gray-700 rounded-lg p-1 hover:bg-red-600 hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Modales -->

<!-- Crear Producto -->
<div id="createModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96">
        <h2 class="text-xl font-bold mb-4 text-orange-600">Crear producto</h2>
        <form id="createProductForm">
            @csrf
            <input type="text" name="name" placeholder="Nombre" class="w-full border rounded p-2 mb-2" required>
            <input type="number" name="price" placeholder="Precio" class="w-full border rounded p-2 mb-2" required>
            <textarea name="description" placeholder="Descripción" class="w-full border rounded p-2 mb-2"></textarea>
            <input type="number" name="stock" placeholder="Stock" class="w-full border rounded p-2 mb-2">
            <select name="category_id" class="w-full border rounded p-2 mb-2" required>
                @forelse($categories as $category)
                    <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                @empty
                    <option value="">No hay categorías disponibles</option>
                @endforelse
            </select>
            <select name="store_id" class="w-full border rounded p-2 mb-2" required>
                @forelse($stores as $store)
                    <option value="{{ $store['id'] }}">{{ $store['name'] }}</option>
                @empty
                    <option value="">No hay tiendas disponibles</option>
                @endforelse
            </select>
            <div class="flex items-center gap-2 mb-2">
                <input type="checkbox" name="offer" value="1">
                <label>Oferta</label>
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeModal('createModal')" class="px-3 py-1 bg-gray-300 rounded text-sm">Cancelar</button>
                <button type="submit" class="px-3 py-1 bg-orange-600 hover:bg-orange-700 text-white rounded text-sm">Guardar</button>
            </div>
        </form>
    </div>
</div>

<!-- Ver Producto -->
<div id="viewModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96">
        <h2 class="text-xl font-bold mb-4 text-orange-600">Detalles del producto</h2>
        <p class="text-gray-700">Nombre: Producto X</p>
        <p class="text-gray-700">Precio: $100</p>
        <p class="text-gray-600">Descripción: Aquí va la info...</p>
        <div class="flex justify-end mt-4">
            <button onclick="closeModal('viewModal')" class="px-3 py-1 bg-gray-300 text-gray-700 rounded-lg text-sm">Cerrar</button>
        </div>
    </div>
</div>

<!-- Editar Producto -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96">
        <h2 class="text-xl font-bold mb-4 text-orange-600">Editar producto</h2>
        <form id="editProductForm">
            @csrf
            <input type="hidden" id="edit_id" name="id">
            <input type="text" id="edit_name" name="name" class="w-full border border-gray-300 rounded p-2 mb-2">
            <input type="number" id="edit_price" name="price" class="w-full border border-gray-300 rounded p-2 mb-2">
            <textarea id="edit_description" name="description" class="w-full border border-gray-300 rounded p-2 mb-2"></textarea>
            <input type="number" id="edit_stock" name="stock" class="w-full border border-gray-300 rounded p-2 mb-2">
            <select id="edit_category" name="category_id" class="w-full border rounded p-2 mb-2">
                @foreach($categories as $category)
                    <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                @endforeach
            </select>
            <select id="edit_store" name="store_id" class="w-full border rounded p-2 mb-2">
                @foreach($stores as $store)
                    <option value="{{ $store['id'] }}">{{ $store['name'] }}</option>
                @endforeach
            </select>
            <div class="flex items-center gap-2 mb-2">
                <input type="checkbox" id="edit_offer" name="offer" value="1">
                <label>Oferta</label>
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeModal('editModal')" class="px-3 py-1 bg-gray-300 text-gray-700 rounded-lg text-sm">Cancelar</button>
                <button type="submit" class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-sm">Actualizar</button>
            </div>
        </form>
    </div>
</div>

<!-- Eliminar Producto -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96">
        <h2 class="text-xl font-bold mb-4 text-red-600">Eliminar producto</h2>
        <p class="text-gray-700">¿Estás seguro que deseas eliminar este producto?</p>
        <div class="flex justify-end gap-2 mt-4">
            <button onclick="closeModal('deleteModal')" class="px-3 py-1 bg-gray-300 text-gray-700 rounded-lg text-sm">Cancelar</button>
            <button class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm" id="confirmDeleteBtn">Eliminar</button>
        </div>
    </div>
</div>

<script>
    // Abrir y cerrar modales
    function openModal(id){ document.getElementById(id).classList.remove('hidden'); }
    function closeModal(id){ document.getElementById(id).classList.add('hidden'); }

    // Crear Producto
    const form = document.getElementById('createProductForm');
    form.addEventListener('submit', async function(e){
        e.preventDefault();
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        data.offer = formData.get('offer') ? true : false;
        try {
            const token = '{{ session('api_token') }}';
            const response = await fetch('{{ env('APP_URL') }}/api/product', {
                method:'POST',
                headers:{'Accept':'application/json','Content-Type':'application/json','Authorization':'Bearer '+token},
                body: JSON.stringify(data)
            });
            if(response.ok){ alert('Producto creado exitosamente'); closeModal('createModal'); form.reset(); window.location.reload(); }
            else { const result = await response.json(); console.error(result); alert('Error al crear producto'); }
        } catch(error){ console.error(error); alert('Error de conexión con la API'); }
    });

    // Ver Producto
    function openViewModal(id, name, price, description, stock){
        document.querySelector('#viewModal p:nth-child(2)').textContent = `Nombre: ${name}`;
        document.querySelector('#viewModal p:nth-child(3)').textContent = `Precio: $${price}`;
        document.querySelector('#viewModal p:nth-child(4)').textContent = `Descripción: ${description}`;
        openModal('viewModal');
    }

    // Editar Producto
    function openEditModal(id,name,price,description,stock,category_id,store_id,offer){
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_price').value = price;
        document.getElementById('edit_description').value = description;
        document.getElementById('edit_stock').value = stock;
        document.getElementById('edit_category').value = category_id;
        document.getElementById('edit_store').value = store_id;
        document.getElementById('edit_offer').checked = offer == 1 ? true : false;
        openModal('editModal');
    }

    const editForm = document.getElementById('editProductForm');
    editForm.addEventListener('submit', async function(e){
        e.preventDefault();
        const formData = new FormData(editForm);
        const data = Object.fromEntries(formData.entries());
        data.offer = formData.get('offer') ? true : false;
        const id = data.id;
        try {
            const token = '{{ session('api_token') }}';
            const response = await fetch(`{{ env('APP_URL') }}/api/product/${id}`, {
                method:'PUT',
                headers:{'Accept':'application/json','Content-Type':'application/json','Authorization':'Bearer '+token},
                body: JSON.stringify(data)
            });
            if(response.ok){ alert('Producto actualizado'); closeModal('editModal'); window.location.reload(); }
            else { const result = await response.json(); console.error(result); alert('Error al actualizar producto'); }
        } catch(error){ console.error(error); alert('Error de conexión con la API'); }
    });

    // Eliminar Producto
    let deleteId = null;
    function openDeleteModal(id){ deleteId = id; openModal('deleteModal'); }

    document.getElementById('confirmDeleteBtn').addEventListener('click', async function(){
        if(!deleteId) return;
        try {
            const token = '{{ session('api_token') }}';
            const response = await fetch(`{{ env('APP_URL') }}/api/product/${deleteId}`, {
                method:'DELETE',
                headers:{'Accept':'application/json','Authorization':'Bearer '+token}
            });
            if(response.ok){ alert('Producto eliminado'); closeModal('deleteModal'); window.location.reload(); }
            else { const result = await response.json(); console.error(result); alert('Error al eliminar producto'); }
        } catch(error){ console.error(error); alert('Error de conexión con la API'); }
    });
</script>
@endsection

