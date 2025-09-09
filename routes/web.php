<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\LocationFrontController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

// FORMULARIO DE REGISTRO
Route::get('/register', function () {
    return view('auth.register');
})->name('register.view');

Route::post('/register', function (Request $request) {
    $response = Http::post(env('APP_URL').'/api/register', $request->all());

    if ($response->successful()) {
        return redirect()->route('login.view')
                         ->with('success', 'Registro exitoso. Ahora inicia sesión.');
    }

    return back()->withErrors($response->json())->withInput();
})->name('register.post');

// FORMULARIO DE LOGIN
Route::get('/login', function () {
    return view('auth.login');
})->name('login.view');

Route::post('/login', function (Request $request) {
    $response = Http::post(env('APP_URL').'/api/login', $request->only('email', 'password'));

    if ($response->successful()) {
        session(['api_token' => $response->json()['access_token']]);
        return redirect()->route('dashboard')->with('success', 'Bienvenido!');
    }

    return back()->withErrors(['email' => 'Credenciales inválidas'])->withInput();
})->name('login.post');


// DASHBOARD
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// LISTADO DE PRODUCTOS
Route::get('/products', [ProductController::class, 'index'])->name('products.index');


// LISTADO DE PRODUCTOS
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// RUTA AUXILIAR PARA GUARDAR TOKEN DESDE JS (opcional si usas JS SPA)
Route::post('/save-token', function(Request $request){
    session(['api_token' => $request->token]);
    return response()->json(['success' => true]);
});




Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

Route::get('/carts', [CartController::class, 'index'])->name('carts.index');

Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');


Route::get('/channels', [ChannelController::class, 'index'])->name('channels.index');


Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');



Route::get('/locations', [LocationFrontController::class, 'index'])->name('locations.index');