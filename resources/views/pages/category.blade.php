<x-layout
    :title="$category->meta_title ?? $category->name"
    :description="$category->meta_description ?? $category->description"
    :canonical="route('category', $category)"
>
    <x-ui.breadcrumbs :items="[
        ['label' => 'Главная', 'url' => route('home')],
        ['label' => 'Каталог', 'url' => route('catalog')],
        ...$category->ancestors->map(fn ($a) => ['label' => $a->name, 'url' => route('category', $a)])->all(),
        ['label' => $category->name],
    ]" />

    <x-ui.page-header :title="$category->name" />

    <livewire:catalog-filter :category="$category" />
</x-layout>
