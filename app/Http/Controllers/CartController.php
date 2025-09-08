<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CartController extends Controller
{
    public function index()
    {
        $token = session('api_token');

        if (!$token) {
            return redirect()->route('login.view')->withErrors('Debes iniciar sesión para ver los carritos.');
        }

        // Obtener carritos desde la API
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])->get(env('APP_URL') . '/api/cart');

        $carts = $response->json()['data'] ?? [];

        return view('carts.index', compact('carts'));
    }
}

