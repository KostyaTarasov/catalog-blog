<footer class="bg-bg-main pt-10">
    <div class="bg-bg-secondary">
        <div class="mx-auto w-full max-w-page">
            <div class="flex items-center py-6">
                <a href="{{ route('home') }}" aria-label="На главную" class="flex h-14 w-26 items-center">
                    <x-icon.logo class="h-[39px] w-26" />
                </a>
            </div>

            <div class="border-t border-border-secondary py-6">
                <div class="flex items-end justify-between">
                    <div class="flex items-center gap-6">
                        <p class="text-control-m">© 2025, «Название компании»</p>
                        <x-ui.dashed-link href="#">Политика конфиденциальности</x-ui.dashed-link>
                        <x-ui.dashed-link href="#">Реквизиты</x-ui.dashed-link>
                    </div>
                    <x-ui.dashed-link href="#">Разработано в Вятка IT</x-ui.dashed-link>
                </div>
            </div>
        </div>
    </div>
</footer>
