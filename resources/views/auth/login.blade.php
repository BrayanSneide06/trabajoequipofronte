<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="min-h-screen bg-cover bg-center"
      style="background-image: url('https://images.pexels.com/photos/32470995/pexels-photo-32470995.jpeg');">

  <div class="min-h-screen flex items-center justify-center px-4">
    <div class="bg-white bg-opacity-20 backdrop-blur-md text-white p-10 rounded-2xl shadow-2xl w-full max-w-md">

      <!-- LOGO -->
      <div class="flex justify-center mb-6">
        <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-14 w-auto">
      </div>

      <!-- TÍTULO -->
      <h2 class="text-3xl font-bold text-center mb-6">Iniciar Sesión</h2>

      <!-- FORMULARIO -->
      <form id="loginForm" class="flex flex-col gap-4">
        <input type="email" name="email" placeholder="Correo" required
               class="bg-white bg-opacity-20 text-white placeholder-white border border-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-300" />

        <input type="password" name="password" placeholder="Contraseña" required
               class="bg-white bg-opacity-20 text-white placeholder-white border border-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-300" />

        <button type="submit"
                class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 rounded-lg transition-all shadow-md hover:shadow-lg">
          Iniciar Sesión
        </button>
      </form>

      <div id="errorMsg" class="text-red-300 text-center mt-3"></div>

      <p class="text-center text-white mt-4">
        ¿No tienes cuenta? 
        <a href="{{ route('register.view') }}" class="text-purple-300 font-semibold hover:underline">Regístrate</a>
      </p>

    </div>
  </div>

  <!-- SCRIPT DE LOGIN -->
  <script>
    document.getElementById('loginForm').addEventListener('submit', async function(e) {
      e.preventDefault();

      const email = this.email.value;
      const password = this.password.value;
      const msgDiv = document.getElementById('errorMsg');

      msgDiv.innerText = '';
      msgDiv.classList.remove('text-green-500');
      msgDiv.classList.add('text-red-300');

      try {
        const res = await fetch('http://127.0.0.1:8000/api/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({ email, password }),
          credentials: 'include'
        });

        const data = await res.json();

        if (!res.ok) {
          msgDiv.innerText = data.message || 'Credenciales incorrectas';
          return;
        }

        // Guardar token en sesión
        await fetch('{{ url("/save-token") }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({ token: data.access_token }),
          credentials: 'include'
        });

        msgDiv.classList.remove('text-red-300');
        msgDiv.classList.add('text-green-500');
        msgDiv.innerText = '¡Inicio de sesión exitoso! Redirigiendo...';

        setTimeout(() => {
          window.location.href = '{{ route("products.index") }}';
        }, 1000);

      } catch (err) {
        console.error('Error al conectar con el backend:', err);
        msgDiv.innerText = 'Error de conexión con el servidor';
      }
    });
  </script>

</body>
</html>

