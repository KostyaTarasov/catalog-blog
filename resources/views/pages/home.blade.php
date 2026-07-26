<x-layout title="Главная">
    <x-home.hero />

    <section x-data="slider" class="mx-auto w-full max-w-page pt-main-top pb-main-bottom" aria-label="Товары">
        <x-ui.section-header title="Товары">
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
            @foreach ($products as $product)
                <x-product.card :product="$product" class="w-[318px] shrink-0" />
            @endforeach
        </div>
    </section>

    <section class="mx-auto w-full max-w-page pt-main-top pb-main-bottom" aria-label="Каталог">
        <x-ui.section-header title="Каталог" />
        <div class="grid grid-cols-2 gap-6">
            @foreach ($categories as $category)
                <x-category.card :category="$category" />
            @endforeach
        </div>
    </section>

    <section x-data="slider" class="mx-auto w-full max-w-page pt-main-top pb-main-bottom" aria-label="Новости">
        <x-ui.section-header title="Новости">
            <x-slot:actions>
                <x-ui.icon-button @click="scrollStep(-1)" aria-label="Прокрутить назад">
                    <x-icon.arrow-left class="h-[15px] w-[18px]" />
                </x-ui.icon-button>
                <x-ui.icon-button @click="scrollStep(1)" aria-label="Прокрутить вперёд">
                    <x-icon.arrow-right class="h-[15px] w-[18px]" />
                </x-ui.icon-button>
            </x-slot:actions>
        </x-ui.section-header>

        <div class="flex flex-col gap-6">
            <div x-ref="track" class="flex gap-6 overflow-x-auto scrollbar-none">
                @foreach ($posts as $post)
                    <x-post.card :post="$post" class="w-[432px] shrink-0" />
                @endforeach
            </div>

            <x-ui.button variant="soft" size="l" href="{{ route('blog') }}" class="w-full">Все новости</x-ui.button>
        </div>
    </section>
</x-layout>
