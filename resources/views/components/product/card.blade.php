@props(['product'])

<article {{ $attributes->merge(['class' => 'rounded-control-l border border-border-main bg-bg-main p-4']) }}>
    <div class="flex flex-col gap-4">
        <a
            href="{{ route('product', $product) }}"
            class="relative block h-[215px] overflow-hidden rounded-control-m bg-img-placeholder"
            tabindex="-1"
            aria-hidden="true"
        >
            @if ($cover = $product->getFirstMediaUrl('gallery'))
                <img src="{{ $cover }}" alt="" loading="lazy" class="absolute inset-0 size-full object-cover">
            @endif
            @if ($product->is_new)
                <x-ui.badge class="absolute top-2 left-2">new</x-ui.badge>
            @endif
        </a>

        <div class="flex flex-col gap-2">
            @if ($product->in_stock)
                <p class="text-control-s text-text-positive">В наличии</p>
            @endif
            <div class="flex flex-col">
                <a
                    href="{{ route('product', $product) }}"
                    class="text-control-m text-text-main transition-colors hover:text-text-caption focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-1"
                >{{ $product->name }}</a>
                <p class="flex items-baseline gap-2">
                    <span class="text-header-5">{{ $product->priceFormatted() }}</span>
                    @if ($product->old_price)
                        <s class="text-control-s text-text-caption">{{ $product->oldPriceFormatted() }}</s>
                    @endif
                </p>
            </div>
        </div>

        <div x-data="{ qty: 1 }" class="flex w-full gap-2">
            <div class="flex min-w-px flex-1 items-center justify-between rounded-control-m bg-bg-button-light p-4">
                <button
                    type="button"
                    @click="qty = Math.max(1, qty - 1)"
                    aria-label="Уменьшить количество"
                    class="flex size-6 items-center justify-center text-text-main focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-1"
                >
                    <x-icon.minus class="w-[18px]" />
                </button>
                <span class="w-8 text-center text-control-m" x-text="qty">1</span>
                <button
                    type="button"
                    @click="qty++"
                    aria-label="Увеличить количество"
                    class="flex size-6 items-center justify-center text-text-main focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-1"
                >
                    <x-icon.plus class="size-[18px]" />
                </button>
            </div>

            <x-ui.button variant="dark" size="m" @click="addToCart({{ $product->id }}, qty)">
                <x-slot:icon><x-icon.cart class="h-[19.5px] w-[21.75px]" /></x-slot:icon>
                В корзину
            </x-ui.button>
        </div>
    </div>
</article>
