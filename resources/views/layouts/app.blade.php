@php
    $pageTitle = trim($__env->yieldContent('title')) ?: e($business['name']);
    $pageDescription = trim($__env->yieldContent('description')) ?: e($business['description']);
    $siteUrl = rtrim((string) ($business['site_url'] ?? ''), '/');
    $isIndexable = trim($__env->yieldContent('robots')) === '';
    $canonicalUrl = $siteUrl !== '' && $isIndexable ? $siteUrl.trim($__env->yieldContent('path', '/')) : null;
    $shareImageUrl = $siteUrl !== '' ? $siteUrl.'/'.$business['share_image'] : null;
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <meta name="theme-color" content="#18201d">
    <script>try{var theme=localStorage.getItem('theme');if(theme==='light'||theme==='dark'){document.documentElement.dataset.theme=theme}}catch(e){}</script>
    <meta name="description" content="{!! $pageDescription !!}">
    @yield('robots')
    <title>{!! $pageTitle !!}</title>
    @if($canonicalUrl)
        <link rel="canonical" href="{{ $canonicalUrl }}">
        <meta property="og:url" content="{{ $canonicalUrl }}">
    @endif
    <meta property="og:type" content="website">
    <meta property="og:locale" content="fr_FR">
    <meta property="og:site_name" content="{{ $business['name'] }}">
    <meta property="og:title" content="{!! $pageTitle !!}">
    <meta property="og:description" content="{!! $pageDescription !!}">
    <meta name="twitter:card" content="{{ $shareImageUrl ? 'summary_large_image' : 'summary' }}">
    <meta name="twitter:title" content="{!! $pageTitle !!}">
    <meta name="twitter:description" content="{!! $pageDescription !!}">
    @if($shareImageUrl)
        <meta property="og:image" content="{{ $shareImageUrl }}">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:image:alt" content="{{ $business['hero_photo']['alt'] }}">
        <meta name="twitter:image" content="{{ $shareImageUrl }}">
    @endif
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/branding/favicon-32.png') }}">
    <link rel="icon" type="image/webp" href="{{ asset($business['logo']) }}">
    <link rel="apple-touch-icon" href="{{ asset('images/branding/apple-touch-icon.png') }}">
    @stack('head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-ink antialiased">
    <a href="#main" class="skip-link">Aller au contenu</a>
    @include('partials.navigation')
    <main id="main" tabindex="-1">
        @yield('content')
    </main>
    @include('partials.footer')
</body>
</html>
