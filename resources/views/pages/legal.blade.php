@extends('layouts.app')

@section('title', 'Mentions légales — '.$business['name'])
@section('description', 'Éditeur, hébergement et informations légales du site Golden Hair au Lamentin.')
@section('robots')
    @if(!$legal['confirmed'])<meta name="robots" content="noindex, follow">@endif
@endsection

@section('content')
<article class="information-page">
    <a href="{{ route('home') }}" class="information-back">← Retour au salon</a>
    <p class="information-eyebrow">{{ $business['name'] }}</p>
    <h1>Mentions légales</h1>
    <p class="information-date">Mise à jour : {{ $legal['updated_on'] }}</p>
    @if(!$legal['confirmed'])
        <p class="information-notice">Informations en cours de finalisation. Les champs « Non renseigné » doivent être complétés par l’exploitant avant publication définitive de ces mentions.</p>
    @endif

    <section aria-labelledby="editor-title">
        <h2 id="editor-title">Éditeur du site</h2>
        <p><strong>{{ $business['name'] }}</strong> — {{ $business['activity'] }}</p>
        <dl class="information-facts">
            @foreach([
                'legal_name' => 'Nom légal de l’exploitant ou dénomination sociale',
                'legal_form' => 'Forme juridique (avec la mention EI pour un entrepreneur individuel)',
                'registered_address' => 'Adresse de l’entreprise ou du siège social',
                'siren_siret' => 'SIREN / SIRET',
                'registration' => 'Immatriculation (RNE / RCS, selon la situation)',
                'capital' => 'Capital social, si applicable',
                'vat_number' => 'Numéro de TVA, si applicable',
                'publication_director' => 'Directeur de la publication',
            ] as $key => $label)
                <div><dt>{{ $label }}</dt><dd>{{ $legal['editor'][$key] ?: 'Non renseigné' }}</dd></div>
            @endforeach
        </dl>
        <p>Adresse du salon : {{ $business['contact']['address'] }}, {{ $business['contact']['postal_city'] }}.</p>
        <p>Téléphone : <a href="tel:{{ preg_replace('/[^0-9+]/', '', $business['contact']['phone']) }}">{{ $business['contact']['phone'] }}</a><br>
        E-mail : <a href="mailto:{{ $business['contact']['email'] }}">{{ $business['contact']['email'] }}</a></p>
    </section>

    <section aria-labelledby="host-title">
        <h2 id="host-title">Hébergement</h2>
        <dl class="information-facts">
            <div><dt>Hébergeur</dt><dd>{{ $legal['host']['name'] ?: 'Non renseigné' }}</dd></div>
            <div><dt>Adresse</dt><dd>{{ $legal['host']['address'] ?: 'Non renseigné' }}</dd></div>
            <div><dt>Téléphone</dt><dd>{{ $legal['host']['phone'] ?: 'Non renseigné' }}</dd></div>
            <div><dt>Autres prestataires de stockage liés à l’édition du site, le cas échéant</dt><dd>{{ $legal['other_storage_providers'] ?: 'Non renseigné' }}</dd></div>
        </dl>
    </section>

    <section aria-labelledby="mediation-title">
        <h2 id="mediation-title">Réclamations et médiation de la consommation</h2>
        <p>Pour toute réclamation concernant une prestation ou un produit, contactez d’abord le salon par écrit à l’adresse postale ou électronique indiquée ci-dessus.</p>
        <p>Si le litige demeure non résolu après cette démarche préalable, le consommateur peut recourir gratuitement à un médiateur de la consommation, dans les conditions prévues par le Code de la consommation.</p>
        <dl class="information-facts">
            <div><dt>Médiateur dont relève le salon</dt><dd>{{ $legal['mediator']['name'] ?: 'Non renseigné' }}</dd></div>
            <div><dt>Adresse postale</dt><dd>{{ $legal['mediator']['address'] ?: 'Non renseigné' }}</dd></div>
            <div><dt>Site de saisine</dt><dd>@if($legal['mediator']['url'])<a href="{{ $legal['mediator']['url'] }}">{{ $legal['mediator']['url'] }}</a>@else Non renseigné @endif</dd></div>
        </dl>
    </section>

    <section aria-labelledby="site-title">
        <h2 id="site-title">Présentation du site</h2>
        <p>Ce site présente le salon, ses prestations et sa sélection de produits. Les achats se font au salon. Il ne propose ni compte client, ni commande, ni paiement en ligne. Les disponibilités des produits sont mises à jour manuellement.</p>
        <p>Les photographies, visuels, textes et marques restent soumis aux droits de leurs titulaires. Toute réutilisation doit respecter ces droits et les exceptions prévues par la loi.</p>
        <p>Pour les données personnelles et les liens vers les services externes, consultez notre <a href="{{ route('privacy') }}">politique de confidentialité</a>.</p>
    </section>

    <section class="information-sources" aria-labelledby="legal-sources-title">
        <h2 id="legal-sources-title">Références officielles</h2>
        <ul>
            <li><a href="https://www.legifrance.gouv.fr/loda/article_lc/LEGIARTI000049568614/">LCEN, article 1-1 : identification de l’éditeur et de l’hébergeur</a></li>
            <li><a href="https://entreprendre.service-public.gouv.fr/vosdroits/F37351">Service Public : mentions d’une société</a> et <a href="https://entreprendre.service-public.gouv.fr/vosdroits/F31228">d’un entrepreneur individuel</a></li>
            <li><a href="https://www.economie.gouv.fr/mediation-conso/vous-etes-un-professionnel/vos-principales-obligations-0">Ministère de l’Économie : médiation de la consommation</a></li>
        </ul>
    </section>
</article>
@endsection
