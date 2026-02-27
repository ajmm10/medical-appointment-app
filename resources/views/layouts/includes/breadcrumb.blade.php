@if (! empty($breadcrumbs))
    <nav class="mb-2 block">
        <ol class="flex flex-wrap items-center gap-2 text-sm text-slate-700">
            @foreach ($breadcrumbs as $item)
                <li class="flex items-center gap-2">
                    @isset($item['href'])
                        <a href="{{ $item['href'] }}" class="opacity-60 transition hover:opacity-100">
                            {{ $item['name'] }}
                        </a>
                    @else
                        <span>{{ $item['name'] }}</span>
                    @endisset

                    @if (! $loop->last)
                        <span class="opacity-40">/</span>
                    @endif
                </li>
            @endforeach
        </ol>

        @if (count($breadcrumbs) > 1)
            @php($currentBreadcrumb = collect($breadcrumbs)->last())

            @if ($currentBreadcrumb)
                <h6 class="mt-2 font-bold">
                    {{ $currentBreadcrumb['name'] ?? '' }}
                </h6>
            @endif
        @endif
    </nav>
@endif
