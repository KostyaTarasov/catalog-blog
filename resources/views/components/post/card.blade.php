@props(['post'])

<article {{ $attributes->merge(['class' => 'relative h-[408px] overflow-hidden rounded-control-l bg-img-placeholder']) }}>
    @if ($cover = $post->getFirstMediaUrl('cover'))
        <img src="{{ $cover }}" alt="" loading="lazy" class="absolute inset-0 size-full object-cover">
    @endif

    <span class="absolute inset-x-0 bottom-0 h-[220px] bg-gradient-to-b from-brand-1/0 to-brand-1/96 backdrop-blur-lg" aria-hidden="true"></span>

    <a
        href="{{ route('post', $post) }}"
        class="absolute inset-0 flex flex-col justify-end pb-6 pl-6 pr-14 text-text-main-contrast focus-visible:outline-2 focus-visible:-outline-offset-2 focus-visible:outline-bg-main"
    >
        <span class="flex flex-col gap-1">
            <span class="text-header-5">{{ $post->title }}</span>
            <span class="text-control-m">{{ $post->excerpt }}</span>
        </span>
    </a>
</article>
