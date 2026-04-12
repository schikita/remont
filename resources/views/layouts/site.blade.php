<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $seo['title'] ?? config('app.name') }}</title>
    <meta name="description" content="{{ $seo['description'] ?? '' }}">
    <link rel="canonical" href="{{ $seo['canonical'] ?? url('/') }}">
    <meta name="robots" content="{{ $seo['robots'] ?? 'index,follow' }}">

    <meta property="og:title" content="{{ $seo['og']['title'] ?? '' }}">
    <meta property="og:description" content="{{ $seo['og']['description'] ?? '' }}">
    <meta property="og:type" content="{{ $seo['og']['type'] ?? 'website' }}">
    <meta property="og:url" content="{{ $seo['og']['url'] ?? url('/') }}">
    @if(!empty($seo['og']['image']))
        <meta property="og:image" content="{{ $seo['og']['image'] }}">
    @endif
    @if(!empty($seo['og']['site_name']))
        <meta property="og:site_name" content="{{ $seo['og']['site_name'] }}">
    @endif

    <meta name="twitter:card" content="{{ $seo['twitter']['card'] ?? 'summary_large_image' }}">
    <meta name="twitter:title" content="{{ $seo['twitter']['title'] ?? '' }}">
    <meta name="twitter:description" content="{{ $seo['twitter']['description'] ?? '' }}">
    @if(!empty($seo['twitter']['image']))
        <meta name="twitter:image" content="{{ $seo['twitter']['image'] }}">
    @endif

    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700|outfit:500,600,700&display=swap" rel="stylesheet">

    @php($fav = \App\Support\MediaUrl::public($site->favicon_path ?? null))
    @if($fav)
        <link rel="icon" href="{{ $fav }}">
    @endif

    {!! $scripts->head() !!}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('meta')
    <script type="application/ld+json">{!! $jsonLd ?? '{}' !!}</script>
</head>
<body class="min-w-[320px] font-sans">
{!! $scripts->bodyStart() !!}

@yield('content')

<button
    type="button"
    id="scroll-top-button"
    hidden
    class="fixed bottom-5 right-5 z-[60] inline-flex items-center gap-2 rounded-full border border-slate-200/90 bg-white/95 px-3.5 py-2.5 text-xs font-semibold uppercase tracking-wide text-slate-800 shadow-lg shadow-slate-900/10 ring-1 ring-slate-200/60 backdrop-blur-sm transition-opacity duration-200 hover:border-brand-200 hover:text-brand-800 hover:shadow-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600 sm:px-4 sm:text-sm"
    aria-label="Наверх"
    aria-hidden="true"
>
    <svg class="h-4 w-4 shrink-0 text-brand-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l5 5a1 1 0 01-1.414 1.414L11 7.414V17a1 1 0 11-2 0V7.414L5.707 9.707a1 1 0 01-1.414-1.414l5-5A1 1 0 0110 3z" clip-rule="evenodd" />
    </svg>
    Наверх
</button>

@stack('scripts')

{!! $scripts->bodyEnd() !!}
</body>
</html>
