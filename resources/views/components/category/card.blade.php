@props(['category'])

<a
    href="{{ route('category', $category['slug']) }}"
    {{ $attributes->merge(['class' => 'relative block h-[260px] overflow-hidden rounded-control-l bg-bg-secondary transition-opacity hover:opacity-90 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-1']) }}
>
    <span class="absolute inset-y-0 right-0 w-[260px] bg-img-placeholder">
        @if ($category['image'])
            <img src="{{ $category['image'] }}" alt="" loading="lazy" class="size-full object-cover">
        @endif
    </span>

    <span class="absolute top-6 left-6 flex w-[360px] flex-col gap-2">
        <span class="text-header-4 text-text-main">{{ $category['name'] }}</span>
        <span class="w-80 overflow-hidden text-ellipsis whitespace-nowrap text-control-m text-text-caption">{{ $category['description'] }}</span>
    </span>

    <span class="absolute bottom-6 left-6 flex items-center gap-1.5 text-control-m text-text-link">
        Перейти
        <span class="flex size-6 items-center justify-center">
            <x-icon.arrow-right-fill class="h-[15px] w-[18px]" />
        </span>
    </span>
</a>
