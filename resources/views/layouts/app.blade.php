<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'MiTienda')</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-800">

  <!-- Navbar -->
  @include('includes.navbar')

  <!-- Contenido principal -->
  <main class="pt-20"> 
      <!-- pt-20 agrega padding para que el navbar fijo no tape el contenido -->
      @yield('content')
  </main>

  <!-- Footer -->
  @include('includes.footer')




</body>
</html>
