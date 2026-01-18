<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title ?? 'Admin' }}</title>

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">

  {{-- Navbar --}}
  @include('admin.partials.navbar')

  <div class="flex">
    {{-- Sidebar --}}
    @include('admin.partials.sidebar')

    {{-- Content --}}
    <main class="flex-1 p-6 lg:ml-64">
      {{ $slot }}
    </main>
  </div>

</body>
</html>
<x-admin-layout>
  <div class="space-y-6">
    {{-- Texto dinámico por slot (requisito) --}}
    <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
      <p class="text-blue-800 font-medium">Hola desde admin</p>
      <p class="text-blue-700 text-sm">Este contenido está renderizado dentro del slot del layout.</p>
    </div>

    {{-- Perfil incrustado en la plantilla --}}
    @include('admin.partials.profile-card')
  </div>
</x-admin-layout>
