<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200">
  <div class="px-3 py-3 lg:px-5 lg:pl-3">
    <div class="flex items-center justify-between">
      <div class="flex items-center">
        <span class="self-center text-xl font-semibold whitespace-nowrap">Admin Panel</span>
      </div>

      <div class="flex items-center">
        {{-- Botón avatar --}}
        <button type="button"
          class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300"
          id="user-menu-button"
          aria-expanded="false"
          data-dropdown-toggle="dropdown-user">
          <span class="sr-only">Open user menu</span>
          <img class="w-8 h-8 rounded-full"
               src="{{ asset('images/profile.jpg') }}"
               alt="user photo">
        </button>

        {{-- Dropdown --}}
        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow"
             id="dropdown-user">
          <div class="px-4 py-3">
            <p class="text-sm text-gray-900">Ángel</p>
            <p class="text-sm font-medium text-gray-500 truncate">angel@demo.com</p>
          </div>
          <ul class="py-1">
            <li>
              <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mi perfil</a>
            </li>
            <li>
              <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Configuración</a>
            </li>
          </ul>
        </div>
      </div>

    </div>
  </div>
</nav>
