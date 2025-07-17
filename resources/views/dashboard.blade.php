<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="p-8">
        <h1 class="text-2xl font-bold">¡Bienvenido, {{ Auth::user()->name }}!</h1>
        <p class="mt-2">Iniciaste sesión correctamente</p>
    </div>
    <form method="POST" action="{{ route('logout') }}" class="mt-4">
        @csrf
        <button type="submit" class="text-indigo-600 hover:text-indigo-900">
            Cerrar sesión
        </button>
    </form>
</body>
</html>
