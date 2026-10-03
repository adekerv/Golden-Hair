<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <meta name="theme-color" content="#18201d">
    <script>try{var theme=localStorage.getItem('theme');if(theme==='light'||theme==='dark'){document.documentElement.dataset.theme=theme}}catch(e){}</script>
    <meta name="description" content="@yield('description', $business['description'])">
    @yield('robots')
    <title>@yield('title', $business['name'])</title>
    <link rel="icon" type="image/webp" href="{{ asset($business['logo']) }}">
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
