@extends('layouts.app')
@section('title', 'Carritos')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10 bg-gray-50">

    <h1 class="text-3xl font-extrabold mb-8 text-orange-600 text-center">Carritos de Clientes</h1>

    @if(count($carts) === 0)
        <p class="text-gray-500 text-center text-lg">No hay carritos disponibles.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($carts as $cart)
                @php
                    $total = 0;
                    foreach($cart['products'] ?? [] as $p) {
                        $total += ($p['price'] ?? 0) * ($p['quantity'] ?? 1);
                    }
                @endphp
                <div class="bg-slate-100 p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-transform transform hover:-translate-y-1 flex flex-col w-full max-w-xs mx-auto border-l-4 border-orange-500">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">
                        <span class="text-orange-500">Cliente:</span> {{ $cart['user']['name'] ?? 'Desconocido' }}
                    </h2>

                    <p class="text-gray-700 mb-3 font-semibold text-lg">
                        Total: <span class="text-green-600">${{ number_format($total, 2) }}</span>
                    </p>

                    <p class="text-gray-500 text-sm mb-6">
                        <span class="font-medium text-gray-700">Productos:</span> 
                        @if(!empty($cart['products']))
                            {{ count($cart['products']) }} item(s) - 
                            @foreach($cart['products'] as $index => $p)
                                <span class="inline-block bg-gray-200 rounded-full px-2 py-1 text-xs font-medium text-gray-600">
                                    {{ $p['name'] }} (x{{ $p['quantity'] ?? 1 }})
                                </span>@if($index < count($cart['products'])-1), @endif
                            @endforeach
                        @else
                            0
                        @endif
                    </p>

                    <button onclick="openCartModal({{ json_encode($cart) }})"
                        class="mt-auto px-4 py-3 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg text-sm transition">
                        Ver Detalles
                    </button>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Modal Detalles del Carrito -->
<div id="cartModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-3xl shadow-xl p-6 w-96 max-h-[80vh] overflow-y-auto relative">
        <h2 class="text-2xl font-bold mb-4 text-orange-600 text-center">Detalles del Carrito</h2>

        <ul id="cartProductsList" class="space-y-3 text-gray-700"></ul>
        <p id="cartTotal" class="text-right font-semibold mt-4 text-gray-800 text-lg"></p>

        <button onclick="closeModal('cartModal')" 
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-xl font-bold">&times;</button>
    </div>
</div>

<script>
function openCartModal(cart){
    const list = document.getElementById('cartProductsList');
    list.innerHTML = '';

    let total = 0;
    (cart.products || []).forEach(p => {
        const li = document.createElement('li');
        li.classList.add('flex', 'justify-between', 'bg-gray-50', 'p-2', 'rounded-lg', 'shadow-sm');
        const subtotal = (p.price || 0) * (p.quantity || 1);
        li.innerHTML = `
            <span>${p.name} (x${p.quantity || 1})</span>
            <span>$${subtotal.toFixed(2)}</span>
        `;
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
