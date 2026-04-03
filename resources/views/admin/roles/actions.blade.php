<div class="flex items-center gap-2">
    @if ($role->is_system)
        <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">
            <i class="fa-solid fa-lock"></i>
            Protegido
        </span>
    @else
        <x-wire-button href="{{ route('admin.roles.edit', $role) }}" blue xs>
            <i class="fa-solid fa-pen-to-square"></i>
        </x-wire-button>

        <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <x-wire-button type="submit" red xs>
                <i class="fa-solid fa-trash"></i>
            </x-wire-button>
        </form>
    @endif
</div>
