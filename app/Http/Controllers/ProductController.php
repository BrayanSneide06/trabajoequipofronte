<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $token = session('api_token');

        if (!$token) {
            return redirect()->route('login.view')->withErrors('Debes iniciar sesión para ver los productos.');
        }

        // Productos
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])->get(env('APP_URL') . '/api/product');

        $data = $response->json();
        $products = $data['data'] ?? [];

        // Categorías
        $catResponse = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])->get(env('APP_URL') . '/api/category');
        $categories = $catResponse->json()['data'] ?? [];

        // Tiendas
        $storeResponse = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])->get(env('APP_URL') . '/api/store');
        $stores = $storeResponse->json()['data'] ?? [];

        return view('products.index', compact('products', 'categories', 'stores'));
        }


}
