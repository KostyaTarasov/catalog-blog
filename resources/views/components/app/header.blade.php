<header class="bg-bg-main pb-header-bottom">
    <div class="mx-auto flex w-full max-w-page items-center justify-between border-b border-border-main py-4">
        <div class="flex items-center gap-9">
            <a href="{{ route('home') }}" aria-label="На главную" class="flex h-14 w-26 items-center">
                <x-icon.logo class="h-[39px] w-26" />
            </a>

            <nav aria-label="Основное меню" class="flex items-center gap-4">
                @foreach ([
                    'Главная' => route('home'),
                    'Каталог' => route('catalog'),
                    'Блог' => route('blog'),
                    'Контакты' => '#',
                ] as $label => $url)
                    <a
                        href="{{ $url }}"
                        {{ url()->current() === $url ? 'aria-current=page' : '' }}
                        class="text-control-m text-text-main transition-colors hover:text-text-caption focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-1"
                    >{{ $label }}</a>
                @endforeach
            </nav>
        </div>

        <a
            href="#"
            aria-label="Корзина"
            class="relative flex items-center justify-center rounded-btn-m border border-border-control p-btn-icon-m text-text-main transition-colors hover:bg-bg-button-light focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-1"
        >
            <span class="flex size-6 items-center justify-center">
                <x-icon.cart class="h-[19.5px] w-[21.75px]" />
            </span>
            <span
                x-data
                x-cloak
                x-show="$store.cart.count > 0"
                x-text="$store.cart.count"
                class="absolute -top-1.5 -right-1.5 flex h-5 min-w-5 items-center justify-center rounded-full bg-brand-1 px-1 text-upper-s text-text-main-contrast"
            ></span>
        </a>
    </div>
</header>
