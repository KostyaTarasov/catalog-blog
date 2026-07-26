@php
    $specs = $product->attributeValues->filter(fn ($v) => $v->attribute->type === \App\Models\Attribute::TYPE_SPEC);
    $select = $product->attributeValues->first(fn ($v) => $v->attribute->type === \App\Models\Attribute::TYPE_SELECT);
    $gallery = $product->getMedia('gallery');
    $documents = $product->getMedia('documents');
@endphp

<x-layout
    :title="$product->meta_title ?? $product->name"
    :description="$product->meta_description ?? $product->short_description"
    :canonical="route('product', $product)"
    og-type="product"
    :og-image="$gallery->first()?->getUrl()"
>
    <x-slot:head>
        <script type="application/ld+json">
        {!! json_encode(array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $product->name,
            'sku' => $product->sku,
            'description' => $product->short_description,
            'image' => $gallery->first()?->getUrl(),
            'offers' => [
                '@type' => 'Offer',
                'url' => route('product', $product),
                'price' => $product->price,
                'priceCurrency' => 'RUB',
                'availability' => $product->in_stock ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
            ],
        ]), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
        </script>
    </x-slot:head>
    <x-ui.breadcrumbs :items="[
        ['label' => 'Главная', 'url' => route('home')],
        ['label' => 'Каталог', 'url' => route('catalog')],
        ...$product->category->ancestors->map(fn ($a) => ['label' => $a->name, 'url' => route('category', $a)])->all(),
        ['label' => $product->category->name, 'url' => route('category', $product->category)],
        ['label' => $product->name],
    ]" />

    <div class="mx-auto flex w-full max-w-page items-start gap-6 pt-main-top">
        <div
            x-data="{ current: 0, count: {{ max($gallery->count(), 1) }} }"
            class="relative h-[576px] w-[768px] shrink-0 overflow-hidden rounded-control-l bg-bg-secondary"
        >
            @forelse ($gallery as $i => $media)
                <img
                    src="{{ $media->getUrl() }}"
                    alt="{{ $product->name }}, фото {{ $i + 1 }}"
                    class="absolute inset-0 size-full object-cover"
                    x-show="current === {{ $i }}"
                    @if ($i > 0) x-cloak loading="lazy" @endif
                >
            @empty
            @endforelse

            @if ($product->is_new)
                <x-ui.badge class="absolute top-4 left-4">new</x-ui.badge>
            @endif

            <button
                type="button"
                @click="current = (current - 1 + count) % count"
                aria-label="Предыдущее фото"
                class="absolute top-1/2 left-6 flex size-11 -translate-y-1/2 items-center justify-center rounded-full bg-bg-main text-text-main transition-colors hover:bg-bg-button-light focus-visible:outline-2 focus-visible:outline-brand-1"
            >
                <x-icon.arrow-left class="h-[15px] w-[18px]" />
            </button>
            <button
                type="button"
                @click="current = (current + 1) % count"
                aria-label="Следующее фото"
                class="absolute top-1/2 right-6 flex size-11 -translate-y-1/2 items-center justify-center rounded-full bg-bg-main text-text-main transition-colors hover:bg-bg-button-light focus-visible:outline-2 focus-visible:outline-brand-1"
            >
                <x-icon.arrow-right class="h-[15px] w-[18px]" />
            </button>

            <div class="absolute bottom-4 left-1/2 flex -translate-x-1/2 items-center gap-1.5">
                <template x-for="i in count">
                    <button
                        type="button"
                        @click="current = i - 1"
                        :aria-label="`Фото ${i}`"
                        class="size-1.5 rounded-full transition-colors"
                        :class="current === i - 1 ? 'bg-bg-button' : 'bg-border-control'"
                    ></button>
                </template>
            </div>
        </div>

        <div class="min-w-px flex-1 rounded-control-l bg-bg-main p-8 shadow-card">
            <div class="flex flex-col gap-4">
                <div class="flex flex-col gap-2">
                    <p class="flex items-center gap-3 text-control-s">
                        <span class="text-text-caption">Арт: {{ $product->sku }}</span>
                        @if ($product->in_stock)
                            <span class="text-text-positive">&bull; В наличии</span>
                        @endif
                    </p>
                    <h1 class="text-header-3">{{ $product->name }}</h1>
                    @if ($product->short_description)
                        <p class="text-control-m text-text-caption">{{ $product->short_description }}</p>
                    @endif
                </div>

                @if ($specs->isNotEmpty())
                    <dl>
                        @foreach ($specs as $spec)
                            <div class="flex items-center justify-between border-b border-border-main py-1.5">
                                <dt class="text-control-m text-text-caption">{{ $spec->attribute->name }}</dt>
                                <dd class="text-control-m text-text-main">{{ $spec->value }}</dd>
                            </div>
                        @endforeach
                    </dl>
                @endif

                @if ($select)
                    <div x-data="{ open: false, value: @js($select->value) }" @click.outside="open = false" class="relative">
                        <button
                            type="button"
                            @click="open = !open"
                            :aria-expanded="open"
                            class="flex h-16 w-full items-center justify-between rounded-btn-l border border-border-input px-4 text-left focus-visible:outline-2 focus-visible:outline-brand-1"
                        >
                            <span class="flex flex-col">
                                <span class="text-upper-s text-text-caption">{{ $select->attribute->name }}</span>
                                <span class="text-control-m text-text-main" x-text="value"></span>
                            </span>
                            <span class="flex size-6 items-center justify-center text-text-main"><x-icon.caret-down class="h-[9px] w-[16.5px]" /></span>
                        </button>
                        <div x-show="open" x-cloak class="absolute inset-x-0 top-full z-10 mt-2 flex flex-col rounded-control-m border border-border-control bg-bg-main py-2">
                            @foreach ($select->attribute->values as $option)
                                <button type="button" @click="value = @js($option->value); open = false" class="px-4 py-2 text-left text-control-m transition-colors hover:bg-bg-button-light">{{ $option->value }}</button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <p class="flex items-baseline gap-3">
                    <span class="text-header-2">{{ $product->priceFormatted() }}</span>
                    @if ($product->old_price)
                        <s class="text-control-s text-text-caption">{{ $product->oldPriceFormatted() }}</s>
                    @endif
                </p>

                <div class="flex flex-col gap-2">
                    <div x-data="{ qty: 1 }" class="flex gap-2">
                        <div class="flex w-36 shrink-0 items-center justify-between rounded-control-m bg-bg-button-light p-4">
                            <button type="button" @click="qty = Math.max(1, qty - 1)" aria-label="Уменьшить количество" class="flex size-6 items-center justify-center text-text-main"><x-icon.minus class="w-[18px]" /></button>
                            <span class="w-8 text-center text-control-m" x-text="qty">1</span>
                            <button type="button" @click="qty++" aria-label="Увеличить количество" class="flex size-6 items-center justify-center text-text-main"><x-icon.plus class="size-[18px]" /></button>
                        </div>
                        <x-ui.button variant="dark" size="m" class="min-w-px flex-1" @click="addToCart({{ $product->id }}, qty)">
                            <x-slot:icon><x-icon.cart class="h-[19.5px] w-[21.75px]" /></x-slot:icon>
                            В корзину
                        </x-ui.button>
                    </div>
                    <x-ui.button variant="light" size="m" class="w-full" @click="$dispatch('open-lead-modal')">Купить в 1 клик</x-ui.button>
                </div>
            </div>
        </div>
    </div>

    <div class="mx-auto w-full max-w-page pt-main-bottom pb-main-bottom" x-data="{ tab: 'description' }">
        <div role="tablist" aria-label="Информация о товаре" class="flex items-center gap-6">
            @foreach ([
                'description' => 'Описание',
                'specs' => 'Характеристики',
                'documents' => 'Документы',
                'delivery' => 'Оплата и доставка',
            ] as $key => $label)
                <button
                    type="button"
                    role="tab"
                    :aria-selected="tab === '{{ $key }}'"
                    @click="tab = '{{ $key }}'"
                    class="border-b-2 pb-2 text-upper-s uppercase transition-colors focus-visible:outline-2 focus-visible:outline-brand-1"
                    :class="tab === '{{ $key }}' ? 'border-brand-1 text-text-main' : 'border-transparent text-text-caption hover:text-text-main'"
                >{{ $label }}</button>
            @endforeach
        </div>

        <div class="pt-6">
            <div x-show="tab === 'description'" class="flex max-w-[768px] flex-col gap-4 text-control-m">
                {!! \Illuminate\Support\Str::of($product->description ?? '')->markdown() !!}
            </div>

            <div x-show="tab === 'specs'" x-cloak>
                <dl class="max-w-[768px]">
                    @foreach ($specs as $spec)
                        <div class="flex items-center justify-between border-b border-border-main py-1.5">
                            <dt class="text-control-m text-text-caption">{{ $spec->attribute->name }}</dt>
                            <dd class="text-control-m text-text-main">{{ $spec->value }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>

            <div x-show="tab === 'documents'" x-cloak class="flex flex-col gap-2">
                @forelse ($documents as $document)
                    <a href="{{ $document->getUrl() }}" download class="self-start border-b border-dashed border-border-link text-control-m text-text-link">{{ $document->name }}</a>
                @empty
                    <p class="text-control-m text-text-caption">Документы не добавлены.</p>
                @endforelse
            </div>

            <div x-show="tab === 'delivery'" x-cloak class="flex max-w-[768px] flex-col gap-4 text-control-m">
                <p>Оплата при получении или онлайн. Доставка по городу и области, сроки рассчитываются при оформлении заказа.</p>
            </div>
        </div>
    </div>

    @if ($related->isNotEmpty())
        <section x-data="slider" class="mx-auto w-full max-w-page pt-main-top pb-main-bottom" aria-label="Похожие товары">
            <x-ui.section-header title="Похожие товары">
                <x-slot:actions>
                    <x-ui.icon-button @click="scrollStep(-1)" aria-label="Прокрутить назад">
                        <x-icon.arrow-left class="h-[15px] w-[18px]" />
                    </x-ui.icon-button>
                    <x-ui.icon-button @click="scrollStep(1)" aria-label="Прокрутить вперёд">
                        <x-icon.arrow-right class="h-[15px] w-[18px]" />
                    </x-ui.icon-button>
                </x-slot:actions>
            </x-ui.section-header>

            <div x-ref="track" class="flex gap-6 overflow-x-auto scrollbar-none">
                @foreach ($related as $item)
                    <x-product.card :product="$item" class="w-[318px] shrink-0" />
                @endforeach
            </div>
        </section>
    @endif
</x-layout>
