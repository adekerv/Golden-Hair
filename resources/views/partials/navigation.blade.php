<header class="site-header">
    <nav class="container navigation" aria-label="Navigation principale">
        <a class="brand" href="{{ route('home') }}" aria-label="Golden Hair — Accueil">
            <span class="brand-mark" aria-hidden="true">GH</span>
            <span>GOLDEN <span class="brand-light">HAIR</span></span>
        </a>
        <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="navigation-links" hidden>
            Menu <span aria-hidden="true">☰</span>
        </button>
        <ul class="navigation-links" id="navigation-links">
            <li><a href="{{ route('home') }}" @if(request()->routeIs('home')) aria-current="page" @endif>Accueil</a></li>
            <li><a href="{{ route('home') }}#univers">Notre univers</a></li>
            <li><a href="{{ route('home') }}#approche">Notre approche</a></li>
            @if(count($photos) > 0)
                <li><a href="{{ route('home') }}#photos">Photos</a></li>
            @endif
            @if($hasBusinessInfo)
                <li><a href="{{ route('home') }}#informations">Informations</a></li>
            @endif
        </ul>
    </nav>
</header>
