@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Lista de Canales</h1>

    @if(count($channels) > 0)
        <table class="w-full border border-gray-300 rounded-lg shadow">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">ID</th>
                    <th class="p-2 border">Tipo</th>
                    <th class="p-2 border">Enlace</th>
                </tr>
            </thead>
            <tbody>
                @foreach($channels as $channel)
                <tr>
                    <td class="p-2 border">{{ $channel['id'] }}</td>
                    <td class="p-2 border">{{ $channel['type'] }}</td>
                    <td class="p-2 border">
                        <a href="{{ $channel['link'] }}" target="_blank" class="text-blue-600 underline">
                            {{ $channel['link'] }}
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-gray-600">No hay canales disponibles.</p>
    @endif
</div>
@endsection



