<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-cover bg-center flex items-center" 
      style="background-image: url('https://images.pexels.com/photos/4101274/pexels-photo-4101274.jpeg');">

  <div class="w-full max-w-md ml-20"> {{-- <-- Alineado a la izquierda --}}
    
    {{-- LOGO --}}
    <div class="mb-4">
      <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-14 w-auto">
    </div>

    {{-- ÉXITO --}}
    @if(session('success'))
      <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 text-center">
        {{ session('success') }}
      </div>
    @endif

    {{-- ERRORES --}}
    @if($errors->any())
      <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
        <ul class="list-disc list-inside">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    {{-- FORMULARIO --}}
    <form method="POST" action="{{ route('register.post') }}" class="flex flex-col gap-4 text-white">
      @csrf
      <h2 class="text-3xl font-bold mb-4">Registrarse</h2>

      <input type="text" name="name" placeholder="Nombre" value="{{ old('name') }}" required
             class="bg-white bg-opacity-20 text-white placeholder-white border border-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" />

      <input type="email" name="email" placeholder="Correo" value="{{ old('email') }}" required
             class="bg-white bg-opacity-20 text-white placeholder-white border border-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" />

      <input type="password" name="password" placeholder="Contraseña" required
             class="bg-white bg-opacity-20 text-white placeholder-white border border-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" />

      <input type="password" name="password_confirmation" placeholder="Confirmar Contraseña" required
             class="bg-white bg-opacity-20 text-white placeholder-white border border-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" />

      <select name="role_id" required
              class="bg-white bg-opacity-20 text-white border border-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300">
        <option value="1" {{ old('role_id') == 1 ? 'selected' : '' }}>Usuario</option>
        <option value="2" {{ old('role_id') == 2 ? 'selected' : '' }}>Administrador</option>
      </select>

      <button type="submit" 
              class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition-all">
        Registrarse
      </button>

      <p class="text-white text-sm text-center mt-2">¿Ya tienes cuenta?</p>
      
      <a href="{{ route('login.view') }}" class="w-full block">
        <button type="button" 
                class="w-full border border-white text-white hover:bg-white hover:text-blue-600 font-semibold py-2 rounded-lg transition-all">
          Iniciar sesión
        </button>
      </a>
    </form>
  </div>

</body>
</html>

