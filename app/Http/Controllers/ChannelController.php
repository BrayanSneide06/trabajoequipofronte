<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class ChannelController extends Controller
{
    public function index()
    {
        $token = session('api_token');

        if (!$token) {
            return redirect()->route('login.view')
                             ->withErrors('Debes iniciar sesión para ver los canales.');
        }

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])->get(env('APP_URL') . '/api/channel');

        $channels = $response->json()['data'] ?? [];

        return view('channels.index', compact('channels'));
    }
}





