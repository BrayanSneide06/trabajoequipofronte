@extends('layouts.app')
@section('title', 'Notificaciones')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10 bg-gray-50 min-h-screen">

    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-orange-600 flex items-center gap-2">
            🔔 Notificaciones
        </h1>
        <span class="text-sm text-gray-500">
            Tienes {{ count($notifications) }} notificación(es)
        </span>
    </div>

    {{-- Mostrar errores si algo falla --}}
    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-6">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if(count($notifications) === 0)
        <div class="bg-white p-6 rounded-xl shadow text-center text-gray-500">
            No tienes notificaciones por ahora. 🎉
        </div>
    @else
        <div class="space-y-4">
            @foreach($notifications as $notif)
                @php
                    $isRead = $notif['is_read'] ?? 0;
                @endphp
                <div class="flex items-start bg-white p-5 rounded-xl shadow-sm hover:shadow-md transition 
                    border-l-4 {{ $isRead ? 'border-green-500' : 'border-orange-500' }}">
                    
                    {{-- Icono leído / no leído --}}
                    <div class="flex-shrink-0 mr-4">
                        @if($isRead)
                            <span class="text-green-500 text-2xl">✅</span>
                        @else
                            <span class="text-orange-500 text-2xl">📩</span>
                        @endif
                    </div>

                    <div class="flex-1">
                        <h2 class="text-lg font-semibold text-gray-800 mb-1">
                            {{ $notif['title'] ?? 'Sin título' }}
                        </h2>
                        <p class="text-gray-600 mb-2">
                            {{ $notif['message'] ?? 'Sin contenido' }}
                        </p>
                        <div class="flex items-center justify-between text-xs text-gray-400">
                            <span>
                                {{ \Carbon\Carbon::parse($notif['created_at'])->format('d/m/Y H:i') }}
                            </span>
                            <span class="px-2 py-0.5 rounded-full text-white text-[10px]
                                {{ $isRead ? 'bg-green-500' : 'bg-orange-500' }}">
                                {{ $isRead ? 'Leída' : 'No leída' }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
