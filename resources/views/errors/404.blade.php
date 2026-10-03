@php($business = $business ?? config('business'))
@extends('layouts.app')

@section('title', 'Page introuvable — '.$business['name'])
@section('robots')
    <meta name="robots" content="noindex, follow">
@endsection

@section('content')
<article class="information-page">
    <p class="information-eyebrow">Erreur 404</p>
    <h1>Cette page est introuvable.</h1>
    <p>Retrouvez nos coiffures, nos produits et les coordonnées du salon depuis l’accueil.</p>
    <a href="{{ route('home') }}" class="information-back">← Retour au salon</a>
</article>
@endsection
