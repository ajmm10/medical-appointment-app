<aside id="top-bar-sidebar" class="fixed left-0 top-0 z-40 h-screen w-64 border-r border-slate-200 bg-white" aria-label="Sidebar">
    <div class="flex h-16 items-center border-b border-slate-200 px-5">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 text-2xl font-semibold tracking-tight text-slate-900">
            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-emerald-100 text-emerald-700">+</span>
            <span>{{ config('app.name', 'Healthify') }}</span>
        </a>
    </div>

    <nav class="space-y-1 p-4">
        <a
            href="{{ route('admin.dashboard') }}"
            @class([
                'flex items-center gap-3 rounded-md px-3 py-2 text-base transition',
                'bg-slate-100 text-slate-900' => request()->routeIs('admin.dashboard'),
                'text-slate-700 hover:bg-slate-100' => ! request()->routeIs('admin.dashboard'),
            ])
        >
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path d="M10.75 3.25a.75.75 0 0 0-1.5 0v.75H8A2.75 2.75 0 0 0 5.25 6.75V8h9.5V6.75A2.75 2.75 0 0 0 12 4h-1.25v-.75Z" />
                <path fill-rule="evenodd" d="M3.5 9.5A1.5 1.5 0 0 1 5 8h10a1.5 1.5 0 0 1 1.5 1.5v4.75A2.75 2.75 0 0 1 13.75 17h-7.5A2.75 2.75 0 0 1 3.5 14.25V9.5Zm6.5 2a.75.75 0 0 0-.75.75v.5a.75.75 0 0 0 1.5 0v-.5a.75.75 0 0 0-.75-.75Z" clip-rule="evenodd" />
            </svg>
            <span>Dashboard</span>
        </a>

        <p class="px-3 pt-5 text-xs font-semibold uppercase tracking-wide text-slate-400">Gestion</p>

        <a
            href="{{ route('admin.roles.index') }}"
            @class([
                'flex items-center gap-3 rounded-md px-3 py-2 text-base transition',
                'bg-slate-100 text-slate-900' => request()->routeIs('admin.roles.*'),
                'text-slate-700 hover:bg-slate-100' => ! request()->routeIs('admin.roles.*'),
            ])
        >
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 2.5A7.5 7.5 0 1 0 17.5 10 7.5 7.5 0 0 0 10 2.5Zm2.58 6.04a.75.75 0 0 1 .88 1.22l-3.5 2.5a.75.75 0 0 1-.92 0l-2-1.5a.75.75 0 0 1 .9-1.2l1.55 1.17 3.09-2.2Z" clip-rule="evenodd" />
            </svg>
            <span>Roles y permisos</span>
        </a>

        <a
            href="{{ route('admin.users.index') }}"
            @class([
                'flex items-center gap-3 rounded-md px-3 py-2 text-base transition',
                'bg-slate-100 text-slate-900' => request()->routeIs('admin.users.*'),
                'text-slate-700 hover:bg-slate-100' => ! request()->routeIs('admin.users.*'),
            ])
        >
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path d="M10 2.5a3.25 3.25 0 1 1 0 6.5 3.25 3.25 0 0 1 0-6.5Z" />
                <path d="M4.25 15.25A4.75 4.75 0 0 1 9 10.5h2a4.75 4.75 0 0 1 4.75 4.75.75.75 0 0 1-.75.75H5a.75.75 0 0 1-.75-.75Z" />
            </svg>
            <span>Usuarios</span>
        </a>

        <a
            href="{{ route('admin.patients.index') }}"
            @class([
                'flex items-center gap-3 rounded-md px-3 py-2 text-base transition',
                'bg-slate-100 text-slate-900' => request()->routeIs('admin.patients.*'),
                'text-slate-700 hover:bg-slate-100' => ! request()->routeIs('admin.patients.*'),
            ])
        >
            <i class="fa-solid fa-user-injured h-5 w-5"></i>
            <span>Pacientes</span>
        </a>
    </nav>
</aside>
