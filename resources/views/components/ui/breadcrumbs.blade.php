@props(['items'])

<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => collect($items)->values()->map(fn ($item, $i) => array_filter([
        '@type' => 'ListItem',
        'position' => $i + 1,
        'name' => $item['label'],
        'item' => $item['url'] ?? null,
    ]))->all(),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>

<nav aria-label="Хлебные крошки" class="mx-auto w-full max-w-page">
    <ol class="flex items-center gap-2">
        @foreach ($items as $item)
            <li class="flex items-center gap-2">
                @if (! $loop->last)
                    <a
                        href="{{ $item['url'] ?? '#' }}"
                        class="text-control-s text-text-disable transition-colors hover:text-text-main focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-1"
                    >{{ $item['label'] }}</a>
                    <x-icon.crumb class="size-1.5 text-text-main" />
                @else
                    <span aria-current="page" class="text-control-s text-text-main">{{ $item['label'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
