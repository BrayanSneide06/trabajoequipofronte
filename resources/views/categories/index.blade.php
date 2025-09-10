@extends('layouts.app')
@section('title', 'Categorías')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10 bg-gray-50 min-h-screen">

    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <h1 class="text-3xl font-extrabold text-gray-800">Categorías</h1>
        <button onclick="openModal('createModal')"
            class="bg-orange-600 hover:bg-orange-700 transition duration-200 text-white font-semibold px-5 py-2 rounded-xl shadow-md flex items-center gap-2">
            ➕ Nueva categoría
        </button>
    </div>

    <!-- Contenido -->
    @if(count($categories) === 0)
        <div class="text-center py-20">
            <p class="text-gray-500 text-lg">No hay categorías disponibles.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($categories as $category)
                <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1">
                    <div class="p-6 flex flex-col justify-between h-full">
                        <!-- Icono / Imagen -->
                        <div class="flex items-center justify-center mb-4">
                            <div class="w-16 h-16 flex items-center justify-center rounded-full bg-orange-100 text-orange-600 text-2xl font-bold shadow-inner">
                                {{ strtoupper(substr($category['name'], 0, 1)) }}
                            </div>
                        </div>

                        <!-- Nombre -->
                        <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">
                            {{ $category['name'] ?? 'Nombre no disponible' }}
                        </h3>

                        <!-- Botones -->
                        <div class="flex justify-center gap-3 mt-auto">
                            <button onclick="openEditModal({{ $category['id'] }}, '{{ $category['name'] }}')"
                                class="px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-sm shadow transition">
                                ✏️ Editar
                            </button>
                            <button onclick="openDeleteModal({{ $category['id'] }})"
                                class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm shadow transition">
                                🗑️ Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Modales -->
<div id="createModal" class="hidden fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-lg p-6 w-96">
        <h2 class="text-xl font-bold mb-4 text-orange-600">Crear categoría</h2>
        <form id="createCategoryForm" class="space-y-4">
            @csrf
            <input type="text" name="name" placeholder="Nombre de la categoría"
                class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModal('createModal')"
                    class="px-4 py-1.5 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm transition">Cancelar</button>
                <button type="submit"
                    class="px-4 py-1.5 bg-orange-600 hover:bg-orange-700 text-white rounded-lg text-sm shadow transition">Guardar</button>
            </div>
        </form>
    </div>
</div>

<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-lg p-6 w-96">
        <h2 class="text-xl font-bold mb-4 text-yellow-600">Editar categoría</h2>
        <form id="editCategoryForm" class="space-y-4">
            @csrf
            <input type="hidden" id="edit_id" name="id">
            <input type="text" id="edit_name" name="name"
                class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModal('editModal')"
                    class="px-4 py-1.5 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm transition">Cancelar</button>
                <button type="submit"
                    class="px-4 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-sm shadow transition">Actualizar</button>
            </div>
        </form>
    </div>
</div>

<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-lg p-6 w-96">
        <h2 class="text-xl font-bold mb-4 text-red-600">Eliminar categoría</h2>
        <p class="text-gray-700">¿Seguro que deseas eliminar esta categoría?</p>
        <div class="flex justify-end gap-3 mt-5">
            <button onclick="closeModal('deleteModal')"
                class="px-4 py-1.5 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm transition">Cancelar</button>
            <button id="confirmDeleteBtn"
                class="px-4 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm shadow transition">Eliminar</button>
        </div>
    </div>
</div>

<script>
function openModal(id){ document.getElementById(id).classList.remove('hidden'); }
function closeModal(id){ document.getElementById(id).classList.add('hidden'); }

// Crear
document.getElementById('createCategoryForm').addEventListener('submit', async function(e){
    e.preventDefault();
    const data = {name: this.name.value};
    const token = '{{ session("api_token") }}';
    try {
        const res = await fetch('{{ env("APP_URL") }}/api/category', {
            method:'POST',
            headers:{'Accept':'application/json','Content-Type':'application/json','Authorization':'Bearer '+token},
            body: JSON.stringify(data)
        });
        if(res.ok){ alert('Categoría creada'); closeModal('createModal'); window.location.reload(); }
        else { alert('Error al crear categoría'); }
    } catch(err){ console.error(err); alert('Error de conexión'); }
});

// Editar
function openEditModal(id,name){
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_name').value = name;
    openModal('editModal');
}
document.getElementById('editCategoryForm').addEventListener('submit', async function(e){
    e.preventDefault();
    const id = this.edit_id.value;
    const data = {name: this.edit_name.value};
    const token = '{{ session("api_token") }}';
    try {
        const res = await fetch(`{{ env('APP_URL') }}/api/category/${id}`, {
            method:'PUT',
            headers:{'Accept':'application/json','Content-Type':'application/json','Authorization':'Bearer '+token},
            body: JSON.stringify(data)
        });
        if(res.ok){ alert('Categoría actualizada'); closeModal('editModal'); window.location.reload(); }
        else { alert('Error al actualizar categoría'); }
    } catch(err){ console.error(err); alert('Error de conexión'); }
});

// Eliminar
let deleteId = null;
function openDeleteModal(id){ deleteId = id; openModal('deleteModal'); }
document.getElementById('confirmDeleteBtn').addEventListener('click', async function(){
    if(!deleteId) return;
    const token = '{{ session("api_token") }}';
    try {
        const res = await fetch(`{{ env('APP_URL') }}/api/category/${deleteId}`, {
            method:'DELETE',
            headers:{'Accept':'application/json','Authorization':'Bearer '+token}
        });
        if(res.ok){ alert('Categoría eliminada'); closeModal('deleteModal'); window.location.reload(); }
        else { alert('Error al eliminar categoría'); }
    } catch(err){ console.error(err); alert('Error de conexión'); }
});
</script>
@endsection
