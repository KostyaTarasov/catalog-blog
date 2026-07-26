@props(['title'])

<div class="flex items-start gap-10 pb-6">
    <h2 class="min-w-px flex-1 text-header-2">{{ $title }}</h2>
    @isset($actions)
        <div class="flex items-center gap-2">{{ $actions }}</div>
    @endisset
</div>
