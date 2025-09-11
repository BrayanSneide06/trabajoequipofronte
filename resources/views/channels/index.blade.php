@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-8 text-orange-600 text-center">Canales de Comunicación</h1>

    @if(count($channels) > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($channels as $channel)
            <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1 p-6 flex flex-col items-start space-y-4">
                <!-- Icono según el tipo -->
                <div class="text-4xl">
                    @switch($channel['type'])
                        @case('instagram') 📸 @break
                        @case('whatsapp') 💬 @break
                        @case('facebook') 📘 @break
                        @case('twitter') 🐦 @break
                        @case('tiktok') 🎵 @break
                        @case('linkedin') 💼 @break
                        @case('telegram') ✈️ @break
                        @case('youtube') ▶️ @break
                        @case('pinterest') 📌 @break
                        @default 🔗
                    @endswitch
                </div>

                <h2 class="text-lg font-semibold capitalize">{{ $channel['type'] }}</h2>

                <a href="{{ $channel['link'] }}" target="_blank" 
                   class="text-blue-600 hover:text-blue-800 underline break-all transition">
                    {{ $channel['link'] }}
                </a>

                <button onclick="openChannelModal({{ json_encode($channel) }})" 
                    class="mt-auto px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-semibold text-sm transition">
                    Ver Detalles
                </button>
            </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-600 text-center mt-4">No hay canales disponibles.</p>
    @endif
</div>

<!-- Modal Detalles del Canal -->
<div id="channelModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-3xl shadow-xl p-6 w-96 max-h-[80vh] overflow-y-auto relative">
        <h2 class="text-2xl font-bold mb-4 text-orange-600 text-center">Detalles del Canal</h2>

        <ul id="channelDetailsList" class="space-y-3 text-gray-700"></ul>

        <button onclick="closeModal('channelModal')" 
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-xl font-bold">&times;</button>
    </div>
</div>

<script>
function openChannelModal(channel){
    const list = document.getElementById('channelDetailsList');
    list.innerHTML = '';

    const details = [
        { label: 'ID', value: channel.id },
        { label: 'Tipo', value: channel.type },
        { label: 'Link', value: channel.link },
        { label: 'Creado', value: channel.created_at },
        { label: 'Actualizado', value: channel.updated_at }
    ];

    details.forEach(d => {
        const li = document.createElement('li');
        li.classList.add('flex', 'justify-between', 'bg-gray-50', 'p-2', 'rounded-lg', 'shadow-sm');
        li.innerHTML = `<span class="font-medium">${d.label}:</span> <span>${d.value}</span>`;
        list.appendChild(li);
    });

    document.getElementById('channelModal').classList.remove('hidden');
}

function closeModal(id){
    document.getElementById(id).classList.add('hidden');
}
</script>
@endsection
tion
