<x-layout
    title="Блог"
    :canonical="$posts->currentPage() > 1 ? route('blog', ['page' => $posts->currentPage()]) : route('blog')"
>
    <x-ui.breadcrumbs :items="[
        ['label' => 'Главная', 'url' => route('home')],
        ['label' => 'Блог'],
    ]" />

    <x-ui.page-header title="Блог" />

    <section class="mx-auto flex w-full max-w-page flex-col gap-6 pt-main-top pb-main-bottom" aria-label="Статьи">
        <div class="grid grid-cols-3 gap-6">
            @foreach ($posts as $post)
                <x-post.card :post="$post" />
            @endforeach
        </div>

        {{ $posts->onEachSide(1)->links('components.ui.pagination') }}
    </section>
</x-layout>
