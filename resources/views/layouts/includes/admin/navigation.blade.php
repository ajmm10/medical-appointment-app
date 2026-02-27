@php
    $user = auth()->user();
    $initials = $user
        ? collect(explode(' ', trim($user->name)))
            ->filter()
            ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
            ->take(2)
            ->join('')
        : 'TU';
@endphp

<nav class="fixed top-0 z-30 h-16 w-full border-b border-slate-200 bg-white">
    <div class="flex h-full items-center justify-end px-4 sm:pl-64 sm:pr-6">
        <span class="text-sm font-semibold text-indigo-300">{{ $initials }}</span>
    </div>
</nav>
