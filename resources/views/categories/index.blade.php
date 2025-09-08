@extends('layouts.app')
@section('title', 'Categorías')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10 bg-gray-50">

    <!-- Crear categoría -->
    <div class="mb-6 flex justify-end">
        <button onclick="openModal('createModal')"
            class="bg-orange-600 hover:bg-orange-700 text-white font-semibold px-4 py-1.5 rounded-lg shadow text-sm">
            Crear categoría
        </button>
    </div>

    @if(count($categories) === 0)
        <p class="text-center text-gray-500 text-lg">No hay categorías disponibles.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach($categories as $category)
                <div class="bg-white border border-gray-200 rounded-lg shadow p-4 flex justify-between items-center">
                    <span class="font-medium">{{ $category['name'] ?? 'Nombre no disponible' }}</span>
                    <div class="flex gap-2">
                        <button onclick="openEditModal({{ $category['id'] }}, '{{ $category['name'] }}')"
                            class="px-2 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded text-sm">Editar</button>
                        <button onclick="openDeleteModal({{ $category['id'] }})"
                            class="px-2 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm">Eliminar</button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Modales -->
<div id="createModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96">
        <h2 class="text-xl font-bold mb-4 text-orange-600">Crear categoría</h2>
        <form id="createCategoryForm">
            @csrf
            <input type="text" name="name" placeholder="Nombre" class="w-full border rounded p-2 mb-4" required>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal('createModal')" class="px-3 py-1 bg-gray-300 rounded text-sm">Cancelar</button>
                <button type="submit" class="px-3 py-1 bg-orange-600 text-white rounded text-sm">Guardar</button>
            </div>
        </form>
    </div>
</div>

<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96">
        <h2 class="text-xl font-bold mb-4 text-orange-600">Editar categoría</h2>
        <form id="editCategoryForm">
            @csrf
            <input type="hidden" id="edit_id" name="id">
            <input type="text" id="edit_name" name="name" class="w-full border rounded p-2 mb-4" required>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal('editModal')" class="px-3 py-1 bg-gray-300 rounded text-sm">Cancelar</button>
                <button type="submit" class="px-3 py-1 bg-yellow-500 text-white rounded text-sm">Actualizar</button>
            </div>
        </form>
    </div>
</div>

<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96">
        <h2 class="text-xl font-bold mb-4 text-red-600">Eliminar categoría</h2>
        <p class="text-gray-700">¿Seguro que deseas eliminar esta categoría?</p>
        <div class="flex justify-end gap-2 mt-4">
            <button onclick="closeModal('deleteModal')" class="px-3 py-1 bg-gray-300 rounded text-sm">Cancelar</button>
            <button id="confirmDeleteBtn" class="px-3 py-1 bg-red-600 text-white rounded text-sm">Eliminar</button>
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
