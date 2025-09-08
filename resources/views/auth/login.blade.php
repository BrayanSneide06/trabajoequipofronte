<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gradient-to-b from-orange-500 to-white min-h-screen flex items-center justify-center">

  <div class="bg-white p-10 rounded-2xl shadow-2xl w-full max-w-md">
    <h2 class="text-3xl font-bold text-gray-800 text-center mb-6">Iniciar Sesión</h2>

    <form id="loginForm" class="flex flex-col gap-4">
      <input type="email" name="email" placeholder="Correo" required
             class="border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition" />

      <input type="password" name="password" placeholder="Contraseña" required
             class="border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition" />

      <button type="submit"
              class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 rounded-lg transition-all shadow-md hover:shadow-lg">
        Iniciar Sesión
      </button>
    </form>

    <div id="errorMsg" class="text-red-500 text-center mt-3"></div>

    <p class="text-center text-gray-500 mt-4">
      ¿No tienes cuenta? 
      <a href="{{ route('register.view') }}" class="text-purple-600 font-semibold hover:underline">Regístrate</a>
    </p>
  </div>

  <script>
document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const email = this.email.value;
    const password = this.password.value;
    const msgDiv = document.getElementById('errorMsg');

    msgDiv.innerText = '';
    msgDiv.classList.remove('text-green-500');
    msgDiv.classList.add('text-red-500');

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
        console.log('Respuesta backend:', data);

        if (!res.ok) {
            msgDiv.innerText = data.message || 'Credenciales incorrectas';
            return;
        }

        // Guardar token en session backend
        await fetch('{{ url("/save-token") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ token: data.access_token }),
            credentials: 'include'
        });

        // Mensaje de éxito
        msgDiv.classList.remove('text-red-500');
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










