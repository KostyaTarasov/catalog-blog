<div class="mx-auto flex w-full max-w-page items-start gap-6 pt-main-top pb-main-bottom">
    <aside class="flex w-[318px] shrink-0 flex-col pr-8" aria-label="Фильтр товаров">
        <section class="flex flex-col gap-3 pb-6" x-data="{ open: true }">
            <button type="button" @click="open = !open" :aria-expanded="open" class="flex items-center gap-1 text-left">
                <span class="text-header-5 text-text-main">Цена, ₽</span>
                <span class="flex size-6 items-center justify-center text-text-main">
                    <x-icon.caret-up-fill x-show="open" class="h-[9px] w-[16.5px]" />
                    <x-icon.caret-down-fill x-show="!open" x-cloak class="h-[9px] w-[16.5px]" />
                </span>
            </button>

            <div x-show="open" class="flex flex-col gap-2">
                <div class="flex items-center gap-1">
                    <input
                        type="number"
                        wire:model.live.debounce.500ms="priceFrom"
                        placeholder="{{ $priceMin }}"
                        aria-label="Цена от"
                        class="h-14 min-w-px flex-1 rounded-control-m border border-border-input px-[15px] text-control-m text-text-main placeholder:text-text-caption focus-visible:outline-2 focus-visible:outline-brand-1"
                    >
                    <span class="w-4 text-center text-control-m">−</span>
                    <input
                        type="number"
                        wire:model.live.debounce.500ms="priceTo"
                        placeholder="{{ $priceMax }}"
                        aria-label="Цена до"
                        class="h-14 min-w-px flex-1 rounded-control-m border border-border-input px-[15px] text-control-m text-text-main placeholder:text-text-caption focus-visible:outline-2 focus-visible:outline-brand-1"
                    >
                </div>

                <div
                    x-data="{
                        min: {{ $priceMin }},
                        max: {{ $priceMax }},
                        from: {{ $priceFrom !== '' ? (int) $priceFrom : $priceMin }},
                        to: {{ $priceTo !== '' ? (int) $priceTo : $priceMax }},
                        commit() {
                            $wire.priceFrom = String(this.from);
                            $wire.priceTo = String(this.to);
                        },
                    }"
                    class="relative h-5"
                >
                    <span class="absolute inset-x-0 top-1/2 h-0.5 -translate-y-1/2 bg-border-secondary" aria-hidden="true"></span>
                    <span
                        class="absolute top-1/2 h-0.5 -translate-y-1/2 bg-bg-button"
                        :style="`left:${(from - min) / (max - min || 1) * 100}%; right:${100 - (to - min) / (max - min || 1) * 100}%`"
                        aria-hidden="true"
                    ></span>
                    <input type="range" class="price-range" :min="min" :max="max" x-model.number="from" @change="if (from > to) from = to; commit()" aria-label="Цена от, ползунок">
                    <input type="range" class="price-range" :min="min" :max="max" x-model.number="to" @change="if (to < from) to = from; commit()" aria-label="Цена до, ползунок">
                </div>
            </div>
        </section>

        @foreach ($filters as $filter)
            <section class="flex flex-col gap-3 pb-6" x-data="{ open: true, all: false }">
                <button type="button" @click="open = !open" :aria-expanded="open" class="flex items-center gap-1 text-left">
                    <span class="text-header-5 text-text-main">{{ $filter->name }}</span>
                    <span class="flex size-6 items-center justify-center text-text-main">
                        <x-icon.caret-up-fill x-show="open" class="h-[9px] w-[16.5px]" />
                        <x-icon.caret-down-fill x-show="!open" x-cloak class="h-[9px] w-[16.5px]" />
                    </span>
                </button>

                <div x-show="open" class="flex flex-col gap-2">
                    @foreach ($filter->values as $value)
                        <div @if ($loop->index >= 8) x-show="all" x-cloak @endif>
                            @if ($filter->type === \App\Models\Attribute::TYPE_RADIO)
                                <x-ui.radio
                                    :label="$value->value"
                                    name="radio-{{ $filter->slug }}"
                                    value="{{ $value->slug }}"
                                    wire:model.live="radio"
                                />
                            @else
                                <x-ui.checkbox
                                    :label="$value->value"
                                    value="{{ $value->slug }}"
                                    wire:model.live="values"
                                />
                            @endif
                        </div>
                    @endforeach

                    @if ($filter->values->count() > 8)
                        <button
                            type="button"
                            @click="all = !all"
                            class="self-start border-b border-dashed border-border-link text-control-m text-text-link transition-colors hover:border-solid focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-1"
                            x-text="all ? 'Скрыть' : 'Показать все'"
                        >Показать все</button>
                    @endif
                </div>
            </section>
        @endforeach
    </aside>

    <div class="flex min-w-px flex-1 flex-col">
        <div class="flex items-center justify-between pb-6">
            <div class="flex items-center gap-2" x-data="{ open: false }" @click.outside="open = false">
                <span class="text-control-m text-text-caption">Сортировка</span>
                <div class="relative">
                    <button type="button" @click="open = !open" :aria-expanded="open" class="flex items-center gap-1.5 text-control-m text-text-main">
                        {{ \App\Livewire\CatalogFilter::SORT_OPTIONS[$sort] ?? 'По умолчанию' }}
                        <span class="flex size-6 items-center justify-center"><x-icon.caret-down class="h-[9px] w-[16.5px]" /></span>
                    </button>
                    <div x-show="open" x-cloak @click="open = false" class="absolute top-full left-0 z-10 mt-2 flex min-w-48 flex-col rounded-control-m border border-border-control bg-bg-main py-2">
                        @foreach (\App\Livewire\CatalogFilter::SORT_OPTIONS as $key => $label)
                            <button type="button" wire:click="$set('sort', '{{ $key }}')" class="px-4 py-2 text-left text-control-m transition-colors hover:bg-bg-button-light">{{ $label }}</button>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2" x-data="{ open: false }" @click.outside="open = false">
                <span class="text-control-m text-text-caption">Выводить товаров</span>
                <div class="relative">
                    <button type="button" @click="open = !open" :aria-expanded="open" class="flex items-center gap-1.5 text-control-m text-text-main">
                        {{ $perPage }}
                        <span class="flex size-6 items-center justify-center"><x-icon.caret-down class="h-[9px] w-[16.5px]" /></span>
                    </button>
                    <div x-show="open" x-cloak @click="open = false" class="absolute top-full right-0 z-10 mt-2 flex min-w-24 flex-col rounded-control-m border border-border-control bg-bg-main py-2">
                        @foreach (\App\Livewire\CatalogFilter::PER_PAGE_OPTIONS as $option)
                            <button type="button" wire:click="$set('perPage', {{ $option }})" class="px-4 py-2 text-left text-control-m transition-colors hover:bg-bg-button-light">{{ $option }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-6">
            <div class="grid grid-cols-3 gap-6" wire:loading.class="opacity-50">
                @forelse ($products as $product)
                    <x-product.card :product="$product" wire:key="product-{{ $product->id }}" />
                @empty
                    <p class="col-span-3 text-control-m text-text-caption">По заданным условиям товаров не найдено.</p>
                @endforelse
            </div>

            {{ $products->onEachSide(1)->links('components.ui.pagination', ['livewire' => true]) }}
        </div>
    </div>
</div>
