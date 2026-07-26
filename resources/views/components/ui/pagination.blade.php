@php
    $livewire ??= false;
@endphp

@if ($paginator->hasPages())
    <nav aria-label="Пагинация" class="flex items-center gap-1">
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="flex w-14 items-center justify-center rounded-btn-m border border-border-control px-btn-x-m py-btn-y-m text-control-m text-text-main">{{ $element }}</span>
            @else
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page" class="flex w-14 items-center justify-center rounded-btn-m bg-bg-button-light px-btn-x-m py-btn-y-m text-control-m text-text-main">{{ $page }}</span>
                    @else
                        <a
                            href="{{ $url }}"
                            @if ($livewire) wire:click.prevent="setPage({{ $page }}, '{{ $paginator->getPageName() }}')" @endif
                            class="flex w-14 items-center justify-center rounded-btn-m border border-border-control px-btn-x-m py-btn-y-m text-control-m text-text-main transition-colors hover:bg-bg-button-light focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-1"
                        >{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a
                href="{{ $paginator->nextPageUrl() }}"
                @if ($livewire) wire:click.prevent="nextPage('{{ $paginator->getPageName() }}')" @endif
                rel="next"
                aria-label="Следующая страница"
                class="flex items-center justify-center rounded-btn-m border border-border-control p-btn-icon-m text-text-main transition-colors hover:bg-bg-button-light focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-1"
            >
                <span class="flex size-6 items-center justify-center"><x-icon.arrow-right class="h-[15px] w-[18px]" /></span>
            </a>
        @endif
    </nav>
@endif
