<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center
             bg-gradient-to-b from-orange-500 to-white">

  <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-lg flex flex-col gap-4 backdrop-blur-sm bg-opacity-80">

    {{-- Mensaje de éxito --}}
    @if(session('success'))
      <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 text-center">
        {{ session('success') }}
      </div>
    @endif

    {{-- Errores de Laravel --}}
    @if($errors->any())
      <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
        <ul class="list-disc list-inside">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    {{-- Errores del API --}}
   @if($errors->any())
  <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
    <ul class="list-disc list-inside">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

    <form method="POST" action="{{ route('register.post') }}" class="flex flex-col gap-4">
      @csrf
      <h2 class="text-2xl font-bold text-gray-800 text-center mb-4">Registrarse</h2>

      <input type="text" name="name" placeholder="Nombre" value="{{ old('name') }}" required
             class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" />

      <input type="email" name="email" placeholder="Correo" value="{{ old('email') }}" required
             class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" />

      <input type="password" name="password" placeholder="Contraseña" required
             class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" />

      <input type="password" name="password_confirmation" placeholder="Confirmar Contraseña" required
             class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" />

      <select name="role_id" required
              class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
        <option value="1" {{ old('role_id') == 1 ? 'selected' : '' }}>Usuario</option>
        <option value="2" {{ old('role_id') == 2 ? 'selected' : '' }}>Administrador</option>
      </select>

      <button type="submit" 
              class="bg-blue-500 hover:bg-purple-600 text-white font-semibold py-2 rounded-lg transition-all">
        Registrarse
      </button>

      <p class="text-center text-gray-500 mt-2">¿Ya tienes cuenta?</p>
      <a href="{{ route('login.view') }}" class="w-full block">
        <button type="button" 
                class="w-full bg-white border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white font-semibold py-2 rounded-lg transition-all">
          Iniciar sesión
        </button>
      </a>
    </form>
  </div>

</body>
</html>









