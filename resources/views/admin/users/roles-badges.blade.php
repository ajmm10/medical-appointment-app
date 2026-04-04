@php
    $assignedRoles = $user->roles->pluck('name');
@endphp

@if ($assignedRoles->isEmpty())
    <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
        Sin rol
    </span>
@else
    <div class="flex flex-wrap gap-2">
        @foreach ($assignedRoles as $roleName)
            <span class="inline-flex items-center rounded-full bg-sky-50 px-2.5 py-1 text-xs font-medium text-sky-700">
                {{ $roleName }}
            </span>
        @endforeach
    </div>
@endif
