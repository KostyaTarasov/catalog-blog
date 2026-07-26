<x-layout
    :title="$post->meta_title ?? $post->title"
    :description="$post->meta_description ?? $post->excerpt"
    :canonical="route('post', $post)"
    og-type="article"
    :og-image="$post->getFirstMediaUrl('cover') ?: null"
>
    <x-slot:head>
        <script type="application/ld+json">
        {!! json_encode(array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $post->title,
            'description' => $post->excerpt,
            'image' => $post->getFirstMediaUrl('cover') ?: null,
            'datePublished' => $post->published_at?->toIso8601String(),
            'dateModified' => $post->updated_at?->toIso8601String(),
            'mainEntityOfPage' => route('post', $post),
            'author' => ['@type' => 'Organization', 'name' => config('app.name')],
        ]), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
        </script>
    </x-slot:head>
    <x-ui.breadcrumbs :items="[
        ['label' => 'Главная', 'url' => route('home')],
        ['label' => 'Блог', 'url' => route('blog')],
        ['label' => $post->title],
    ]" />

    <x-ui.page-header :title="$post->title" />

    <article class="mx-auto flex w-full max-w-page flex-col gap-8 pt-main-top pb-main-bottom">
        @if ($post->lead)
            <p class="max-w-[832px] text-lead">{{ $post->lead }}</p>
        @endif

        <figure class="flex flex-col gap-2">
            <div class="h-[612px] w-[1088px] overflow-hidden rounded-control-l bg-img-placeholder">
                @if ($cover = $post->getFirstMediaUrl('cover'))
                    <img src="{{ $cover }}" alt="{{ $post->title }}" class="size-full object-cover">
                @endif
            </div>
            <figcaption class="text-control-s text-text-caption">Подпись к фотографии</figcaption>
        </figure>

        <div class="article-content max-w-[832px]">
            {!! \Illuminate\Support\Str::of($post->content ?? '')->markdown() !!}
        </div>

        @if ($post->tags->isNotEmpty())
            <ul class="flex items-center gap-2" aria-label="Теги">
                @foreach ($post->tags as $tag)
                    <li><span class="inline-flex rounded-btn-m bg-bg-button-light px-3 py-1 text-control-s text-text-main">{{ $tag->name }}</span></li>
                @endforeach
            </ul>
        @endif
    </article>
</x-layout>
