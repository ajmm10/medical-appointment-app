<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/3f8ce600e5.js" crossorigin="anonymous"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- WireUI -->
    <wireui:scripts />

    <!-- Styles -->
    @livewireStyles
</head>

<body class="bg-slate-50 font-sans antialiased text-slate-900">

    {{-- Navbar --}}
    @include('layouts.includes.admin.navigation')

    {{-- Sidebar --}}
    @include('layouts.includes.admin.sidebar')

    {{-- Content --}}
    <div class="mt-16 p-4 sm:ml-64 sm:p-6">
        <div class="space-y-4">

            {{-- Breadcrumb --}}
            @if (!empty($breadcrumbs))
                @include('layouts.includes.breadcrumb', ['breadcrumbs' => $breadcrumbs])
            @endif

            {{-- Header --}}
            @if (!empty($title) || isset($action))
                <div class="flex flex-wrap items-center justify-between gap-3">
                    @if (!empty($title))
                        <h1 class="text-3xl font-semibold">
                            {{ $title }}
                        </h1>
                    @endif

                    @if (isset($action))
                        <div class="shrink-0">
                            {{ $action }}
                        </div>
                    @endif
                </div>
            @endif

            {{-- Dynamic content --}}
            {{ $slot }}

        </div>
    </div>

    @stack('modals')

    {{-- Mostrar Sweet alert --}}
    @if(session('swal'))
        <script>
            Swal.fire(@json(session('swal')));
        </script>
    @endif

    @livewireScripts
    <script>
        //Busca todos los elementos de la clase especifica
        document.querySelectorAll('.delete-form').forEach((form) => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'No podrás revertir esta acción.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#2563eb',
                    cancelButtonColor: '#dc2626',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
</body>
</html>
