<div class="flex items-center gap-2">
    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="delete-form inline">
        @csrf
        @method('DELETE')

        <x-wire-button type="submit" red xs>
            <i class="fa-solid fa-trash"></i>
        </x-wire-button>
    </form>
</div>
