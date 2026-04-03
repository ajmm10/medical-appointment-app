@if ($role->is_system)
    <span class="inline-flex items-center gap-2 rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">
        <i class="fa-solid fa-lock"></i>
        Sistema
    </span>
@else
    <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">
        Personalizado
    </span>
@endif
