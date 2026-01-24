<x-admin-layout>
  <div class="space-y-6">

    {{-- Texto dinámico por slot (requisito de la tarea) --}}
    <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
      <p class="text-blue-800 font-medium">Hola desde admin</p>
      <p class="text-blue-700 text-sm">
        Este contenido está renderizado usando el slot del layout.
      </p>
    </div>

    {{-- Perfil incrustado --}}
    @include('admin.partials.profile-card')

  </div>
</x-admin-layout>
