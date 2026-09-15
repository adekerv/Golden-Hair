@extends('layouts.app')

@section('title', 'Confidentialité — '.$business['name'])
@section('description', 'Données personnelles, navigation et contacts : la confidentialité sur le site Golden Hair.')
@section('robots')
    @if(!$legal['confirmed'])<meta name="robots" content="noindex, follow">@endif
@endsection

@section('content')
<article class="information-page">
    <a href="{{ route('home') }}" class="information-back">← Retour au salon</a>
    <p class="information-eyebrow">{{ $business['name'] }}</p>
    <h1>Confidentialité</h1>
    <p class="information-date">Mise à jour : {{ $legal['updated_on'] }}</p>
    @if(!$legal['confirmed'])
        <p class="information-notice">Cette notice décrit le site actuel. L’identité juridique du responsable, l’hébergement, les durées de conservation et les éventuels transferts restent à compléter et à valider par l’exploitant avant publication définitive.</p>
    @endif

    <section aria-labelledby="controller-title">
        <h2 id="controller-title">Responsable et contact</h2>
        <p>Le responsable du traitement est l’exploitant du salon {{ $business['name'] }}. Identité juridique : <strong>{{ $legal['editor']['legal_name'] ?: 'Non renseignée' }}</strong>.</p>
        <p>Pour toute question ou demande relative à vos données : <a href="mailto:{{ $business['contact']['email'] }}">{{ $business['contact']['email'] }}</a>, ou par courrier au salon, {{ $business['contact']['address'] }}, {{ $business['contact']['postal_city'] }}.</p>
    </section>

    <section aria-labelledby="browsing-title">
        <h2 id="browsing-title">Navigation sur le site</h2>
        <p>Vous pouvez consulter les prestations, tarifs et produits sans créer de compte. Le site ne comporte pas de formulaire de collecte, de newsletter, de commande ou de paiement en ligne.</p>
        <p>Les pages publiques de cette application ne déposent pas de cookie. Les photos et polices sont servies par le site. Aucun outil publicitaire, pixel de suivi ou outil de mesure d’audience n’est intégré au code du site. Les boutons Instagram et WhatsApp sont de simples liens, sans contenu social embarqué.</p>
        <p>Les serveurs peuvent traiter des données techniques telles que l’adresse IP, l’heure de connexion, l’adresse de la page demandée et des informations sur le navigateur pour délivrer les pages, diagnostiquer les erreurs et assurer la sécurité du service. La base envisagée pour ces opérations est l’intérêt légitime à assurer le fonctionnement et la sécurité du site.</p>
        <p>Hébergeur et accès techniques : {{ $legal['host']['name'] ?: 'à préciser lors du choix de l’hébergement' }}. Durée de conservation des journaux : <strong>{{ $legal['privacy']['log_retention'] ?: 'non renseignée' }}</strong>.</p>
    </section>

    <section aria-labelledby="messages-title">
        <h2 id="messages-title">Lorsque vous contactez le salon</h2>
        <p>Un appel, un e-mail ou un message peut communiquer votre nom, vos coordonnées et le contenu de votre demande au salon. Fournissez uniquement les informations utiles à votre échange. Sans moyen de vous recontacter, le salon peut ne pas pouvoir répondre.</p>
        <p>Ces informations servent à répondre à vos questions et à préparer les prestations que vous sollicitez. Selon l’objet de l’échange, la base juridique est l’exécution de mesures précontractuelles à votre demande, ou l’intérêt légitime du salon à traiter les demandes générales et les réclamations.</p>
        <p>Les destinataires sont les personnes habilitées du salon et les prestataires nécessaires à l’acheminement et au stockage des communications. L’adresse de contact utilise Gmail ; WhatsApp et Instagram sont des services de Meta. Les conditions de ces fournisseurs s’appliquent aux échanges effectués par leur intermédiaire.</p>
        <p>Durée de conservation des demandes et échanges : <strong>{{ $legal['privacy']['contact_retention'] ?: 'non renseignée ; à définir par l’exploitant selon les finalités et les obligations applicables' }}</strong>.</p>
    </section>

    <section aria-labelledby="external-title">
        <h2 id="external-title">Services externes et transferts</h2>
        <p>En suivant un lien externe, vous utilisez un autre service, qui applique ses propres règles de confidentialité et peut déposer ses propres cookies. Vous pouvez aussi contacter le salon par téléphone ou courrier postal.</p>
        <p>Les lieux de stockage, éventuels transferts hors de l’Espace économique européen et garanties associées doivent être vérifiés selon les services et contrats effectivement utilisés : <strong>{{ $legal['privacy']['international_transfers'] ?: 'informations non renseignées' }}</strong>.</p>
        <ul>
            <li><a href="https://policies.google.com/privacy?hl=fr">Politique de confidentialité de Google</a></li>
            <li><a href="https://www.whatsapp.com/legal/privacy-policy-eea">Politique de confidentialité de WhatsApp</a></li>
            <li><a href="https://privacycenter.instagram.com/policy/">Politique de confidentialité d’Instagram</a></li>
        </ul>
    </section>

    <section aria-labelledby="rights-title">
        <h2 id="rights-title">Vos droits</h2>
        <p>Selon le traitement et les conditions prévues par le RGPD, vous pouvez demander l’accès, la rectification, l’effacement ou la limitation du traitement de vos données, vous opposer à certains traitements et demander la portabilité des données concernées. Lorsqu’un traitement repose sur le consentement, celui-ci peut être retiré à tout moment pour l’avenir.</p>
        <p>Adressez votre demande au contact indiqué en haut de cette page. Une réponse doit en principe intervenir sous un mois ; ce délai peut être prolongé de deux mois en cas de complexité ou de demandes nombreuses, avec information dans le premier mois. Une vérification d’identité peut être nécessaire en cas de doute raisonnable.</p>
        <p>Vous pouvez également <a href="https://www.cnil.fr/fr/adresser-une-plainte">adresser une réclamation à la CNIL</a>.</p>
    </section>

    <section class="information-sources" aria-labelledby="privacy-sources-title">
        <h2 id="privacy-sources-title">Références officielles</h2>
        <ul>
            <li><a href="https://www.cnil.fr/fr/conformite-rgpd-information-des-personnes-et-transparence">CNIL : information et transparence</a></li>
            <li><a href="https://www.cnil.fr/fr/cookies-et-autres-traceurs/que-dit-la-loi">CNIL : cookies et traceurs</a></li>
            <li><a href="https://www.cnil.fr/fr/repondre-une-demande-de-droit-dacces">CNIL : réponse aux demandes de droits</a></li>
        </ul>
    </section>
</article>
@endsection
