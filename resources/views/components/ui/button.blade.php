@props(['variant' => 'dark', 'size' => 'm', 'icon' => null])

@php
    $classes = 'inline-flex items-center justify-center gap-2 text-control-m transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-1 disabled:pointer-events-none disabled:opacity-50 ';

    $classes .= match ($variant) {
        'dark' => 'bg-bg-button text-text-main-contrast hover:opacity-90 ',
        'light' => 'border border-border-control bg-bg-main text-text-main hover:bg-bg-button-light ',
        'soft' => 'bg-bg-button-light text-text-main hover:bg-border-control ',
    };

    $classes .= match ($size) {
        'm' => 'rounded-btn-m py-btn-y-m '.($icon ? 'pl-btn-icon-m pr-btn-x-m' : 'px-btn-x-m'),
        'l' => 'rounded-btn-l py-btn-y-l px-btn-x-l',
    };

    $tag = $attributes->has('href') ? 'a' : 'button';
@endphp

<{{ $tag }} {{ $attributes->merge(['class' => $classes] + ($tag === 'button' ? ['type' => 'button'] : [])) }}>
    @if ($icon)
        <span class="flex size-6 items-center justify-center">{{ $icon }}</span>
    @endif
    {{ $slot }}
</{{ $tag }}>
