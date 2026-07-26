@props(['title'])

<div class="mx-auto flex w-full max-w-page items-start gap-10 pt-3 pb-6">
    <h1 class="min-w-px flex-1 text-header-2">{{ $title }}</h1>
    {{ $slot }}
</div>
