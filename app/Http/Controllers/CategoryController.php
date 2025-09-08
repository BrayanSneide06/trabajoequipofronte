<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CategoryController extends Controller
{
    public function index()
    {
        $token = session('api_token');

        if (!$token) {
            return redirect()->route('login.view')->withErrors('Debes iniciar sesión para ver las categorías.');
        }

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])->get(env('APP_URL') . '/api/category');

        $categories = $response->json()['data'] ?? [];

        return view('categories.index', compact('categories'));
    }
}

