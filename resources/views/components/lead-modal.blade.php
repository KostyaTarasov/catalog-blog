<div
    x-data="{ open: {{ session()->has('lead-sent') || $errors->any() ? 'true' : 'false' }} }"
    @open-lead-modal.window="open = true"
    @keydown.escape.window="open = false"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-brand-1/40 p-6"
    role="dialog"
    aria-modal="true"
    aria-label="Оставьте заявку"
>
    <div class="relative w-[496px] rounded-control-l bg-bg-main p-8" @click.outside="open = false">
        <button
            type="button"
            @click="open = false"
            aria-label="Закрыть"
            class="absolute top-4 right-4 flex size-11 items-center justify-center rounded-btn-m text-text-main transition-colors hover:bg-bg-button-light focus-visible:outline-2 focus-visible:outline-brand-1"
        >
            <span class="text-lead" aria-hidden="true">&#x2715;</span>
        </button>

        @if (session()->has('lead-sent'))
            <div class="flex flex-col items-center gap-2 py-8 text-center">
                <p class="text-header-4">Заявка отправлена</p>
                <p class="text-control-m">Мы свяжемся с Вами в ближайшее время</p>
            </div>
        @else
            <div class="flex flex-col gap-6">
                <div class="flex flex-col gap-2 pt-6 text-center">
                    <p class="text-header-4">Оставьте заявку</p>
                    <p class="text-control-m">Мы свяжемся с Вами в ближайшее время</p>
                </div>

                <form method="POST" action="{{ route('lead.store') }}" class="flex flex-col gap-4">
                    @csrf

                    <div class="flex flex-col gap-2">
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Ваше имя"
                            required
                            class="h-14 w-full rounded-control-m border border-border-input px-[15px] text-control-m text-text-main placeholder:text-text-caption focus-visible:outline-2 focus-visible:outline-brand-1"
                        >
                        @error('name')<p class="text-control-s text-text-caption">{{ $message }}</p>@enderror

                        <input
                            type="tel"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="Телефон"
                            required
                            class="h-14 w-full rounded-control-m border border-border-input px-[15px] text-control-m text-text-main placeholder:text-text-caption focus-visible:outline-2 focus-visible:outline-brand-1"
                        >
                        @error('phone')<p class="text-control-s text-text-caption">{{ $message }}</p>@enderror

                        <textarea
                            name="message"
                            placeholder="Сообщение"
                            class="h-[132px] w-full resize-none rounded-control-m border border-border-input px-[15px] py-4 text-control-m text-text-main placeholder:text-text-caption focus-visible:outline-2 focus-visible:outline-brand-1"
                        >{{ old('message') }}</textarea>
                    </div>

                    <label class="flex cursor-pointer items-center gap-2">
                        <input type="checkbox" name="consent" required checked class="peer sr-only">
                        <x-icon.checkbox-unchecked class="size-5 shrink-0 text-text-main peer-checked:hidden" />
                        <x-icon.checkbox-checked class="hidden size-5 shrink-0 text-text-main peer-checked:block" />
                        <span class="text-control-s text-text-caption">
                            Даю согласие на <span class="border-b border-dashed border-border-link-main">обработку персональных данных</span>
                        </span>
                    </label>

                    <x-ui.button variant="dark" size="l" type="submit" class="w-full">Отправить</x-ui.button>
                </form>
            </div>
        @endif
    </div>
</div>
