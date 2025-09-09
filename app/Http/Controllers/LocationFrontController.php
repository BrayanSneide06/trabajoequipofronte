<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LocationFrontController extends Controller
{
    public function index()
    {
        // Obtener token de sesión
        $token = session('api_token');

        if (!$token) {
            return redirect()->route('login.view')
                             ->withErrors('Debes iniciar sesión para ver las ubicaciones.');
        }

        // Petición a la API
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->get(env('APP_URL') . '/api/location?included=user');

        // Validar que la respuesta sea un array
        $locationsData = $response->json();

        if (!is_array($locationsData)) {
            $locationsData = [];
        }

        // Normalizar: si devuelve paginación con 'data'
        $locations = $locationsData['data'] ?? $locationsData;

        return view('locations.index', compact('locations'));
    }
}



