<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description', $business['description'])">
    @yield('robots')
    <title>@yield('title', $business['name'])</title>
    <link rel="icon" type="image/webp" href="{{ asset($business['logo']) }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-charcoal antialiased">
    <a href="#main" class="skip-link">Aller au contenu</a>
    @include('partials.navigation')
    <main id="main" tabindex="-1">
        @yield('content')
    </main>
    @include('partials.footer')
</body>
</html>
