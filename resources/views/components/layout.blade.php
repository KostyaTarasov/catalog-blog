@props([
    'title' => config('app.name'),
    'description' => null,
    'canonical' => null,
    'ogType' => 'website',
    'ogImage' => null,
])
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="cart-count" content="{{ app(\App\Services\Cart::class)->count() }}">
    <title>{{ $title }}</title>
    @if ($description)
        <meta name="description" content="{{ $description }}">
    @endif
    <link rel="canonical" href="{{ $canonical ?? url()->current() }}">
    <meta property="og:title" content="{{ $title }}">
    @if ($description)
        <meta property="og:description" content="{{ $description }}">
    @endif
    <meta property="og:type" content="{{ $ogType }}">
    <meta property="og:url" content="{{ $canonical ?? url()->current() }}">
    @if ($ogImage)
        <meta property="og:image" content="{{ $ogImage }}">
    @endif
    <meta property="og:site_name" content="{{ config('app.name') }}">
    {{ $head ?? '' }}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen">
    <x-app.header />
    <main>{{ $slot }}</main>
    <x-app.footer />
    <x-lead-modal />
    @livewireScripts
</body>
</html>
