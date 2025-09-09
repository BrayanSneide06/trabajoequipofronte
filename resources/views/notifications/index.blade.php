@extends('layouts.app')
@section('title', 'Notificaciones')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10 bg-gray-50">

    <h1 class="text-2xl font-bold mb-6">Notificaciones</h1>

    {{-- Mostrar errores si algo falla --}}
    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-6">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if(count($notifications) === 0)
        <p class="text-gray-500">No tienes notificaciones.</p>
    @else
        <div class="space-y-4">
            @foreach($notifications as $notif)
                <div class="bg-white p-5 rounded-2xl shadow hover:shadow-md transition">
                    <h2 class="text-lg font-semibold text-gray-800 mb-1">
                        {{ $notif['title'] ?? 'Sin título' }}
                    </h2>
                    <p class="text-gray-600 mb-2">
                        {{ $notif['message'] ?? 'Sin contenido' }}
                    </p>
                    <span class="text-xs text-gray-400">
                        {{ $notif['created_at'] ?? '' }}
                    </span>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection



