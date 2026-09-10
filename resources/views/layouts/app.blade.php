<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ config('business.description') }}">
    <title>@yield('title', 'Golden Hair')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/navigation.js') }}" defer></script>
</head>
<body>
    <a class="skip-link" href="#main-content">Aller au contenu</a>
    @include('partials.navigation')

    <main id="main-content" tabindex="-1">
        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>
