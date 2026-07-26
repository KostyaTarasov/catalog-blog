@props(['label'])

<label class="flex w-full cursor-pointer items-center gap-2">
    <input type="radio" {{ $attributes }} class="peer sr-only">
    <x-icon.radio-unchecked class="size-5 shrink-0 text-text-main peer-checked:hidden peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-brand-1" />
    <x-icon.radio-checked class="hidden size-5 shrink-0 text-text-main peer-checked:block peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-brand-1" />
    <span class="min-w-px flex-1 text-control-m text-text-main">{{ $label }}</span>
</label>
