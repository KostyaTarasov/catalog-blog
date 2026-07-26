<x-layout title="Каталог">
    <x-ui.breadcrumbs :items="[
        ['label' => 'Главная', 'url' => route('home')],
        ['label' => 'Каталог'],
    ]" />

    <x-ui.page-header title="Каталог" />

    <section class="mx-auto w-full max-w-page pt-main-top pb-main-bottom" aria-label="Категории каталога">
        <div class="grid grid-cols-2 gap-6">
            @foreach ($categories as $category)
                <x-category.card :category="$category" />
            @endforeach
        </div>
    </section>
</x-layout>
