@extends('layouts.app')
@section('title', 'Carritos')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10 bg-gray-50">

    <h1 class="text-2xl font-bold mb-6">Carritos de Clientes</h1>

    @if(count($carts) === 0)
        <p class="text-gray-500">No hay carritos disponibles.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($carts as $cart)
                @php
                    $total = 0;
                    foreach($cart['products'] ?? [] as $p) {
                        $total += ($p['price'] ?? 0) * ($p['quantity'] ?? 1);
                    }
                @endphp
                <div class="bg-white p-5 rounded-2xl shadow hover:shadow-xl transition flex flex-col">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">
                        Cliente: {{ $cart['user']['name'] ?? 'Desconocido' }}
                    </h2>

                    <p class="text-gray-600 mb-2 font-semibold">
                        Total: ${{ number_format($total, 2) }}
                    </p>

                    <p class="text-gray-500 text-sm mb-3">
                        Productos: 
                        @if(!empty($cart['products']))
                            {{ count($cart['products']) }} item(s) - 
                            @foreach($cart['products'] as $index => $p)
                                {{ $p['name'] }} (x{{ $p['quantity'] ?? 1 }})@if($index < count($cart['products'])-1), @endif
                            @endforeach
                        @else
                            0
                        @endif
                    </p>

                    <button onclick="openCartModal({{ json_encode($cart) }})"
                        class="mt-auto px-3 py-1 bg-orange-600 hover:bg-orange-700 text-white rounded-lg text-sm">
                        Ver Detalles
                    </button>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Modal Detalles del Carrito -->
<div id="cartModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96 max-h-[80vh] overflow-y-auto">
        <h2 class="text-xl font-bold mb-4 text-orange-600">Detalles del Carrito</h2>
        <ul id="cartProductsList" class="space-y-2 text-gray-700"></ul>
        <p id="cartTotal" class="text-right font-semibold mt-3 text-gray-800"></p>
        <div class="flex justify-end mt-4">
            <button onclick="closeModal('cartModal')" class="px-3 py-1 bg-gray-300 text-gray-700 rounded-lg text-sm">Cerrar</button>
        </div>
    </div>
</div>

<script>
function openCartModal(cart){
    const list = document.getElementById('cartProductsList');
    list.innerHTML = '';

    let total = 0;
    (cart.products || []).forEach(p => {
        const li = document.createElement('li');
        const subtotal = (p.price || 0) * (p.quantity || 1);
        li.textContent = `${p.name} - Cantidad: ${p.quantity} - $${p.price} - Subtotal: $${subtotal}`;
        list.appendChild(li);
        total += subtotal;
    });

    document.getElementById('cartTotal').textContent = `Total: $${total.toFixed(2)}`;
    document.getElementById('cartModal').classList.remove('hidden');
}

function closeModal(id){
    document.getElementById(id).classList.add('hidden');
}
</script>
@endsection

