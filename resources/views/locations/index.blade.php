@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Ubicaciones</h1>

    <table class="table-auto w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Dirección</th>
                <th class="border px-4 py-2">Ciudad</th>
                <th class="border px-4 py-2">Estado</th>
                <th class="border px-4 py-2">Código Postal</th>
                <th class="border px-4 py-2">País</th>
                <th class="border px-4 py-2">Latitud</th>
                <th class="border px-4 py-2">Usuario</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($locations as $location)
                @php
                    // Forzar array si viene como objeto
                    $loc = is_array($location) ? $location : (array) $location;
                    $user = $loc['user'] ?? [];
                    $userName = is_array($user) ? ($user['name'] ?? 'Sin usuario') : (property_exists($user, 'name') ? $user->name : 'Sin usuario');
                @endphp
                <tr>
                    <td class="border px-4 py-2">{{ $loc['id'] ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $loc['address'] ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $loc['city'] ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $loc['state'] ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $loc['postal_code'] ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $loc['country'] ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $loc['latitude'] ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $userName }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="border px-4 py-2 text-center">No hay ubicaciones</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection


