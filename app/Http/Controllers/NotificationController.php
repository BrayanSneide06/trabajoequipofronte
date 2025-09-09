<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NotificationController extends Controller
{
    public function index()
    {
        $token = session('api_token');

        if (!$token) {
            return redirect()->route('login.view')
                             ->withErrors('Debes iniciar sesión para ver tus notificaciones.');
        }

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])->get(env('APP_URL') . '/api/notification');

        // 🔎 Revisa qué trae tu API
        // dd($response->json());

        // ✅ VERSION 1: si la API devuelve { "data": [...] }
        $notifications = $response->json()['data'] ?? [];

        // ✅ VERSION 2: si la API devuelve { "notifications": [...] }
        // $notifications = $response->json()['notifications'] ?? [];

        // ✅ VERSION 3: si la API devuelve [ { ... }, { ... } ]
        // $notifications = $response->json() ?? [];

        return view('notifications.index', compact('notifications'));
    }
}






