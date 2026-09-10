@extends('layouts.app')

@section('title', $business['name'].' — Accueil')

@section('content')
    <section class="hero" aria-labelledby="hero-title">
        <div class="container hero-grid">
            <div class="hero-copy">
                <p class="eyebrow">L’univers Golden Hair</p>
                <h1 id="hero-title">Vos cheveux.<br>Votre style.<br><em>Votre éclat.</em></h1>
                <p class="hero-description">{{ $business['intro'] }}</p>
                <a class="button" href="#univers">Découvrir notre univers <span aria-hidden="true">↗</span></a>
            </div>
            @if($heroPhoto)
                <img class="hero-photo" src="{{ asset($heroPhoto['src']) }}" alt="{{ $heroPhoto['alt'] }}" width="900" height="1100" fetchpriority="high">
            @else
            <div class="brand-panel" aria-hidden="true">
                <span class="panel-caption">GOLDEN HAIR</span>
                <span class="monogram">G<span>H</span></span>
                <span class="panel-bottom">La beauté, à votre image.</span>
            </div>
            @endif
        </div>
    </section>

    <section class="section container introduction" id="univers" aria-labelledby="univers-title">
        <p class="eyebrow">01 / Notre univers</p>
        <div>
            <h2 id="univers-title">Laissez votre personnalité s’exprimer.</h2>
            <p>{{ $business['about'] }}</p>
        </div>
    </section>

    <section class="approach" id="approche" aria-labelledby="approche-title">
        <div class="container section">
            <p class="eyebrow">02 / Notre approche</p>
            <h2 id="approche-title">La beauté dans chaque détail.</h2>
            <div class="principles">
                <article><span class="item-number">01</span><h3>La personnalité</h3><p>Un style qui raconte qui vous êtes et accompagne vos envies.</p></article>
                <article><span class="item-number">02</span><h3>La simplicité</h3><p>Une vision de la beauté qui trouve sa place dans votre quotidien.</p></article>
                <article><span class="item-number">03</span><h3>La confiance</h3><p>Le plaisir d’exprimer votre style et de vous sentir vous-même.</p></article>
            </div>
        </div>
    </section>
    @include('sections.gallery')
    @include('sections.business-info')
@endsection
