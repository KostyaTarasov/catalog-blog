<section class="bg-bg-main pb-main-bottom" aria-label="О компании">
    <div class="h-[616px] w-full overflow-hidden bg-bg-secondary">
        <div class="mx-auto w-full max-w-page">
            <div class="flex w-[1008px] flex-col gap-8 pt-12">
            <div class="flex w-full flex-col gap-6">
                <div class="flex w-full flex-col gap-4">
                    <h1 class="text-header-1">Строим тёплые деревянные дома</h1>
                    <p class="w-[656px] text-lead">
                        Учитывая ключевые сценарии поведения, существующая теория в значительной степени
                        обусловливает важность дальнейших направлений развития.
                    </p>
                </div>

                <ul class="flex gap-6">
                    @foreach ([
                        'Построим дом по вашему дизайн-проекту',
                        'Уникальный дизайн с удобной планировкой',
                        'Подберем мебель и подключим технику',
                    ] as $benefit)
                        <li class="flex w-[204px] flex-col gap-2">
                            <span class="flex size-6 items-center justify-center text-text-main">
                                <x-icon.circle-dashed class="h-[19.5px] w-[18.85px]" />
                            </span>
                            <p class="text-control-m">{{ $benefit }}</p>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="flex items-center gap-6" x-data>
                <x-ui.button variant="dark" size="l" @click="$dispatch('open-lead-modal')">Подробнее</x-ui.button>
            </div>
            </div>
        </div>
    </div>
</section>
