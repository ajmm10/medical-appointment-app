<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
  <h2 class="text-lg font-semibold text-gray-900">Información del perfil</h2>

  <div class="mt-4 flex items-center gap-4">
    <img class="w-16 h-16 rounded-full" src="{{ asset('images/profile.jpg') }}" alt="profile photo">
    <div>
      <p class="text-gray-900 font-medium">Ángel de Jesús May</p>
      <p class="text-gray-500 text-sm">angel@demo.com</p>
      <p class="text-gray-500 text-sm">Zona horaria: {{ config('app.timezone') }}</p>
      <p class="text-gray-500 text-sm">Idioma: {{ config('app.locale') }}</p>
    </div>
  </div>
</div>
