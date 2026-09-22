# Golden Hair — Rapport de réalisation et de revue technique

**Annexe technique pour le dossier professionnel DWWM**

| Repère | Information |
| --- | --- |
| Projet | Golden Hair, site vitrine d’un salon de coiffure et barber au Lamentin, Martinique |
| Objet | Présenter les travaux réalisés, les choix techniques, les corrections, les vérifications et les éléments restant à compléter |
| Période des commits examinés | Du 9 au 15 septembre 2026 |
| Date de la revue | 22 septembre 2026 |
| Révision de référence | `35dca5e085ecb2cae18fd9c1c8afad4f1e034e05` |
| Historique examiné | 15 commits, dont 2 commits de fusion |
| Inventaire | 120 fichiers suivis à la révision de référence ; 131 chemins distincts dans l’historique |
| Traçabilité | 215 opérations d’ajout, de modification ou de suppression de fichier dans les commits hors fusion |
| Format | Markdown UTF-8, avec sommaire, tableaux, exemples techniques et annexes |

## Sommaire

1. [Présentation du projet et du besoin](#section-1)
2. [Méthode de travail et périmètre de la revue](#section-2)
3. [Architecture et environnement technique](#section-3)
4. [Historique des réalisations](#section-4)
5. [Fonctionnement détaillé de l’application](#section-5)
6. [Problèmes identifiés et corrections apportées](#section-6)
7. [Vérifications et résultats](#section-7)
8. [Points de vigilance et travaux restant à réaliser](#section-8)
9. [Exploitation et maintenance](#section-9)
10. [Apports pour le dossier professionnel DWWM](#section-10)
11. [Références et preuves](#section-11)
12. [Annexe A — Inventaire des fichiers et de leurs évolutions](#section-12)
13. [Annexe B — Correspondance entre les produits et leurs photographies](#section-13)
14. [Annexe C — Journal exhaustif des opérations par commit](#section-14)

<a id="section-1"></a>

## 1. Présentation du projet et du besoin

### 1.1 Finalité

Golden Hair est une application Laravel destinée à présenter un salon, ses prestations, ses tarifs, ses produits et ses moyens de contact. Le visiteur peut consulter les informations depuis un ordinateur ou un téléphone, parcourir les produits et ouvrir une fiche détaillée sans quitter la page d’accueil.

Le résultat est un site vitrine comprenant une page d’accueil et deux pages d’information juridique. Le contenu commercial est centralisé dans des fichiers de configuration PHP. Cette organisation permet de modifier un produit, une photographie ou une coordonnée sans recopier le code HTML des cartes.

### 1.2 Besoins exprimés et réponses apportées

| Besoin | Réponse dans le projet |
| --- | --- |
| Disposer d’une structure Laravel compréhensible en formation | Routes nommées, contrôleurs, vues Blade organisées, fichiers de configuration et guides de maintenance |
| Présenter le salon sans espace client | Application publique, sans parcours d’inscription, de connexion ou de récupération de mot de passe |
| Reprendre une maquette HTML fournie | Découpage en sections Blade et adaptation du thème charbon, ivoire, or et bordeaux |
| Adapter la navigation aux ordinateurs et aux téléphones | Navigation de bureau et menu mobile natif enrichi en JavaScript |
| Présenter les produits en carrousel | Cartes réutilisables contenant photographie, marque, nom, description et prix |
| Utiliser les photographies fournies | Intégration de 28 photographies de produits et de deux visuels du salon |
| Afficher davantage d’informations sur un produit | Fenêtre modale native, détails, format et état de disponibilité |
| Fluidifier le défilement | Défilement natif, calcul des positions des cartes, gestion des clics rapides et interruption par interaction manuelle |
| Supprimer le défilement horizontal de toute la page | Correction du positionnement dans les carrousels et adaptation des contenus aux petites largeurs |
| Actualiser les contacts | Téléphone, WhatsApp, adresse, e-mail et Instagram regroupés dans la configuration métier |
| Préparer les informations légales | Deux pages dédiées, avec signalement explicite des informations encore manquantes |
| Conserver les explications pour la formation | Maintien et enrichissement de `docs/DWWM.md` et `docs/PRODUCTS.md` |

### 1.3 Périmètre fonctionnel à la date de la revue

Le site comprend trois cartes de prestations, cinquante lignes tarifaires réparties en trois groupes, vingt-huit cartes produits et un bloc de contact. La galerie générale est facultative : sa liste étant vide, elle n’est pas affichée. Les photographies des trois prestations ne sont pas encore renseignées ; des présentations graphiques de remplacement sont prévues.

Les produits sont tous configurés avec l’état `in_stock`, conformément à la confirmation donnée pendant le projet. Ce paramètre décrit le contenu enregistré dans le site ; il ne constitue pas une vérification du stock physique le 22 septembre 2026. Tous les prix produits sont actuellement affichés sous la forme « Prix sur demande ».

L’application ne comporte ni paiement, ni panier, ni réservation en ligne, ni formulaire de contact transmis au serveur, ni administration du catalogue. Les ventes et échanges commerciaux se poursuivent directement avec le salon. Aucune base de données métier n’est utilisée par les pages publiques.

### 1.4 Coordonnées intégrées

| Information | Valeur configurée |
| --- | --- |
| Activité | Coiffure • Barber |
| Téléphone | +596 696 97 64 78 |
| WhatsApp | +596 696 18 08 34 |
| Adresse | 22 Place Emile Berlan, 97232 LE LAMENTIN, Martinique |
| E-mail | goldenhair.martinique@gmail.com |
| Instagram | [@goldenhair.martinique](https://www.instagram.com/goldenhair.martinique/) |

Les coordonnées proviennent des informations communiquées pour le projet. Leur intégration ne remplace pas la validation des données juridiques de l’exploitant.

<a id="section-2"></a>

## 2. Méthode de travail et périmètre de la revue

### 2.1 Démarche suivie

Le développement a progressé par itérations : clarification du besoin, première structure Laravel, intégration de la maquette, ajout des produits, amélioration des interactions, nettoyage, correction responsive et préparation des pages légales. Les demandes successives ont conduit à préciser les choix, notamment l’absence d’authentification, la conservation des guides et la disponibilité initiale des vingt-huit produits.

La réalisation a bénéficié d’une assistance IA pour analyser, proposer et modifier du code, rédiger les guides et exécuter des vérifications. Les décisions métier, les photographies et plusieurs confirmations ont été apportées par le porteur du projet. Dans un dossier professionnel, la description des tâches personnellement réalisées doit correspondre à la participation effective du candidat.

### 2.2 Éléments examinés

La revue couvre les sources applicatives suivies par Git, les vues, les styles, le JavaScript, les configurations, les tests, les guides, les manifestes de dépendances et l’historique disponible jusqu’à la révision de référence. Les noms des médias ont été rapprochés de leur utilisation dans le catalogue. Les tests existants vérifient également la présence et la lisibilité des vingt-huit images produits.

L’inventaire distingue les fichiers applicatifs, les ressources, l’outillage, les éléments conservés du framework et les fichiers supprimés. Les bibliothèques complètes de `vendor/` et `node_modules/` ne sont pas présentées comme du code développé pour Golden Hair : leurs versions et les résultats des audits de dépendances sont documentés séparément. Les secrets de `.env` ne sont pas reproduits.

### 2.3 Traçabilité et limites de reconstitution

Les dates du rapport correspondent aux commits enregistrés, et non à un relevé d’heures de travail. L’historique permet de retrouver les versions sauvegardées et leurs différences. Les essais locaux qui n’ont jamais été enregistrés dans Git ne peuvent pas être reconstitués exhaustivement.

Les constats issus du code, les correctifs visibles dans les commits et les observations de navigateur sont distingués. Les problèmes de la maquette initiale décrits dans le guide historique sont signalés comme tels. Une amélioration ne constitue pas nécessairement la correction d’une panne, et un test réussi ne démontre pas l’absence de tout défaut.

La revue du 22 septembre a produit le présent document sans modifier les sources fonctionnelles du site. La compilation a régénéré les fichiers de production ignorés par Git.

<a id="section-3"></a>

## 3. Architecture et environnement technique

### 3.1 Versions effectivement observées

| Élément | Version installée lors de la revue | Fonction |
| --- | --- | --- |
| PHP | 8.5.0 | Exécution du code serveur |
| Laravel | 13.31.0 | Routage, configuration, contrôleurs, rendu et tests HTTP |
| Node.js | 26.0.0 | Exécution des outils front-end et des tests JavaScript |
| npm | 11.14.1 | Gestion des dépendances JavaScript |
| Vite | 8.3.0 | Compilation des ressources |
| Tailwind CSS et son plugin Vite | 4.3.3 | Styles utilitaires et thème |
| Laravel Vite Plugin | 3.2.0 | Intégration de Vite dans Laravel |
| PHPUnit | 12.5.35 | Tests PHP |
| Laravel Pint | 1.32.1 | Formatage PHP utilisé pendant les corrections |
| Laravel Boost | 2.8.1 | Assistance de développement |

`composer.json` et `package.json` déclarent des contraintes de versions ; `composer.lock` et `package-lock.json` enregistrent les versions résolues. Il faut donc distinguer, par exemple, la contrainte `^8.0.0` de Vite et la version 8.3.0 réellement installée. Le projet déclare PHP `^8.3` et a été contrôlé avec PHP 8.5.0.

Les autres dépendances directes PHP sont Faker 1.24.1, Pail 1.2.7, Pao 1.1.5, Tinker 3.0.2, Mockery 1.6.15 et Collision 8.9.5. Côté JavaScript, `concurrently` 10.0.5 et la dépendance facultative `@laravel/multiplex` 0.4.3 sont également installés. Leur présence ne signifie pas qu’ils sont tous utilisés par la page affichée au visiteur.

### 3.2 Séparation des responsabilités

```text
Requête du navigateur
        |
        v
public/index.php et bootstrap/app.php
        |
        v
routes/web.php
        |
        +-- home --> HomeController --> config/business.php
        |                              |
        |                              v
        |                     préparation des images et du stock
        |                              |
        |                              v
        |                     pages/home.blade.php
        |
        +-- legal / privacy --> InformationController
                                       |
                                       v
                           config/business.php et config/legal.php
                                       |
                                       v
                           pages/legal et pages/privacy
        |
        v
Layout partagé, navigation, sections et pied de page
        |
        v
HTML + CSS compilé + JavaScript + images et polices locales
```

Cette organisation suit les conventions de Laravel pour les routes, les contrôleurs et les vues. Il n’existe toutefois pas de couche de modèles Eloquent dans le périmètre actuel : les données métier sont des tableaux de configuration et non des enregistrements en base.

### 3.3 Routes

| Méthode | URL | Nom | Traitement |
| --- | --- | --- | --- |
| GET et HEAD | `/` | `home` | `HomeController::index()` |
| GET et HEAD | `/mentions-legales` | `legal` | `InformationController::legal()` |
| GET et HEAD | `/confidentialite` | `privacy` | `InformationController::privacy()` |

Ces trois routes applicatives n’activent pas les middlewares de session, de partage des erreurs de session et de protection contre la falsification de requêtes. Ce choix concerne uniquement les routes publiques de lecture déclarées dans ce groupe. Une future route de formulaire ou de modification devra disposer des protections adaptées ; elle ne devra pas être ajoutée automatiquement au même groupe.

La commande complète `route:list` affiche aussi `/up`, les routes techniques de stockage et, dans l’environnement de développement, la route de journalisation de Boost. Il serait donc inexact d’affirmer que Laravel ne possède que trois routes au total. Aucune route applicative de connexion ou d’inscription n’est déclarée.

### 3.4 Organisation des contenus et des ressources

`config/business.php` contient les coordonnées, les prestations, les tarifs, les produits et les chemins des images. `config/legal.php` contient les champs juridiques et le statut de finalisation des notices. Les fichiers image sont dans `public/images/`, avec des sous-dossiers distincts pour la marque, le salon, les prestations, les produits et la galerie.

Les ressources sources sont dans `resources/css/`, `resources/js/` et `resources/fonts/`. Vite produit les fichiers servis dans `public/build/`. Les noms compilés comportent une empreinte, ce qui permet de renouveler les URL lorsque le contenu change. Les dépendances, caches, journaux, secrets et fichiers compilés restent exclus du versionnement selon les règles du dépôt.

<a id="section-4"></a>

## 4. Historique des réalisations

### 4.1 Initialisation et cadrage du 9 au 10 septembre

Les commits `8a04dfe` et `d47f88d` créent puis précisent le README. Le commit `2d0e304` introduit la structure Laravel, les configurations, les premières vues, le contrôleur d’accueil, les tests et le guide DWWM.

La première configuration contient des informations commerciales encore vides. Le contrôleur vérifie déjà que les photographies restent dans le dossier public prévu. L’authentification est écartée de la structure retenue ; l’historique examiné ne contient pas de modèle utilisateur ni de parcours d’authentification à supprimer. `config/auth.php` conserve des ensembles de guards et providers vides.

### 4.2 Intégration de la maquette le 11 septembre

Le commit `a32620d` répartit la présentation en sections d’accueil, prestations, produits, galerie et contact. La liste des tarifs devient un composant partagé. Le logo est stocké dans un fichier WebP réutilisable.

Les anciens fichiers `public/css/app.css`, `public/js/navigation.js` et `business-info.blade.php` sont retirés au profit de l’organisation sous `resources/`. Le layout charge les ressources compilées avec `@vite`. La configuration Vite abandonne la police Instrument Sans prévue dans le socle initial. La maquette est adaptée aux polices Cormorant Garamond et DM Sans, qui seront ensuite hébergées localement.

Le script `composer run setup` est enrichi pour installer les dépendances npm avec les scripts d’installation désactivés, puis compiler les ressources. Ce script reste destiné à l’initialisation, car il génère une clé d’application.

### 4.3 Cartes produits et robustesse le 14 septembre

Le commit `2a567bb` introduit le composant `product-card.blade.php`, le guide des produits et les premiers tests JavaScript. Des cartes d’exemple permettent de préparer l’affichage avant l’arrivée des photographies réelles. Le contrôleur passe d’une simple vérification d’existence à une préparation des données photographiques avec texte alternatif de repli et contrôle des types.

Le menu est corrigé pour accepter les liens sans fragment et les fragments mal formés sans exception de sélecteur. Sa hauteur devient limitée à la zone visible, avec défilement interne si nécessaire.

### 4.4 Intégration du catalogue photographique le 14 septembre

Les commits `fc3c782` et `c877d8d` mettent en place l’utilisation des URL préparées par le contrôleur. L’encodage par segment conserve les séparateurs de dossiers tout en traitant les espaces, accents et caractères spéciaux des noms de fichiers.

Vingt-huit photographies deviennent vingt-huit cartes nommées. Les descriptions sont renseignées à partir des éléments disponibles sur les produits. Les prix non confirmés restent « Prix sur demande ». Le fichier `Product-Shelf.jpg` devient un fond décoratif atténué de la section produits, derrière des cartes opaques.

Le commit intermédiaire `fc3c782` fait déjà référence à `photo.url`, alors que sa production dans le contrôleur n’est introduite qu’au commit `c877d8d`. Cette dépendance est satisfaite dans l’état final. Elle doit être prise en compte si l’on examine ou réutilise isolément cette version intermédiaire.

### 4.5 Détails produits et disponibilité le 14 septembre

Le commit `4eb8f75` prépare la documentation des fiches et du stock. Le commit `059ac81` en réalise l’intégration applicative : champs `stock`, `details` et `size`, libellés de disponibilité, fenêtre `<dialog>`, script `products.js` et tests associés.

La fenêtre est unique et réutilisée pour chaque produit. Elle ne déclenche pas de requête supplémentaire vers un serveur de catalogue. Le contenu reste consultable dans un élément `<details>` lorsque l’amélioration JavaScript ne s’exécute pas.

Le carrousel est ajusté pour prendre en compte la destination d’un défilement déjà lancé. Plusieurs clics rapides produisent ainsi une progression cohérente. Les mises à jour de l’interface sont limitées à une par image d’animation, et l’annonce de la plage visible attend la stabilisation du mouvement.

### 4.6 Nettoyage et refonte visuelle le 14 septembre

Le commit `4d14595` retire le provider applicatif vide, le seeder de démonstration, les fichiers de tests génériques, la commande console de démonstration et le favicon inutilisé. Les références correspondantes sont retirées de l’amorçage, de l’autoload et de la configuration PHPUnit. Les guides et les fichiers nécessaires au fonctionnement ou à la maintenance sont conservés.

Le carrousel est aussi interrompu lorsque le focus entre dans une carte, afin que les boutons suivent la position réellement visible. Le commit `2c212ab` modernise l’accueil, le thème et la navigation. Le commit `d5ff895` réintroduit les `.gitkeep` des dossiers branding et business. Ils sont donc présents dans l’état final, même s’ils avaient été supprimés pendant le nettoyage.

Les commits de fusion `d099cd2` et `fb56998` réunissent les branches de travail. Les changements déjà décrits dans les commits d’origine ne sont pas comptés une seconde fois dans le journal des opérations.

### 4.7 Contacts, pages légales et correctifs responsive le 15 septembre

Le commit `35dca5e` intègre les coordonnées confirmées, les pages de mentions légales et de confidentialité, leur contrôleur et leur configuration. Les liens de navigation deviennent des liens vers la route d’accueil suivie d’un fragment, ce qui leur permet de fonctionner depuis les nouvelles pages.

La bannière `Facebook banner updated.png` est utilisée dans la section « Le salon ». Elle est placée en arrière-plan avec un dégradé sur ordinateur et affichée sous le texte sur mobile. Six fichiers WOFF2 et deux licences OFL sont ajoutés pour héberger les polices localement. Les requêtes Google Fonts sont retirées du layout.

Le positionnement relatif de la piste du carrousel corrige le débordement des éléments masqués visuellement. Le bandeau des prestations revient à la ligne, les liens de contact peuvent se couper, la fenêtre produit est adaptée aux écrans étroits et le prix n’est plus préfixé deux fois dans la fiche. Les vues des prestations et de la galerie utilisent également les URL d’images préparées.

<a id="section-5"></a>

## 5. Fonctionnement détaillé de l’application

### 5.1 Production de la page d’accueil

1. Laravel résout la route `home` et appelle `HomeController::index()`.
2. Le contrôleur lit `config('business')`.
3. Il prépare la photographie principale, le fond des produits et les photographies de la galerie.
4. Il parcourt les prestations et les produits pour préparer leurs photographies.
5. Il traduit le stock de chaque produit en état et en libellé français.
6. Il transmet ces données à `pages.home`.
7. Le layout commun fournit le document HTML, les métadonnées, la navigation, les ressources et le pied de page.
8. Les sections Blade produisent le contenu. JavaScript enrichit ensuite les éléments interactifs.

Les directives Blade `@extends`, `@section`, `@yield`, `@include`, `@if` et `@foreach` permettent de séparer la structure commune, les sections et les boucles d’affichage. Les champs éditables des produits sont affichés avec les accolades échappées `{{ ... }}`. La documentation officielle décrit ce fonctionnement dans [Blade](https://laravel.com/framework/docs/13.x/blade).

### 5.2 Préparation des photographies

`preparePhoto()` accepte une valeur de type `mixed`, puis vérifie sa structure. Un tableau valide doit contenir un chemin texte commençant par `images/`. Le chemin réel est résolu avec `realpath()` et doit rester dans le répertoire réel `public/images/`.

Le fichier doit exister et porter une extension autorisée : JPG, JPEG, PNG, WebP ou AVIF. Une photographie invalide est remplacée par `null`, ce qui permet à la vue d’afficher un contenu de repli. Un texte alternatif absent ou vide est remplacé par un libellé adapté.

L’URL est construite en encodant chaque segment du chemin avec `rawurlencode()`, puis en utilisant `asset()`. Le contrôleur valide un chemin et une extension ; il ne réalise pas à chaque requête une analyse complète du format binaire ou un contrôle antivirus. Il n’existe pas de formulaire public d’envoi d’images.

### 5.3 Modèle d’une carte produit

| Champ | Utilisation |
| --- | --- |
| `name` | Titre de la carte et de la fiche |
| `brand` | Marque, facultative |
| `description` | Présentation courte |
| `price` | Texte de prix ; aucune opération de paiement |
| `stock` | Valeur technique de disponibilité |
| `details` | Informations complémentaires en texte brut |
| `size` | Format ou contenance si renseigné |
| `photo.src` | Chemin relatif dans `public/` |
| `photo.alt` | Texte alternatif de l’image |

Le template de carte est partagé par toute la liste. Les images utilisent `object-fit: contain` afin de conserver l’ensemble du produit dans une zone carrée. Le chargement différé limite les chargements immédiats des images éloignées de la zone visible. Le prix est poussé vers le bas de la carte par la disposition Flexbox.

Le stock accepte `in_stock`, `out_of_stock` et `unknown`. Une valeur absente ou non reconnue affiche « Disponibilité à confirmer ». Les tests vérifient que l’application ne transforme pas une valeur incorrecte en annonce de disponibilité certaine.

### 5.4 Fiche produit

Un clic ou une activation clavier sur une carte prépare la fenêtre modale. Le script copie les champs textuels avec `textContent` et clone les éléments déjà rendus pour l’image, le badge et les détails. L’image de la fiche est chargée sans différé.

`showModal()` ouvre le dialogue natif et rend le reste du document inactif pour l’interaction. Le bouton Fermer utilise un formulaire `method="dialog"` : il ferme la fenêtre localement et n’envoie pas de formulaire à Laravel. La touche Échap est gérée par le comportement natif du dialogue. À la fermeture, le focus revient au déclencheur.

Un déplacement du pointeur supérieur au seuil prévu est traité comme un glissement afin de limiter les ouvertures involontaires pendant le parcours du carrousel. La fermeture par l’arrière-plan exige que le geste commence et se termine hors de la fenêtre.

### 5.5 Carrousels

La piste reste un conteneur à défilement horizontal natif. Le CSS organise les cartes avec Flexbox et utilise un alignement de défilement souple. Les points de rupture font évoluer la largeur des cartes : aperçu de la carte suivante sur petit écran, deux cartes à partir de 40 rem et trois à partir de 64 rem.

Le script calcule les positions effectives des cartes et borne chaque destination entre le début et la fin de la piste. Les flèches du clavier, Home et End sont prises en charge quand la piste elle-même a le focus. Les boutons restent focusables aux extrémités ; `aria-disabled` communique leur indisponibilité et le script empêche une action supplémentaire.

Les interactions tactiles, la molette et l’entrée du focus dans une carte interrompent le défilement programmé. `ResizeObserver` actualise les mesures. Les contrôles sont masqués si toutes les cartes tiennent dans la largeur disponible. Le carrousel produits annonce la plage visible avec une zone de statut accessible. Il n’existe pas de défilement automatique.

### 5.6 Responsive et accessibilité

Le site possède un attribut `lang="fr"`, une métadonnée viewport, un lien d’évitement, des zones de navigation nommées et des styles de focus visibles. Les boutons du carrousel disposent de libellés et les photographies de textes alternatifs. Le fond décoratif des produits est ignoré par les technologies d’assistance.

Le menu mobile repose sur `<details>` et `<summary>`. Il peut fonctionner sans JavaScript ; le script ajoute la fermeture au clic extérieur, après sélection d’un lien et avec Échap. Le changement vers le menu de bureau replace le focus si nécessaire.

Les titres, cartes, prix et coordonnées peuvent revenir à la ligne. Le dialogue utilise les unités `dvh` pour tenir dans la hauteur visible. Les préférences de réduction des animations sont prises en compte dans le CSS et dans le choix du comportement de défilement. Ces dispositions améliorent l’accessibilité ; elles ne constituent pas un audit RGAA complet ni une déclaration de conformité.

### 5.7 Contacts et confidentialité

Les actions téléphone, e-mail et WhatsApp utilisent respectivement `tel:`, `mailto:` et `https://wa.me/`. Le numéro téléphonique est normalisé pour le lien d’appel et le numéro WhatsApp pour son URL internationale. Instagram est un lien vers le profil, sans publication intégrée dans la page.

Les pages publiques contrôlées ne créent pas de session et ne déposent pas de cookie dans l’environnement de vérification. Les images et polices sont servies localement. Le code ne contient pas de module de publicité ou de statistiques. Les services utilisés après un clic externe, les échanges avec le salon et les éventuels journaux de l’hébergeur restent des sujets distincts traités dans la notice de confidentialité.

### 5.8 Préparation des informations légales

Le pied de page donne accès à deux pages séparées. Les mentions légales comportent les champs d’identification de l’exploitant, de publication, d’hébergement et de médiation. La page de confidentialité décrit la navigation, les prises de contact, les prestataires, les durées à préciser, les éventuels transferts et les droits des personnes.

Les informations manquantes restent `null` dans `config/legal.php` et sont signalées dans les vues. `confirmed` reste `false` : un message de finalisation et une directive `noindex, follow` sont affichés sur ces deux pages. Cette directive concerne leur indexation ; elle ne les rend ni privées ni juridiquement complètes.

Les rubriques ont été préparées à partir des sources officielles relatives aux [mentions des sociétés](https://entreprendre.service-public.gouv.fr/vosdroits/F37351), aux [entrepreneurs individuels](https://entreprendre.service-public.gouv.fr/vosdroits/F31228), à la [transparence des traitements](https://www.cnil.fr/fr/conformite-rgpd-information-des-personnes-et-transparence) et à la [médiation de la consommation](https://www.economie.gouv.fr/mediation-conso/vous-etes-un-professionnel/vos-principales-obligations-0). Le contenu devra être adapté à la situation réelle du salon et de son hébergement avant validation définitive.

<a id="section-6"></a>

## 6. Problèmes identifiés et corrections apportées

### 6.1 Corrections fonctionnelles et techniques

| Réf. | Problème ou limite observée | Correction ou protection | Trace principale |
| --- | --- | --- | --- |
| C01 | Boutons de carrousel seulement visuels dans la maquette initiale, selon le guide historique | Ajout des interactions et du calcul de défilement | `a32620d`, puis `2a567bb` et `059ac81` |
| C02 | Menu mobile restant ouvert après navigation, décrit lors de l’intégration | Fermeture et gestion du focus | `resources/js/navigation.js` |
| C03 | Recherche de cible avec un sélecteur de fragment pouvant être vide ou mal formé | Décodage protégé, contrôle de l’origine et de la page, puis `getElementById()` | `2a567bb` |
| C04 | Menu susceptible de dépasser la hauteur disponible en paysage | Hauteur maximale en `dvh` et défilement vertical interne | `2a567bb` |
| C05 | Configuration photographique mal typée pouvant provoquer une erreur | Validation de la structure et retour `null` | `2a567bb`, tests de photographies invalides |
| C06 | Risque de référence à un fichier absent, externe ou hors du dossier d’images | Préfixe imposé, résolution réelle du chemin, vérification de présence et d’extension | `HomeController::preparePhoto()` |
| C07 | Texte alternatif absent ou vide | Texte de remplacement lié au produit ou au salon | `2a567bb` |
| C08 | Noms d’images comportant espaces, accents et caractères spéciaux | Encodage de chaque segment d’URL | `c877d8d` |
| C09 | Usage de `photo.url` introduit avant sa production dans un commit intermédiaire | Ajout du champ calculé dans le contrôleur au commit suivant | `fc3c782` puis `c877d8d` |
| C10 | Les vues galerie et prestations contournaient encore l’URL préparée | Utilisation du même champ `url` que les produits | `35dca5e` |
| C11 | Répétition du markup et risque de divergence entre les produits | Extraction d’un template de carte unique | `2a567bb` |
| C12 | Catalogue vide, prix absent ou photographie manquante | Messages de remplacement et suppression des contrôles inutiles | `ProductCardsTest`, vues produits |
| C13 | Fin de carrousel et redimensionnement pouvant entraîner une perte de focus | État `aria-disabled`, boutons conservés dans le parcours, focus replacé avant masquage | `2a567bb`, tests JavaScript |
| C14 | Clics rapides pris depuis une position intermédiaire du défilement | Mémorisation de la destination en cours | `059ac81` |
| C15 | Animation programmée pouvant concurrencer un geste manuel | Interruption au pointeur ou à la molette | `059ac81` |
| C16 | Défilement restant actif pendant l’entrée du focus dans une carte | Interruption sur `focusin` | `4d14595` |
| C17 | Contrôles mis à jour à chaque événement et statut réécrit même lorsque son texte ne change pas | Mise à jour visuelle par `requestAnimationFrame`, comparaison du texte et annonce après stabilisation | `059ac81` |
| C18 | Ouverture involontaire d’une fiche après un glissement | Distinction entre déplacement du pointeur et activation | `products.js` et ses tests |
| C19 | Fermeture involontaire du dialogue après un geste commencé à l’intérieur | Vérification du début et de la fin du geste sur l’arrière-plan | `products.js` et ses tests |
| C20 | Défilement horizontal de la page entière | Contexte de positionnement sur `.carousel-track`, retour à la ligne et garde `overflow-x: clip` | `35dca5e`, contrôles navigateur |
| C21 | Cartes soulevées au survol pouvant être coupées par la piste | Remplacement du déplacement vertical par un traitement de bordure ou d’ombre | `35dca5e` |
| C22 | En-tête et titre de fiche trop encombrants sur petit écran | Grille avec colonne réductible, titre plus petit sur mobile et bouton Fermer accessible | `35dca5e` |
| C23 | Préfixe du prix recopié dans la fiche avec le libellé « Prix sur demande » | Marqueur de donnée déplacé sur le texte utile | `35dca5e` |
| C24 | Certaines prestations du bandeau masquées sur mobile | Retour à la ligne ; seules les séparations décoratives sont masquées | `35dca5e` |
| C25 | Ancres de navigation inadaptées depuis les nouvelles pages | Route `home` suivie du fragment concerné | `35dca5e` |
| C26 | Coordonnées provisoires et pied de page juridique sans pages dédiées | Coordonnées confirmées, liens effectifs et pages dédiées | `35dca5e` |
| C27 | Requêtes vers Google Fonts et cookies de session inutiles pour ces pages | Polices locales et exclusion ciblée des middlewares concernés | `35dca5e`, tests HTTP et navigateur |
| C28 | Références résiduelles à des fichiers supprimés pendant le nettoyage | Ajustement de l’amorçage, de l’autoload et de PHPUnit | `4d14595` |

### 6.2 Étude de cas du débordement horizontal

Le symptôme principal était la possibilité de déplacer toute la page latéralement, alors que seul le carrousel devait défiler. L’investigation précédente a relié ce comportement aux éléments `sr-only`, masqués visuellement et positionnés de manière absolue, présents à l’intérieur des cartes.

La piste ne définissait pas leur contexte de positionnement. L’ajout de `position: relative` sur `.carousel-track` maintient ces éléments dans le contexte du composant. Les corrections complémentaires traitent les textes longs, les colonnes réductibles et le bandeau de prestations. `overflow-x: clip` constitue une garde supplémentaire au niveau du document.

Lors de la revue du 22 septembre, la largeur du document a été comparée à celle de la fenêtre pour les trois pages et cinq largeurs. Le contrôle a aussi été réalisé en désactivant temporairement cette garde CSS dans le navigateur. Le document est resté à la largeur attendue dans les quinze cas. La correction vérifiée ne repose donc pas seulement sur le masquage du débordement.

### 6.3 Améliorations qui ne sont pas des pannes

L’extraction du logo de la maquette, le découpage des vues, le remplacement des anciens fichiers publics, l’hébergement local des polices, le retrait des fichiers de démonstration et l’intégration des arrière-plans constituent aussi des travaux de simplification, de performance ou de présentation. Ils sont documentés comme des améliorations, sans les présenter systématiquement comme des incidents de production.

<a id="section-7"></a>

## 7. Vérifications et résultats

### 7.1 Contrôles exécutés le 22 septembre 2026

| Contrôle | Résultat | Portée |
| --- | --- | --- |
| `php artisan test --compact` | 36 tests réussis, 477 assertions | Rendu HTTP, configuration métier, produits et pages légales |
| `node --test tests/Frontend/*.test.js` | 14 tests réussis | Logique JavaScript avec environnement DOM simulé |
| `npm run build` | Réussite avec Vite 8.3.0 | Compilation CSS, JavaScript et polices |
| `composer validate --strict` | Réussite | Validité du manifeste Composer et cohérence du verrouillage |
| `php -l` sur les fichiers PHP suivis hors vues Blade | 23 fichiers sans erreur de syntaxe | Syntaxe PHP ; le rendu Blade est exercé par les tests HTTP |
| `composer audit --format=json` | Aucune alerte signalée ; aucun paquet abandonné signalé | Base d’avis consultée à cette date |
| `npm audit --json` | Zéro vulnérabilité signalée | Base d’avis consultée à cette date |
| `php artisan route:list --no-interaction` | Commande réussie | Trois routes métier et quatre routes techniques dans l’environnement local |
| Contrôles dans Brave en mode headless | Réussite des scénarios ci-dessous | Moteur Chromium local, tailles émulées |

Les audits de dépendances indiquent l’absence d’alertes connues retournées par les outils à cette date. Ils ne constituent pas un audit de sécurité exhaustif du code, de la configuration de production ou de l’hébergement.

### 7.2 Couverture des tests PHP

| Fichier | Cas exécutés | Comportements contrôlés |
| --- | --- | --- |
| `tests/Feature/LandingPageTest.php` | 11 | Accueil sans base de données, absence des routes d’authentification, coordonnées, sections facultatives, photographies valides ou absentes, téléphone non confirmé, tarifs et catalogue configuré |
| `tests/Feature/ProductCardsTest.php` | 17 | Catalogue livré, existence et lisibilité des images, fond décoratif, données facultatives, catalogue vide, échappement des champs, six cas de stock, quatre configurations photographiques invalides et texte alternatif de repli |
| `tests/Feature/LegalPagesTest.php` | 8 | Trois pages sans sessions, liens communs, état provisoire des notices, rendu du statut confirmé, échappement de l’identité et coordonnées confirmées |

Le nombre de cas tient compte des fournisseurs de données PHPUnit. La vérification des trois pages ne se limite pas à leur présence dans le fichier de routes : elles sont demandées par le client de test. Le test sans session configure volontairement un pilote indisponible pour révéler une éventuelle dépendance cachée.

### 7.3 Couverture des tests JavaScript

| Fichier | Cas | Contrôles principaux |
| --- | --- | --- |
| `tests/Frontend/carousels.test.js` | 7 | Navigation, annonces, limites, focus, clavier, redimensionnement, clics successifs, interruption et réduction des animations |
| `tests/Frontend/navigation.test.js` | 2 | Fermeture du menu, focus de la cible, lien sans fragment et fragment mal formé |
| `tests/Frontend/products.test.js` | 5 | Ouverture et alimentation de la fiche, image et stock, fermeture et focus, glissement, arrière-plan et repli sans dialogue |

Ces tests utilisent `node:test`, `node:assert/strict` et `node:vm`. Ils ne chargent pas un navigateur complet ; les contrôles visuels et les interactions natives sont donc vérifiés séparément.

### 7.4 Contrôles dans le navigateur

| Page | Largeurs contrôlées en pixels CSS | Résultat |
| --- | --- | --- |
| Accueil | 320, 390, 768, 1024, 1440 | Largeur du document égale à la fenêtre |
| Mentions légales | 320, 390, 768, 1024, 1440 | Largeur du document égale à la fenêtre |
| Confidentialité | 320, 390, 768, 1024, 1440 | Largeur du document égale à la fenêtre |

Le menu mobile se ferme après sélection et donne le focus à la section visée. La fiche produit s’ouvre avec son état « En stock » et tient dans la largeur du téléphone émulé. Échap ferme la fiche et rétablit le focus. Deux clics rapides font avancer le carrousel ; un glissement tactile le déplace sans ouvrir de fiche. L’ouverture des tarifs conserve une largeur de page correcte.

Les chargements observés pendant ces scénarios ne présentent pas d’erreur HTTP 4xx ou 5xx, d’exception JavaScript, de réponse déposant un cookie ou de requête de ressource vers un domaine externe. Ces observations portent sur les pages et interactions parcourues, avant l’ouverture volontaire d’un service externe.

### 7.5 Limites de validation

La revue ne comprend pas une matrice complète Safari, Firefox et appareils physiques, un audit RGAA, une mesure de performance sur réseau mobile réel, un audit juridique définitif ou une recette sur un hébergement de production. Aucun taux de couverture du code n’a été mesuré. Les résultats ne doivent donc pas être présentés comme une certification de conformité ou une garantie d’absence de défaut.

<a id="section-8"></a>

## 8. Points de vigilance et travaux restant à réaliser

### 8.1 Informations métier et juridiques

| Priorité | Constat | Action attendue |
| --- | --- | --- |
| Avant publication définitive | Identité juridique, forme, immatriculation, direction de publication et champs applicables non renseignés | Compléter `config/legal.php` avec les informations exactes de l’exploitant |
| Avant publication définitive | Hébergeur et médiateur non communiqués | Renseigner les prestataires réellement retenus et l’affiliation effective |
| Avant validation de la confidentialité | Durées de conservation, accès techniques et transferts non précisés | Définir les pratiques réelles et adapter la notice |
| Avant validation commerciale | Horaires absents et tarifs de prestations non confirmés | Obtenir les valeurs définitives ; traiter `prices_confirmed`, `prices_note` et les libellés à vérifier |
| Maintenance courante | Stock configuré manuellement | Mettre à jour chaque fiche après un changement ; distinguer les variantes si leur disponibilité diffère |
| Avant affichage de prix produits fermes | Prix sur demande et prix manuscrits encore visibles sur certaines photographies, selon le guide produits | Vérifier la cohérence commerciale avec le salon |
| Validation éditoriale | Descriptions et contenances issues des éléments disponibles | Faire confirmer les références, formats et formulations par le salon ; ne pas ajouter d’allégations non vérifiées |

La fiche Gabri Natural Cologne regroupe S1, S2 et S3. Une seule valeur de stock concerne actuellement cet ensemble. Les deux présentations Rosemary & Mint, tube et pot, possèdent en revanche des cartes séparées.

### 8.2 Constats de maintenance relevés pendant cette revue

**Test du catalogue couplé aux données réelles.** Le test `test_uploaded_products_render_with_unique_photos_and_readable_details()` impose vingt-huit produits et un état `in_stock` pour chacun. Un ajout de produit ou une rupture de stock légitime peut donc rendre ce test rouge alors que l’affichage fonctionne. Une évolution souhaitable consiste à séparer le contrôle ponctuel du catalogue livré des tests fonctionnels utilisant leurs propres données de référence. Aucune modification de ce test n’a été effectuée pour la rédaction du rapport.

**Explication Blade à actualiser.** Le guide DWWM mentionne encore `@forelse` dans son explication des cartes d’attente. La vue actuelle utilise un `@if` sur le nombre de produits puis un `@foreach`. Son exemple court d’ajout de produit omet également `stock`, `details` et `size`, contrairement à l’exemple complet du guide `PRODUCTS.md`. Ces décalages sont documentaires ; le guide produits reste la référence pratique pour une nouvelle carte complète.

**Tarifs présents à deux endroits.** Les trois cartes de prestations et la liste complète possèdent leurs propres valeurs de prix. Une modification nécessite donc de contrôler les deux ensembles. Une future normalisation pourrait réduire le risque de divergence.

**Scripts disponibles à connaître.** `package.json` expose `dev` et `build`, mais ne contient pas de commande `npm test`. Les tests front-end se lancent directement avec Node. `composer run dev` démarre Artisan seulement ; il ne lance pas Vite. Ces choix fonctionnent, mais doivent être expliqués à la personne qui reprend le projet.

### 8.3 Performance et évolutions possibles

Le fichier de bannière pèse 2 104 392 octets, soit environ 2,10 Mo décimaux. Les vingt-huit photographies produits totalisent 1 657 201 octets, soit environ 1,66 Mo ; elles ne sont pas nécessairement téléchargées toutes immédiatement grâce au chargement différé.

Une version optimisée de la bannière et plusieurs dimensions d’image constitueraient une amélioration utile. Cette optimisation n’a pas été réalisée pendant la revue documentaire et aucun gain chiffré de temps de chargement n’est revendiqué.

L’ajout éventuel d’une administration, d’un formulaire, d’une réservation, de statistiques ou d’un stock automatisé modifierait l’architecture et les traitements de données. Ces fonctions nécessiteraient une nouvelle analyse des besoins, des protections serveur, des tests et de la notice de confidentialité.

<a id="section-9"></a>

## 9. Exploitation et maintenance

### 9.1 Mise en route locale

Pour une nouvelle installation uniquement, le projet fournit `composer run setup`. Ce script installe les dépendances, prépare `.env`, génère une clé et compile les ressources. Il ne doit pas être relancé aveuglément sur une application déjà déployée, car la génération de clé peut invalider des données chiffrées ou des sessions si l’application évolue.

Pour une installation préparée :

```sh
php artisan serve --no-interaction
```

Pendant la modification des styles ou du JavaScript, lancer Vite dans un second terminal :

```sh
npm run dev
```

Sans serveur Vite actif, compiler les changements front-end avec :

```sh
npm run build
```

### 9.2 Modifier une carte ou ajouter une photographie

Le fichier image se place dans `public/images/products/`. Son chemin dans la configuration commence par `images/products/`, sans le préfixe `public/`. Ajouter une photographie seule ne crée pas une carte : il faut également ajouter une entrée dans `business.products`.

La procédure détaillée, avec exemple complet et règles d’échappement des apostrophes PHP, figure dans [PRODUCTS.md](PRODUCTS.md). Les formats HEIC doivent être exportés dans un format pris en charge. Changer uniquement l’extension d’un fichier ne convertit pas son format.

Après une modification du contenu PHP, vider le cache de configuration s’il est actif :

```sh
php artisan config:clear --no-interaction
```

Une modification de texte, de stock ou de chemin photographique ne nécessite pas à elle seule une compilation Vite. Une modification des classes Tailwind, du CSS ou du JavaScript nécessite le serveur Vite ou une nouvelle compilation.

### 9.3 Contrôles avant diffusion

La mise en production n’est pas attestée par cette revue. Les opérations à préparer comprennent le choix de l’hébergeur, le domaine, HTTPS, une racine web pointant vers `public/`, les droits d’écriture nécessaires aux caches et aux journaux, la configuration d’environnement de production et une recette sur l’adresse publiée.

Le fichier `.env.example` est un exemple local avec `APP_DEBUG=true`. Il ne doit pas être repris sans adaptation en production. Les secrets ne doivent pas être placés dans `public/` ni ajoutés au dépôt. Les outils de développement ne doivent pas être exposés comme des fonctionnalités publiques du salon.

`.npmrc` désactive les scripts d’installation npm et active l’audit. Il ne bloque pas les commandes explicitement lancées, telles que `npm run build`. Si une dépendance future requiert une installation particulière, il faudra l’examiner plutôt que désactiver globalement cette règle sans justification.

<a id="section-10"></a>

## 10. Apports pour le dossier professionnel DWWM

### 10.1 Compétences illustrées

La fiche [France compétences RNCP37674](https://www.francecompetences.fr/recherche/rncp/37674/) distingue les activités front-end et back-end. Le rapprochement ci-dessous décrit les éléments démontrables de Golden Hair ; il ne vaut pas validation du titre ou de l’ensemble d’un bloc.

| Domaine du référentiel | Preuves utilisables dans Golden Hair | Limite à respecter |
| --- | --- | --- |
| Environnement de développement | Manifeste PHP et JavaScript, fichiers de verrouillage, Vite, commandes locales et tests | Distinguer installation locale et déploiement public |
| Conception des interfaces | Analyse d’une maquette fournie, adaptation du thème et choix responsive | Ne pas revendiquer la création originale de la maquette fournie |
| Réalisation des interfaces | Layout Blade, sections, cartes, navigation, styles et images | Expliquer les choix et leur fonctionnement |
| Dynamique côté navigateur | Carrousels, gestion du focus, fenêtre produit et repli natif | Distinguer tests simulés et contrôles dans un navigateur |
| Traitements côté serveur | Contrôleurs, préparation des photographies, interprétation du stock et rendu | Périmètre serveur limité à un site informatif |
| Données relationnelles et accès SQL ou NoSQL | Aucun exemple métier dans ce projet | Compétences à illustrer avec une autre réalisation |
| Préparation de l’exploitation | Guides, commandes et points de déploiement à prévoir | Aucun hébergement de production validé dans cette revue |

### 10.2 Exemple d’activité à présenter

**Intitulé proposé : intégration et fiabilisation d’un catalogue de produits sur un site vitrine responsive.**

Le besoin était de présenter les produits photographiés du salon et de permettre au visiteur de consulter leur détail et leur disponibilité. La solution utilise une liste de données centralisée, un composant Blade réutilisable, un carrousel natif et une fenêtre de détail unique.

L’analyse a conduit à traiter les images absentes, les noms de fichiers accentués, les états de stock non renseignés, les clics rapides et les gestes tactiles. Une difficulté de mise en page concernait le débordement horizontal de la page ; la correction a porté sur le contexte de positionnement et les contraintes de largeur. Les résultats ont été contrôlés par des tests PHP, des tests JavaScript et des mesures dans un navigateur.

Cette activité peut être accompagnée d’extraits de `HomeController`, `product-card.blade.php` et `carousels.js`, ainsi que du correctif CSS et des résultats de vérification. La version personnelle à intégrer au dossier doit préciser les tâches effectivement réalisées, les moyens utilisés, les échanges, l’autonomie et les apports de l’assistance.

### 10.3 Pièces de preuve utiles

Les annexes du présent rapport permettent de retrouver chaque fichier et chaque commit. Pour la présentation au jury, une sélection courte peut réunir une vue de l’accueil sur ordinateur, une vue mobile, une fiche produit ouverte, le schéma de circulation des données et un exemple de test.

Le dossier professionnel et le dossier de projet sont des supports distincts dans le parcours d’évaluation. Cette annexe technique peut alimenter leur rédaction, mais ne remplace pas la trame et les consignes de l’organisme de formation. Les informations personnelles du candidat, le cadre exact de réalisation et les périodes d’activité doivent être renseignés dans les documents correspondants.

<a id="section-11"></a>

## 11. Références et preuves

### 11.1 Références internes

- Révision Git de référence : `35dca5e085ecb2cae18fd9c1c8afad4f1e034e05`.
- [README du projet](../README.md) : démarrage et repères de contenu.
- [Guide DWWM](DWWM.md) : structure et explications pédagogiques, avec les réserves documentaires relevées au chapitre 8.
- [Guide produits](PRODUCTS.md) : ajout de carte, photographie, fiche et disponibilité.
- Dossiers `tests/Feature/` et `tests/Frontend/` : vérifications automatisées versionnées.
- Annexes A et C : rapprochement des fichiers avec leurs opérations Git ; annexe B : rapprochement des cartes avec leurs images.

Pour consulter une différence exacte, utiliser l’identifiant et le chemin de l’annexe :

```sh
git show 35dca5e -- resources/css/app.css
git log --follow -- config/business.php
git show 059ac81 -- resources/js/carousels.js
```

Le journal de l’annexe C répertorie toutes les opérations de fichier enregistrées dans le périmètre. Les différences ligne par ligne restent accessibles par ces commandes, y compris pour les fichiers de verrouillage, sans alourdir le corps du dossier avec plusieurs milliers de lignes de dépendances.

### 11.2 Références externes

| Source | Utilisation dans le projet ou le rapport |
| --- | --- |
| [France compétences — RNCP37674](https://www.francecompetences.fr/recherche/rncp/37674/) | Positionnement des compétences DWWM et distinction des supports d’évaluation |
| [Laravel — Blade](https://laravel.com/framework/docs/13.x/blade) | Templates, héritage de vues et échappement |
| [Laravel — Tests HTTP](https://laravel.com/framework/docs/13.x/http-tests) | Requêtes de test et assertions de réponse |
| [Service Public — Société](https://entreprendre.service-public.gouv.fr/vosdroits/F37351) | Rubriques d’identification à adapter à la forme juridique |
| [Service Public — Entrepreneur individuel](https://entreprendre.service-public.gouv.fr/vosdroits/F31228) | Variante selon le statut de l’exploitant |
| [Légifrance — LCEN article 1-1](https://www.legifrance.gouv.fr/loda/article_lc/LEGIARTI000049568614/) | Identification de l’éditeur et de l’hébergement |
| [CNIL — Information et transparence](https://www.cnil.fr/fr/conformite-rgpd-information-des-personnes-et-transparence) | Structure de la notice de confidentialité |
| [CNIL — Cookies et traceurs](https://www.cnil.fr/fr/cookies-et-autres-traceurs/que-dit-la-loi) | Distinction des usages de traceurs |
| [Ministère de l’Économie — Médiation](https://www.economie.gouv.fr/mediation-conso/vous-etes-un-professionnel/vos-principales-obligations-0) | Information sur le médiateur effectivement compétent |

Les références juridiques documentent la préparation des rubriques. L’identité, le statut, les contrats et les pratiques du salon restent déterminants pour leur finalisation.

<a id="section-12"></a>

## 12. Annexe A — Inventaire des fichiers et de leurs évolutions

L’inventaire ci-dessous couvre les 120 fichiers suivis à la révision de référence et les 11 chemins supprimés. Chaque chemin est nommé individuellement. Le présent rapport, créé après cette révision, est un livrable documentaire supplémentaire.

**Lecture de la trace :** A = ajout, M = modification, D = suppression. L’identifiant qui suit renvoie au commit détaillé en annexe C. Une absence de modification après A signifie qu’aucune édition ultérieure n’est enregistrée dans le périmètre.

### Fichiers racine et outillage

| Fichier | Rôle et évolution | Trace Git |
| --- | --- | --- |
| `.editorconfig` | Convention d’édition UTF-8, fins de ligne LF, indentation de quatre espaces et règles adaptées au Markdown et au YAML. Créé avec le socle, sans modification ultérieure enregistrée. | A `2d0e304` |
| `.env.example` | Exemple d’environnement Golden Hair en français, sessions et cache sur fichiers, file de tâches synchrone et messagerie de journalisation. Prévoit des réglages génériques de base de données et de services ; ceux-ci ne prouvent pas leur utilisation. Configuration locale à adapter avant production. | A `2d0e304` |
| `.gitattributes` | Normalisation des fins de ligne et choix des outils de comparaison selon les extensions. Règles d’export conservées du socle. | A `2d0e304` |
| `.gitignore` | Exclusion des secrets, dépendances installées, ressources compilées, caches et réglages propres à l’éditeur. Maintenu depuis l’initialisation. | A `2d0e304` |
| `.npmrc` | Scripts d’installation npm désactivés avec ignore-scripts ; audit activé. Aucun changement ultérieur enregistré. Les commandes explicites dev et build restent utilisables. | A `2d0e304` |
| `AGENTS.md` | Consignes de contribution et conventions Laravel, PHP, Pint et PHPUnit pour l’assistance au développement. Aucun rendu public et aucune route applicative. | A `2d0e304` |
| `CLAUDE.md` | Consignes de développement présentes dans le dépôt pour un autre outil d’assistance. Ne constitue ni une dépendance d’exécution ni une page du salon. | A `2d0e304` |
| `README.md` | Premier fichier du dépôt, puis présentation du projet, commandes d’installation, lien vers les guides, catalogue et repères pour compléter les informations légales. Historique enrichi avec les principales étapes fonctionnelles. | A `8a04dfe` ; M `d47f88d` ; M `a32620d` ; M `2a567bb` ; M `35dca5e` |
| `artisan` | Point d’entrée de la ligne de commande Laravel : chargement de Composer, amorçage et traitement de la commande. Fichier du socle conservé. | A `2d0e304` |
| `boost.json` | Activation des guidelines de Laravel Boost pour le développement. Ne définit aucun contenu métier du salon. | A `2d0e304` |
| `composer.json` | Dépendances PHP, autoload et scripts. Ajout de l’installation npm et du build au setup ; suppression des espaces de noms factories et seeders lors du nettoyage. Les contraintes de dépendances restent celles du manifeste versionné. | A `2d0e304` ; M `a32620d` ; M `4d14595` |
| `composer.lock` | Verrouillage des versions PHP résolues, ajouté avec le socle. Aucune modification ultérieure de ce fichier n’est enregistrée dans la période. Évite de confondre une contrainte avec une version installée. | A `2d0e304` |
| `package-lock.json` | Verrouillage npm ajouté lors de l’intégration de la maquette et utilisé par npm ci. Aucune modification ultérieure enregistrée. | A `a32620d` |
| `package.json` | Manifeste JavaScript en modules ES : commandes dev et build, Vite, Tailwind, plugin Laravel, concurrently et multiplex facultatif. Inchangé depuis son introduction ; aucun script test défini. | A `2d0e304` |
| `phpunit.xml` | Configuration des tests PHP et de l’environnement de test. Retrait de la suite Unit après suppression du test de démonstration ; conservation de la suite Feature. | A `2d0e304` ; M `4d14595` |
| `vite.config.js` | Configuration des entrées CSS et JavaScript, du rafraîchissement et du plugin Tailwind. Retrait de la configuration Bunny Instrument Sans lors de l’intégration du nouveau thème. | A `2d0e304` ; M `a32620d` |

### Contrôleurs et amorçage

| Fichier | Rôle et évolution | Trace Git |
| --- | --- | --- |
| `app/Http/Controllers/Controller.php` | Classe abstraite de base, sans méthode métier ni middleware d’authentification ajouté. Conservée pour suivre la structure Laravel. | A `2d0e304` |
| `app/Http/Controllers/HomeController.php` | Lecture du contenu, contrôle initial d’existence des images, puis préparation typée et textes alternatifs de repli. Ajout du fond produits, des URL encodées et de la traduction des états de stock. Suppression du calcul hasBusinessInfo devenu inutile. | A `2d0e304` ; M `a32620d` ; M `2a567bb` ; M `c877d8d` ; M `059ac81` |
| `app/Http/Controllers/InformationController.php` | Nouveau contrôleur des deux pages juridiques. Chaque méthode transmet les configurations business et legal à sa vue et déclare un retour View. | A `35dca5e` |
| `bootstrap/app.php` | Amorçage Laravel, routes web, santé et rendu JSON des erreurs selon la requête. Retrait de la référence à routes/console.php pendant le nettoyage. La condition api/* ne crée pas une API métier. | A `2d0e304` ; M `4d14595` |
| `bootstrap/cache/.gitignore` | Conservation du répertoire technique tout en excluant les fichiers de cache générés. Aucun contenu commercial. | A `2d0e304` |
| `bootstrap/providers.php` | Enregistrement initial du provider applicatif, remplacé par un tableau vide après suppression de ce provider sans comportement utile. | A `2d0e304` ; M `4d14595` |

### Configurations

| Fichier | Rôle et évolution | Trace Git |
| --- | --- | --- |
| `config/app.php` | Nom, environnement, debug, URL, langue, clé et maintenance. Fuseau applicatif UTC conservé ; les langues effectives sont pilotées par l’environnement. Socle non modifié après ajout. | A `2d0e304` |
| `config/auth.php` | Configuration volontairement vide des guards, providers et mots de passe. Formalise le périmètre sans comptes utilisateurs dès la première structure enregistrée. | A `2d0e304` |
| `config/business.php` | Source de contenu passée de champs génériques à la maquette, puis aux exemples et aux vingt-huit produits réels. Ajout des cinquante tarifs, des visuels, des descriptions, du stock, des détails et des formats ; actualisation finale de l’activité et des coordonnées. Les horaires et prix définitifs restent à confirmer. | A `2d0e304` ; M `a32620d` ; M `2a567bb` ; M `c877d8d` ; M `059ac81` ; M `35dca5e` |
| `config/cache.php` | Configuration de cache avec valeur de repli file. Les autres pilotes du framework sont conservés ; leur déclaration ne les active pas sur les pages publiques. | A `2d0e304` |
| `config/database.php` | Connexions du socle et réglages Redis conservés. Aucun modèle métier, migration ou accès SQL n’est utilisé pour le catalogue. Ce fichier n’est pas une base de données. | A `2d0e304` |
| `config/filesystems.php` | Définition des disques local privé, public et S3. Le disque local autorise les mécanismes de service du framework ; les photographies du site sont chargées directement depuis public/images. | A `2d0e304` |
| `config/legal.php` | Configuration ajoutée pour l’éditeur, l’hébergeur, les autres prestataires, le médiateur et la confidentialité. Valeurs inconnues laissées null ; confirmed reste false et la date éditoriale est celle du 15 septembre 2026. | A `35dca5e` |
| `config/logging.php` | Canaux de journaux Laravel. La configuration présente plusieurs destinations possibles ; aucune intégration Slack ou Papertrail du salon n’est implémentée dans les contrôleurs. | A `2d0e304` |
| `config/mail.php` | Pilotes de messagerie disponibles avec repli log. Le site utilise des liens mailto ; aucun envoi de message serveur n’est développé. | A `2d0e304` |
| `config/queue.php` | Connexions de tâches et repli sync. Aucun traitement métier asynchrone n’est ajouté. Certaines options standard font référence à une base de données sans être utilisées par la page. | A `2d0e304` |
| `config/services.php` | Emplacements standards de configuration de prestataires, lus depuis l’environnement. Leur présence ne signifie pas qu’un compte ou une connexion externe a été mis en place. | A `2d0e304` |
| `config/session.php` | Paramètres de sessions du framework, avec repli file et sérialisation JSON. Depuis le dernier commit, les trois routes métier n’ouvrent pas de session. | A `2d0e304` |

### Guides existants

| Fichier | Rôle et évolution | Trace Git |
| --- | --- | --- |
| `docs/DWWM.md` | Guide français créé avec le projet et enrichi au fil des intégrations, produits, fiches, confidentialité et corrections responsive. Les mentions de @forelse et l’exemple court de produit restent à actualiser, comme indiqué au chapitre 8. | A `2d0e304` ; M `a32620d` ; M `2a567bb` ; M `c877d8d` ; M `4eb8f75` ; M `35dca5e` |
| `docs/PRODUCTS.md` | Guide pratique créé pour les exemples, puis adapté aux vingt-huit images réelles, aux URL, au fond étagère, aux fiches et au stock manuel. Fournit les étapes de création et de dépannage d’une carte. | A `2a567bb` ; M `c877d8d` ; M `4eb8f75` |

### Entrées publiques et ressources photographiques

| Fichier | Rôle et évolution | Trace Git |
| --- | --- | --- |
| `public/.htaccess` | Règles Apache de réécriture vers index.php, gestion des en-têtes et suppression des slashs terminaux non nécessaires. Fichier du socle ; son usage dépend du serveur choisi. | A `2d0e304` |
| `public/images/branding/.gitkeep` | Fichier vide de maintien du dossier : créé avec le socle, supprimé pendant le nettoyage puis réintroduit le même jour. Présent dans la révision finale ; ne modifie pas le rendu. | A `2d0e304` ; D `4d14595` ; A `d5ff895` |
| `public/images/branding/golden-hair-logo.webp` | Logo externalisé dans un fichier réutilisable lors de l’intégration de la maquette. Utilisé dans la navigation, le pied de page, le favicon et le repli de l’accueil. | A `a32620d` |
| `public/images/business/.gitkeep` | Fichier vide de maintien du dossier : créé avec le socle, supprimé pendant le nettoyage puis réintroduit le même jour. Présent dans la révision finale ; ne modifie pas le rendu. | A `2d0e304` ; D `4d14595` ; A `d5ff895` |
| `public/images/business/Facebook banner updated.png` | Bannière fournie, intégrée au dernier commit : arrière-plan ombré sur ordinateur et visuel entier sous l’introduction sur mobile. Original conservé, poids de 2 104 392 octets. | A `35dca5e` |
| `public/images/business/Product-Shelf.jpg` | Photographie fournie, ajoutée avec le catalogue. Fond décoratif de la section produits avec une opacité de 0,18 ; l’absence du fichier conserve une section utilisable. | A `c877d8d` |
| `public/images/gallery/.gitkeep` | Fichier vide conservant le dossier prévu pour les futures photographies. Aucune photographie de cette catégorie n’est actuellement configurée pour l’affichage. | A `2d0e304` |
| `public/images/products/Design Essentials Almond & Avocado Curl Enhancing Mousse.jpg` | Photographie fournie, ajoutée avec le catalogue du 14 septembre. Affectation actuelle : Design Essentials — Almond & Avocado Curl Enhancing Mousse. Nom de fichier conservé ; correspondance détaillée en annexe B. | A `c877d8d` |
| `public/images/products/Design Essentials Almond & Avocado Honey Curl Forming Custard.jpg` | Photographie fournie, ajoutée avec le catalogue du 14 septembre. Affectation actuelle : Design Essentials — Almond & Avocado Honey Curl Forming Custard. Nom de fichier conservé ; correspondance détaillée en annexe B. | A `c877d8d` |
| `public/images/products/Design Essentials Almond & Avocado Sulfate-Free Shampoo.jpg` | Photographie fournie, ajoutée avec le catalogue du 14 septembre. Affectation actuelle : Design Essentials — Almond & Avocado Sulfate-Free Shampoo. Nom de fichier conservé ; correspondance détaillée en annexe B. | A `c877d8d` |
| `public/images/products/Design Essentials Coconut & Monoi Coconut Water Curl Refresher.jpg` | Photographie fournie, ajoutée avec le catalogue du 14 septembre. Affectation actuelle : Design Essentials — Coconut & Monoi Curl Refresher. Nom de fichier conservé ; correspondance détaillée en annexe B. | A `c877d8d` |
| `public/images/products/Design Essentials Formations Finishing Spritz.jpg` | Photographie fournie, ajoutée avec le catalogue du 14 septembre. Affectation actuelle : Design Essentials — Formations Finishing Spritz. Nom de fichier conservé ; correspondance détaillée en annexe B. | A `c877d8d` |
| `public/images/products/Design Essentials Natural Almond & Avocado Curling Crème.jpg` | Photographie fournie, ajoutée avec le catalogue du 14 septembre. Affectation actuelle : Design Essentials — Almond & Avocado Curling Crème. Nom de fichier conservé ; correspondance détaillée en annexe B. | A `c877d8d` |
| `public/images/products/Design Essentials Rosemary & Mint Moisturizing Conditioner.jpg` | Photographie fournie, ajoutée avec le catalogue du 14 septembre. Affectation actuelle : Design Essentials — Rosemary & Mint Conditioner — tube. Nom de fichier conservé ; correspondance détaillée en annexe B. | A `c877d8d` |
| `public/images/products/Design Essentials Rosemary & Mint Super Moisturizing Conditioner.jpg` | Photographie fournie, ajoutée avec le catalogue du 14 septembre. Affectation actuelle : Design Essentials — Rosemary & Mint Conditioner — pot. Nom de fichier conservé ; correspondance détaillée en annexe B. | A `c877d8d` |
| `public/images/products/Gabri Professional Keratin Hair Gel.jpg` | Photographie fournie, ajoutée avec le catalogue du 14 septembre. Affectation actuelle : Gabri Professional — Keratin Hair Gel. Nom de fichier conservé ; correspondance détaillée en annexe B. | A `c877d8d` |
| `public/images/products/Gabri Professional Natural Cologne.jpg` | Photographie fournie, ajoutée avec le catalogue du 14 septembre. Affectation actuelle : Gabri Professional — Natural Cologne — S1, S2 & S3. Nom de fichier conservé ; correspondance détaillée en annexe B. | A `c877d8d` |
| `public/images/products/Gummy Professional 2-in-1 Beard Shampoo & Conditioner.jpeg` | Photographie fournie, ajoutée avec le catalogue du 14 septembre. Affectation actuelle : Gummy Professional — 2-in-1 Beard Shampoo & Conditioner. Nom de fichier conservé ; correspondance détaillée en annexe B. | A `c877d8d` |
| `public/images/products/Gummy Professional Beard Oil – 50 ml.jpg` | Photographie fournie, ajoutée avec le catalogue du 14 septembre. Affectation actuelle : Gummy Professional — Beard Oil — 50 ml. Nom de fichier conservé ; correspondance détaillée en annexe B. | A `c877d8d` |
| `public/images/products/Gummy Professional Bump Repair.jpg` | Photographie fournie, ajoutée avec le catalogue du 14 septembre. Affectation actuelle : Gummy Professional — Bump Repair. Nom de fichier conservé ; correspondance détaillée en annexe B. | A `c877d8d` |
| `public/images/products/Hairgum Menthe Styling Gel.jpg` | Photographie fournie, ajoutée avec le catalogue du 14 septembre. Affectation actuelle : Hairgum — Menthe — gel coiffant. Nom de fichier conservé ; correspondance détaillée en annexe B. | A `c877d8d` |
| `public/images/products/Hairgum Road Tiaré.jpg` | Photographie fournie, ajoutée avec le catalogue du 14 septembre. Affectation actuelle : Hairgum — Road Tiaré — baume coiffant. Nom de fichier conservé ; correspondance détaillée en annexe B. | A `c877d8d` |
| `public/images/products/Ilea Cosmetiques Baume Nourrissant Banane.jpg` | Photographie fournie, ajoutée avec le catalogue du 14 septembre. Affectation actuelle : Iléa Cosmétiques — Baume Nourrissant Banane & Maracudja. Nom de fichier conservé ; correspondance détaillée en annexe B. | A `c877d8d` |
| `public/images/products/Iléa Cosmétiques Co-wash Douceur – Grenade & Avocat.jpg` | Photographie fournie, ajoutée avec le catalogue du 14 septembre. Affectation actuelle : Iléa Cosmétiques — Co-wash Douceur Grenade & Avocat. Nom de fichier conservé ; correspondance détaillée en annexe B. | A `c877d8d` |
| `public/images/products/Iléa Cosmétiques Huile Elixir Banane & Maracudja.jpg` | Photographie fournie, ajoutée avec le catalogue du 14 septembre. Affectation actuelle : Iléa Cosmétiques — Huile Elixir Banane & Maracudja. Nom de fichier conservé ; correspondance détaillée en annexe B. | A `c877d8d` |
| `public/images/products/Lakmé Teknia White Silver Shampoo.jpg` | Photographie fournie, ajoutée avec le catalogue du 14 septembre. Affectation actuelle : Lakmé Teknia — White Silver Shampoo. Nom de fichier conservé ; correspondance détaillée en annexe B. | A `c877d8d` |
| `public/images/products/Masque Douceur Grenade et Avocat.jpg` | Photographie fournie, ajoutée avec le catalogue du 14 septembre. Affectation actuelle : Iléa Cosmétiques — Masque Douceur Grenade & Avocat. Nom de fichier conservé ; correspondance détaillée en annexe B. | A `c877d8d` |
| `public/images/products/Morfose Purple Styling Hair Colour Wax.jpeg` | Photographie fournie, ajoutée avec le catalogue du 14 septembre. Affectation actuelle : Morfose — Purple Styling Hair Color Wax. Nom de fichier conservé ; correspondance détaillée en annexe B. | A `c877d8d` |
| `public/images/products/Rolda Black Hair Styling Gel.jpg` | Photographie fournie, ajoutée avec le catalogue du 14 septembre. Affectation actuelle : Rolda — Black Hair Styling Gel. Nom de fichier conservé ; correspondance détaillée en annexe B. | A `c877d8d` |
| `public/images/products/Rolda Hair Molding Cream White.jpg` | Photographie fournie, ajoutée avec le catalogue du 14 septembre. Affectation actuelle : Rolda — Hair Molding Cream White. Nom de fichier conservé ; correspondance détaillée en annexe B. | A `c877d8d` |
| `public/images/products/Rolda Power Hair Styling Gel.jpg` | Photographie fournie, ajoutée avec le catalogue du 14 septembre. Affectation actuelle : Rolda — Power Hair Styling Gel. Nom de fichier conservé ; correspondance détaillée en annexe B. | A `c877d8d` |
| `public/images/products/Taliah Waajid Black Earth Products Strengthener.jpg` | Photographie fournie, ajoutée avec le catalogue du 14 septembre. Affectation actuelle : Taliah Waajid — Black Earth Products Strengthener. Nom de fichier conservé ; correspondance détaillée en annexe B. | A `c877d8d` |
| `public/images/products/Tropical Naturals 100% Pure Shea Butter.jpg` | Photographie fournie, ajoutée avec le catalogue du 14 septembre. Affectation actuelle : Tropical Naturals — 100% Pure Shea Butter. Nom de fichier conservé ; correspondance détaillée en annexe B. | A `c877d8d` |
| `public/images/products/VIOPLANTES TRAITEMENT AU SOUFRE.jpg` | Photographie fournie, ajoutée avec le catalogue du 14 septembre. Affectation actuelle : Vioplantes — Traitement au soufre. Nom de fichier conservé ; correspondance détaillée en annexe B. | A `c877d8d` |
| `public/images/products/YONA T Extra Virgin Coconut Oil.jpg` | Photographie fournie, ajoutée avec le catalogue du 14 septembre. Affectation actuelle : Yona T — Huile de coco extra vierge. Nom de fichier conservé ; correspondance détaillée en annexe B. | A `c877d8d` |
| `public/images/services/.gitkeep` | Fichier vide conservant le dossier prévu pour les futures photographies. Aucune photographie de cette catégorie n’est actuellement configurée pour l’affichage. | A `a32620d` |
| `public/index.php` | Point d’entrée HTTP Laravel : maintenance, autoload, amorçage et traitement de la requête. Conservé depuis l’initialisation. | A `2d0e304` |
| `public/robots.txt` | Règle générale autorisant l’exploration. Les pages juridiques provisoires portent leur propre meta noindex ; robots.txt ne les rend pas confidentielles. | A `2d0e304` |

### Styles et scripts

| Fichier | Rôle et évolution | Trace Git |
| --- | --- | --- |
| `resources/css/app.css` | Thème Tailwind et styles complémentaires. Évolutions : maquette, carrousels, cartes et dialogue, fond étagère, refonte de l’accueil, correction du débordement, retour à la ligne, contacts, pages juridiques et import des polices locales. | A `2d0e304` ; M `a32620d` ; M `2a567bb` ; M `c877d8d` ; M `059ac81` ; M `2c212ab` ; M `35dca5e` |
| `resources/css/fonts.css` | Déclarations font-face locales pour Cormorant Garamond et DM Sans, avec sous-ensembles latin et latin étendu et font-display swap. Les déclarations réutilisent six fichiers WOFF2. | A `35dca5e` |
| `resources/js/app.js` | Point d’entrée initial du JavaScript, enrichi des imports navigation et carousels, puis products. Charge seulement les comportements nécessaires au site. | A `2d0e304` ; M `a32620d` ; M `059ac81` |
| `resources/js/carousels.js` | Création des contrôles de défilement, puis amélioration du clavier, du focus et des limites. Ajout des destinations cumulées, de l’interruption, des annonces différées, de ResizeObserver et de la réduction des animations. | A `a32620d` ; M `2a567bb` ; M `059ac81` ; M `4d14595` |
| `resources/js/navigation.js` | Comportement du menu mobile, fermeture et focus. Sécurisation de la recherche de cible pour les liens sans fragment, mal formés ou pointant sur une autre page. | A `a32620d` ; M `2a567bb` |
| `resources/js/products.js` | Ajout de la fenêtre de détail réutilisable, copie des champs, gestion des gestes, de l’arrière-plan et de la restitution du focus. Repli vers les détails natifs si showModal n’est pas disponible. | A `059ac81` |

### Polices et licences

| Fichier | Rôle et évolution | Trace Git |
| --- | --- | --- |
| `resources/fonts/cormorant-garamond-italic-500-latin-ext.woff2` | Police WOFF2 locale Cormorant Garamond, style italique, sous-ensemble latin étendu. Ajoutée au dernier commit ; utilisée par fonts.css et copiée dans le build Vite. | A `35dca5e` |
| `resources/fonts/cormorant-garamond-italic-500-latin.woff2` | Police WOFF2 locale Cormorant Garamond, style italique, sous-ensemble latin. Ajoutée au dernier commit ; utilisée par fonts.css et copiée dans le build Vite. | A `35dca5e` |
| `resources/fonts/cormorant-garamond-normal-500-latin-ext.woff2` | Police WOFF2 locale Cormorant Garamond, style romain, sous-ensemble latin étendu. Ajoutée au dernier commit ; utilisée par fonts.css et copiée dans le build Vite. | A `35dca5e` |
| `resources/fonts/cormorant-garamond-normal-500-latin.woff2` | Police WOFF2 locale Cormorant Garamond, style romain, sous-ensemble latin. Ajoutée au dernier commit ; utilisée par fonts.css et copiée dans le build Vite. | A `35dca5e` |
| `resources/fonts/cormorantgaramond-OFL.txt` | Licence OFL accompagnant la famille de polices correspondante, ajoutée lors de l’hébergement local. À conserver avec les fichiers distribués. | A `35dca5e` |
| `resources/fonts/dm-sans-normal-400-latin-ext.woff2` | Police WOFF2 locale DM Sans, style romain, sous-ensemble latin étendu. Ajoutée au dernier commit ; utilisée par fonts.css et copiée dans le build Vite. | A `35dca5e` |
| `resources/fonts/dm-sans-normal-400-latin.woff2` | Police WOFF2 locale DM Sans, style romain, sous-ensemble latin. Ajoutée au dernier commit ; utilisée par fonts.css et copiée dans le build Vite. | A `35dca5e` |
| `resources/fonts/dmsans-OFL.txt` | Licence OFL accompagnant la famille de polices correspondante, ajoutée lors de l’hébergement local. À conserver avec les fichiers distribués. | A `35dca5e` |

### Vues Blade

| Fichier | Rôle et évolution | Trace Git |
| --- | --- | --- |
| `resources/views/layouts/app.blade.php` | Document HTML partagé en français, viewport, titre, description, lien d’évitement et includes. Passage aux assets Vite, puis suppression de Google Fonts et ajout des sections de métadonnées propres aux pages juridiques. | A `2d0e304` ; M `a32620d` ; M `35dca5e` |
| `resources/views/pages/home.blade.php` | Page d’abord monolithique, ensuite réduite à l’assemblage des sections. Titre actualisé avec l’activité Coiffure • Barber. | A `2d0e304` ; M `a32620d` ; M `35dca5e` |
| `resources/views/pages/legal.blade.php` | Page ajoutée pour l’éditeur, l’hébergement, les réclamations, la médiation et les références officielles. Signale les champs manquants et le statut provisoire. | A `35dca5e` |
| `resources/views/pages/privacy.blade.php` | Page ajoutée pour la navigation, les échanges avec le salon, les services externes, les données et les droits. Reste à finaliser selon l’identité et les pratiques réelles. | A `35dca5e` |
| `resources/views/partials/footer.blade.php` | Pied de page d’abord simple, puis repris selon le thème et enrichi d’une navigation secondaire et de liens réels vers les deux notices. | A `2d0e304` ; M `a32620d` ; M `35dca5e` |
| `resources/views/partials/navigation.blade.php` | Navigation de bureau et menu mobile natif. Ajustements de hauteur et du style, puis liens vers home avec fragments pour fonctionner depuis toutes les pages. | A `2d0e304` ; M `a32620d` ; M `2a567bb` ; M `2c212ab` ; M `35dca5e` |
| `resources/views/partials/price-list.blade.php` | Composant dépliable ajouté lors de l’intégration de la maquette. Parcourt les trois groupes et les cinquante lignes, affiche la note des locks et le statut de confirmation des prix. | A `a32620d` |
| `resources/views/partials/product-card.blade.php` | Template ajouté pour éviter les cartes recopiées. Adoption de l’URL préparée, ajout des données copiables, du badge de stock et des détails natifs ; correction du marqueur du prix pour le dialogue. | A `2a567bb` ; M `fc3c782` ; M `059ac81` ; M `35dca5e` |
| `resources/views/partials/product-dialog.blade.php` | Structure native de la fiche ajoutée avec les détails produits. Ajustement ultérieur du titre mobile et du libellé d’en-tête ; fermeture locale via method=dialog. | A `059ac81` ; M `35dca5e` |
| `resources/views/sections/contact.blade.php` | Bloc de coordonnées et d’horaires ajouté avec la maquette. Conditions d’affichage des moyens de contact, puis ajout des lignes WhatsApp, e-mail et Instagram et des liens actualisés. | A `a32620d` ; M `35dca5e` |
| `resources/views/sections/gallery.blade.php` | Galerie facultative présente dès le socle, adaptée au thème et au chargement différé ; adoption finale des URL préparées. Masquée tant qu’aucune image valide n’est configurée. | A `2d0e304` ; M `a32620d` ; M `35dca5e` |
| `resources/views/sections/hairstyles.blade.php` | Section des trois prestations et de la liste tarifaire, ajoutée lors du découpage de l’accueil. Images facultatives et adoption finale des URL préparées. | A `a32620d` ; M `35dca5e` |
| `resources/views/sections/hero.blade.php` | Section d’introduction extraite de l’accueil, modernisée, puis adaptée à la bannière fournie. Boutons vers les prestations et le contact, coordonnées et bandeau des activités responsive. | A `a32620d` ; M `2c212ab` ; M `35dca5e` |
| `resources/views/sections/products.blade.php` | Section initiale avec produits de démonstration, puis boucle du template partagé et message de catalogue vide. Ajout du fond décoratif, de l’aide, du statut accessible et du dialogue commun. | A `a32620d` ; M `2a567bb` ; M `c877d8d` ; M `059ac81` |

### Routes

| Fichier | Rôle et évolution | Trace Git |
| --- | --- | --- |
| `routes/web.php` | Route d’accueil initiale, puis groupe des trois routes publiques de lecture sans session. Ajout des routes legal et privacy nommées. | A `2d0e304` ; M `35dca5e` |

### Répertoires techniques

| Fichier | Rôle et évolution | Trace Git |
| --- | --- | --- |
| `storage/app/.gitignore` | Règles de conservation du répertoire technique et d’exclusion des fichiers générés. Maintenu depuis le socle ; aucune suppression de ces supports d’exécution lors du nettoyage. | A `2d0e304` |
| `storage/app/private/.gitignore` | Règles de conservation du répertoire technique et d’exclusion des fichiers générés. Maintenu depuis le socle ; aucune suppression de ces supports d’exécution lors du nettoyage. | A `2d0e304` |
| `storage/app/public/.gitignore` | Règles de conservation du répertoire technique et d’exclusion des fichiers générés. Maintenu depuis le socle ; aucune suppression de ces supports d’exécution lors du nettoyage. | A `2d0e304` |
| `storage/framework/.gitignore` | Règles de conservation du répertoire technique et d’exclusion des fichiers générés. Maintenu depuis le socle ; aucune suppression de ces supports d’exécution lors du nettoyage. | A `2d0e304` |
| `storage/framework/cache/.gitignore` | Règles de conservation du répertoire technique et d’exclusion des fichiers générés. Maintenu depuis le socle ; aucune suppression de ces supports d’exécution lors du nettoyage. | A `2d0e304` |
| `storage/framework/cache/data/.gitignore` | Règles de conservation du répertoire technique et d’exclusion des fichiers générés. Maintenu depuis le socle ; aucune suppression de ces supports d’exécution lors du nettoyage. | A `2d0e304` |
| `storage/framework/sessions/.gitignore` | Règles de conservation du répertoire technique et d’exclusion des fichiers générés. Maintenu depuis le socle ; aucune suppression de ces supports d’exécution lors du nettoyage. | A `2d0e304` |
| `storage/framework/testing/.gitignore` | Règles de conservation du répertoire technique et d’exclusion des fichiers générés. Maintenu depuis le socle ; aucune suppression de ces supports d’exécution lors du nettoyage. | A `2d0e304` |
| `storage/framework/views/.gitignore` | Règles de conservation du répertoire technique et d’exclusion des fichiers générés. Maintenu depuis le socle ; aucune suppression de ces supports d’exécution lors du nettoyage. | A `2d0e304` |
| `storage/logs/.gitignore` | Règles de conservation du répertoire technique et d’exclusion des fichiers générés. Maintenu depuis le socle ; aucune suppression de ces supports d’exécution lors du nettoyage. | A `2d0e304` |

### Tests

| Fichier | Rôle et évolution | Trace Git |
| --- | --- | --- |
| `tests/Feature/LandingPageTest.php` | Tests initiaux du site informatif, adaptés aux sections et à la refonte du hero. La simulation d’un téléphone non confirmé est rendue explicite après l’intégration des coordonnées réelles. | A `2d0e304` ; M `a32620d` ; M `2c212ab` ; M `35dca5e` |
| `tests/Feature/LegalPagesTest.php` | Tests ajoutés pour les pages juridiques, les liens communs, les champs échappés, les notices provisoires ou confirmées et l’absence de dépendance aux sessions. | A `35dca5e` |
| `tests/Feature/ProductCardsTest.php` | Tests ajoutés avec les cartes, étendus au catalogue réel, à l’encodage, au fond, à la fiche, au stock et aux données invalides. Le contrôle du catalogue réel demeure lié au nombre 28 et à tous les stocks disponibles. | A `2a567bb` ; M `c877d8d` ; M `059ac81` |
| `tests/Frontend/carousels.test.js` | Tests Node ajoutés pour les flèches, le clavier, les limites et le focus ; enrichis pour les clics rapides, les interruptions et l’entrée du focus dans une carte. | A `2a567bb` ; M `059ac81` ; M `4d14595` |
| `tests/Frontend/navigation.test.js` | Tests Node du menu et des fragments d’URL atypiques. Environnement DOM simulé, sans dépendance supplémentaire de navigateur. | A `2a567bb` |
| `tests/Frontend/products.test.js` | Tests Node de l’ouverture et du contenu des fiches, du retour du focus, des gestes tactiles, de l’arrière-plan et du repli sans dialogue. | A `059ac81` |
| `tests/TestCase.php` | Classe de base des tests Laravel, conservée depuis la création du projet. | A `2d0e304` |

### Fichiers supprimés et remplacement

| Fichier supprimé | Motif et situation finale | Trace Git |
| --- | --- | --- |
| `app/Providers/AppServiceProvider.php` | Provider du socle avec méthodes sans comportement utile. Supprimé pendant le nettoyage ; son enregistrement a été retiré de bootstrap/providers.php. | A `2d0e304` ; D `4d14595` |
| `database/.gitignore` | Fichier de maintien du dossier de base de données du socle. Supprimé avec le dossier devenu inutile au site vitrine. | A `2d0e304` ; D `4d14595` |
| `database/seeders/DatabaseSeeder.php` | Seeder de départ sans fonction métier utilisée. Supprimé pendant le nettoyage et retiré de l’autoload correspondant. | A `2d0e304` ; D `4d14595` |
| `public/css/app.css` | Ancienne feuille de style publique de la première version. Supprimée lors de la centralisation des ressources sous resources et Vite. | A `2d0e304` ; D `a32620d` |
| `public/favicon.ico` | Favicon générique du socle. Supprimé ; le layout référence le logo WebP du salon. | A `2d0e304` ; D `4d14595` |
| `public/images/products/.gitkeep` | Maintenait le dossier produits avant les photographies. Supprimé après remplissage du dossier ; les fichiers image suffisent à le versionner. | A `a32620d` ; D `4d14595` |
| `public/js/navigation.js` | Ancien script public de navigation. Supprimé lors de l’adoption du point d’entrée Vite et du module sous resources/js. | A `2d0e304` ; D `a32620d` |
| `resources/views/sections/business-info.blade.php` | Section générique initiale d’informations. Supprimée au profit des sections détaillées, notamment contact et prestations. | A `2d0e304` ; D `a32620d` |
| `routes/console.php` | Commande inspire de démonstration. Supprimée et référence retirée de bootstrap/app.php. | A `2d0e304` ; D `4d14595` |
| `tests/Feature/ExampleTest.php` | Test HTTP générique du socle, supprimé au profit des tests applicatifs spécialisés. | A `2d0e304` ; D `4d14595` |
| `tests/Unit/ExampleTest.php` | Test unitaire de démonstration, supprimé. La suite Unit a également été retirée de phpunit.xml. | A `2d0e304` ; D `4d14595` |

### Fichiers locaux et générés

`.env` contient la configuration locale et les secrets ; il est ignoré et n’est pas reproduit dans ce rapport. `vendor/`, `node_modules/` et `public/build/` sont des résultats d’installation ou de compilation. Les fichiers de cache, les vues compilées et les journaux sous `storage/` et `bootstrap/cache/` sont gérés par Laravel. Ils ne sont pas assimilés aux 131 chemins historiques du code suivi.

Les scripts temporaires employés pour la revue, les sorties brutes des commandes et les captures de contrôle ne sont pas ajoutés à l’application. Aucun secret, contenu de journal utilisateur ou chemin personnel de la machine n’est nécessaire au présent dossier.

<a id="section-13"></a>

## 13. Annexe B — Correspondance entre les produits et leurs photographies

Les vingt-huit fichiers ci-dessous sont conservés dans `public/images/products/`. Les chemins enregistrés dans `config/business.php` commencent par `images/products/`. Pour toutes les cartes, le prix configuré est « Prix sur demande » et le stock enregistré est `in_stock`. Les formats indiqués sont les valeurs du catalogue ; une case non renseignée n’est pas complétée par supposition.

### Produit 01 — Almond & Avocado Curl Enhancing Mousse

- **Marque :** Design Essentials.
- **Photographie :** `Design Essentials Almond & Avocado Curl Enhancing Mousse.jpg`.
- **Format enregistré :** non renseigné.
- **Description courte enregistrée :** Mousse coiffante à l’amande et à l’avocat pour dessiner les boucles.

### Produit 02 — Almond & Avocado Honey Curl Forming Custard

- **Marque :** Design Essentials.
- **Photographie :** `Design Essentials Almond & Avocado Honey Curl Forming Custard.jpg`.
- **Format enregistré :** 354 g.
- **Description courte enregistrée :** Crème coiffante au miel pour la mise en forme des boucles.

### Produit 03 — Almond & Avocado Sulfate-Free Shampoo

- **Marque :** Design Essentials.
- **Photographie :** `Design Essentials Almond & Avocado Sulfate-Free Shampoo.jpg`.
- **Format enregistré :** 350 ml.
- **Description courte enregistrée :** Shampoing sans sulfates, hydratant et démêlant, à l’amande et à l’avocat.

### Produit 04 — Coconut & Monoi Curl Refresher

- **Marque :** Design Essentials.
- **Photographie :** `Design Essentials Coconut & Monoi Coconut Water Curl Refresher.jpg`.
- **Format enregistré :** non renseigné.
- **Description courte enregistrée :** Brume à l’eau de coco pour rafraîchir les boucles entre les coiffages.

### Produit 05 — Formations Finishing Spritz

- **Marque :** Design Essentials.
- **Photographie :** `Design Essentials Formations Finishing Spritz.jpg`.
- **Format enregistré :** 237 ml.
- **Description courte enregistrée :** Spray de finition pour fixer la coiffure.

### Produit 06 — Almond & Avocado Curling Crème

- **Marque :** Design Essentials.
- **Photographie :** `Design Essentials Natural Almond & Avocado Curling Crème.jpg`.
- **Format enregistré :** non renseigné.
- **Description courte enregistrée :** Crème coiffante à l’amande et à l’avocat pour les cheveux bouclés.

### Produit 07 — Rosemary & Mint Conditioner — tube

- **Marque :** Design Essentials.
- **Photographie :** `Design Essentials Rosemary & Mint Moisturizing Conditioner.jpg`.
- **Format enregistré :** 170 g.
- **Description courte enregistrée :** Après-shampoing hydratant au romarin et à la menthe, présenté en tube.

### Produit 08 — Rosemary & Mint Conditioner — pot

- **Marque :** Design Essentials.
- **Photographie :** `Design Essentials Rosemary & Mint Super Moisturizing Conditioner.jpg`.
- **Format enregistré :** non renseigné.
- **Description courte enregistrée :** Après-shampoing hydratant au romarin et à la menthe, présenté en pot.

### Produit 09 — Keratin Hair Gel

- **Marque :** Gabri Professional.
- **Photographie :** `Gabri Professional Keratin Hair Gel.jpg`.
- **Format enregistré :** 250 ml.
- **Description courte enregistrée :** Gel coiffant à la kératine pour mettre en forme les cheveux.

### Produit 10 — Natural Cologne — S1, S2 & S3

- **Marque :** Gabri Professional.
- **Photographie :** `Gabri Professional Natural Cologne.jpg`.
- **Format enregistré :** 75 ml par flacon.
- **Description courte enregistrée :** Eaux de Cologne en petits flacons. Les trois variantes sont présentées sur la photo.

### Produit 11 — 2-in-1 Beard Shampoo & Conditioner

- **Marque :** Gummy Professional.
- **Photographie :** `Gummy Professional 2-in-1 Beard Shampoo & Conditioner.jpeg`.
- **Format enregistré :** non renseigné.
- **Description courte enregistrée :** Shampoing et après-shampoing deux-en-un pour la barbe.

### Produit 12 — Beard Oil — 50 ml

- **Marque :** Gummy Professional.
- **Photographie :** `Gummy Professional Beard Oil – 50 ml.jpg`.
- **Format enregistré :** 50 ml.
- **Description courte enregistrée :** Huile pour l’entretien quotidien de la barbe, en flacon de 50 ml.

### Produit 13 — Bump Repair

- **Marque :** Gummy Professional.
- **Photographie :** `Gummy Professional Bump Repair.jpg`.
- **Format enregistré :** non renseigné.
- **Description courte enregistrée :** Soin après-rasage de la gamme Gummy Professional.

### Produit 14 — Menthe — gel coiffant

- **Marque :** Hairgum.
- **Photographie :** `Hairgum Menthe Styling Gel.jpg`.
- **Format enregistré :** 500 g.
- **Description courte enregistrée :** Gel coiffant à la menthe pour structurer la coiffure.

### Produit 15 — Road Tiaré — baume coiffant

- **Marque :** Hairgum.
- **Photographie :** `Hairgum Road Tiaré.jpg`.
- **Format enregistré :** 100 g.
- **Description courte enregistrée :** Baume coiffant au tiaré, présenté en boîte métallique.

### Produit 16 — Baume Nourrissant Banane & Maracudja

- **Marque :** Iléa Cosmétiques.
- **Photographie :** `Ilea Cosmetiques Baume Nourrissant Banane.jpg`.
- **Format enregistré :** 100 g.
- **Description courte enregistrée :** Baume capillaire nourrissant à la banane et au maracudja.

### Produit 17 — Co-wash Douceur Grenade & Avocat

- **Marque :** Iléa Cosmétiques.
- **Photographie :** `Iléa Cosmétiques Co-wash Douceur – Grenade & Avocat.jpg`.
- **Format enregistré :** 250 ml.
- **Description courte enregistrée :** Soin lavant à la grenade et à l’avocat pour le lavage des cheveux.

### Produit 18 — Huile Elixir Banane & Maracudja

- **Marque :** Iléa Cosmétiques.
- **Photographie :** `Iléa Cosmétiques Huile Elixir Banane & Maracudja.jpg`.
- **Format enregistré :** 100 ml.
- **Description courte enregistrée :** Huile capillaire à la banane et au maracudja, en flacon pompe.

### Produit 19 — White Silver Shampoo

- **Marque :** Lakmé Teknia.
- **Photographie :** `Lakmé Teknia White Silver Shampoo.jpg`.
- **Format enregistré :** 300 ml.
- **Description courte enregistrée :** Shampoing nuanceur pour cheveux blonds, méchés et blancs.

### Produit 20 — Masque Douceur Grenade & Avocat

- **Marque :** Iléa Cosmétiques.
- **Photographie :** `Masque Douceur Grenade et Avocat.jpg`.
- **Format enregistré :** 250 g.
- **Description courte enregistrée :** Masque capillaire à la grenade et à l’avocat pour cheveux secs et ternes.

### Produit 21 — Purple Styling Hair Color Wax

- **Marque :** Morfose.
- **Photographie :** `Morfose Purple Styling Hair Colour Wax.jpeg`.
- **Format enregistré :** 100 ml.
- **Description courte enregistrée :** Cire coiffante colorante violette pour personnaliser la coiffure.

### Produit 22 — Black Hair Styling Gel

- **Marque :** Rolda.
- **Photographie :** `Rolda Black Hair Styling Gel.jpg`.
- **Format enregistré :** non renseigné.
- **Description courte enregistrée :** Gel coiffant noir à fixation extra forte.

### Produit 23 — Hair Molding Cream White

- **Marque :** Rolda.
- **Photographie :** `Rolda Hair Molding Cream White.jpg`.
- **Format enregistré :** non renseigné.
- **Description courte enregistrée :** Crème coiffante à fixation extra forte pour sculpter les cheveux.

### Produit 24 — Power Hair Styling Gel

- **Marque :** Rolda.
- **Photographie :** `Rolda Power Hair Styling Gel.jpg`.
- **Format enregistré :** non renseigné.
- **Description courte enregistrée :** Gel coiffant de la gamme Power à fixation forte.

### Produit 25 — Black Earth Products Strengthener

- **Marque :** Taliah Waajid.
- **Photographie :** `Taliah Waajid Black Earth Products Strengthener.jpg`.
- **Format enregistré :** 177 ml.
- **Description courte enregistrée :** Soin capillaire au tea tree et à l’huile de coco.

### Produit 26 — 100% Pure Shea Butter

- **Marque :** Tropical Naturals.
- **Photographie :** `Tropical Naturals 100% Pure Shea Butter.jpg`.
- **Format enregistré :** non renseigné.
- **Description courte enregistrée :** Beurre de karité pur sans parfum, présenté en pot.

### Produit 27 — Traitement au soufre

- **Marque :** Vioplantes.
- **Photographie :** `VIOPLANTES TRAITEMENT AU SOUFRE.jpg`.
- **Format enregistré :** non renseigné.
- **Description courte enregistrée :** Soin au soufre pour le cuir chevelu. Demandez conseil au salon pour son utilisation.

### Produit 28 — Huile de coco extra vierge

- **Marque :** Yona T.
- **Photographie :** `YONA T Extra Virgin Coconut Oil.jpg`.
- **Format enregistré :** 100 ml.
- **Description courte enregistrée :** Huile de coco extra vierge, en flacon de 100 ml.

<a id="section-14"></a>

## 14. Annexe C — Journal exhaustif des opérations par commit

Ce journal reprend les 215 opérations de fichiers des 13 commits hors fusion, dans l’ordre topologique de l’historique. Les deux fusions sont aussi repérées. Un intitulé de commit peut être plus général que son contenu : la liste des fichiers est la référence pour son périmètre réel. Les changements des branches fusionnées sont comptés dans leurs commits d’origine.

### 2026-09-09 — 8a04dfe

**Intitulé enregistré :** Initial commit

- Ajout de `README.md`.

### 2026-09-10 — d47f88d

**Intitulé enregistré :** Update README.md to include project description

- Modification de `README.md`.

### 2026-09-10 — 2d0e304

**Intitulé enregistré :** feat: Initialize Laravel project with DWWM training guide, including basic structure and configuration

- Ajout de `.editorconfig`.
- Ajout de `.env.example`.
- Ajout de `.gitattributes`.
- Ajout de `.gitignore`.
- Ajout de `.npmrc`.
- Ajout de `AGENTS.md`.
- Ajout de `CLAUDE.md`.
- Ajout de `app/Http/Controllers/Controller.php`.
- Ajout de `app/Http/Controllers/HomeController.php`.
- Ajout de `app/Providers/AppServiceProvider.php`.
- Ajout de `artisan`.
- Ajout de `boost.json`.
- Ajout de `bootstrap/app.php`.
- Ajout de `bootstrap/cache/.gitignore`.
- Ajout de `bootstrap/providers.php`.
- Ajout de `composer.json`.
- Ajout de `composer.lock`.
- Ajout de `config/app.php`.
- Ajout de `config/auth.php`.
- Ajout de `config/business.php`.
- Ajout de `config/cache.php`.
- Ajout de `config/database.php`.
- Ajout de `config/filesystems.php`.
- Ajout de `config/logging.php`.
- Ajout de `config/mail.php`.
- Ajout de `config/queue.php`.
- Ajout de `config/services.php`.
- Ajout de `config/session.php`.
- Ajout de `database/.gitignore`.
- Ajout de `database/seeders/DatabaseSeeder.php`.
- Ajout de `docs/DWWM.md`.
- Ajout de `package.json`.
- Ajout de `phpunit.xml`.
- Ajout de `public/.htaccess`.
- Ajout de `public/css/app.css`.
- Ajout de `public/favicon.ico`.
- Ajout de `public/images/branding/.gitkeep`.
- Ajout de `public/images/business/.gitkeep`.
- Ajout de `public/images/gallery/.gitkeep`.
- Ajout de `public/index.php`.
- Ajout de `public/js/navigation.js`.
- Ajout de `public/robots.txt`.
- Ajout de `resources/css/app.css`.
- Ajout de `resources/js/app.js`.
- Ajout de `resources/views/layouts/app.blade.php`.
- Ajout de `resources/views/pages/home.blade.php`.
- Ajout de `resources/views/partials/footer.blade.php`.
- Ajout de `resources/views/partials/navigation.blade.php`.
- Ajout de `resources/views/sections/business-info.blade.php`.
- Ajout de `resources/views/sections/gallery.blade.php`.
- Ajout de `routes/console.php`.
- Ajout de `routes/web.php`.
- Ajout de `storage/app/.gitignore`.
- Ajout de `storage/app/private/.gitignore`.
- Ajout de `storage/app/public/.gitignore`.
- Ajout de `storage/framework/.gitignore`.
- Ajout de `storage/framework/cache/.gitignore`.
- Ajout de `storage/framework/cache/data/.gitignore`.
- Ajout de `storage/framework/sessions/.gitignore`.
- Ajout de `storage/framework/testing/.gitignore`.
- Ajout de `storage/framework/views/.gitignore`.
- Ajout de `storage/logs/.gitignore`.
- Ajout de `tests/Feature/ExampleTest.php`.
- Ajout de `tests/Feature/LandingPageTest.php`.
- Ajout de `tests/TestCase.php`.
- Ajout de `tests/Unit/ExampleTest.php`.
- Ajout de `vite.config.js`.

### 2026-09-11 — a32620d

**Intitulé enregistré :** Add new sections and functionality for improved user experience

- Modification de `README.md`.
- Modification de `app/Http/Controllers/HomeController.php`.
- Modification de `composer.json`.
- Modification de `config/business.php`.
- Modification de `docs/DWWM.md`.
- Ajout de `package-lock.json`.
- Suppression de `public/css/app.css`.
- Ajout de `public/images/branding/golden-hair-logo.webp`.
- Ajout de `public/images/products/.gitkeep`.
- Ajout de `public/images/services/.gitkeep`.
- Suppression de `public/js/navigation.js`.
- Modification de `resources/css/app.css`.
- Modification de `resources/js/app.js`.
- Ajout de `resources/js/carousels.js`.
- Ajout de `resources/js/navigation.js`.
- Modification de `resources/views/layouts/app.blade.php`.
- Modification de `resources/views/pages/home.blade.php`.
- Modification de `resources/views/partials/footer.blade.php`.
- Modification de `resources/views/partials/navigation.blade.php`.
- Ajout de `resources/views/partials/price-list.blade.php`.
- Suppression de `resources/views/sections/business-info.blade.php`.
- Ajout de `resources/views/sections/contact.blade.php`.
- Modification de `resources/views/sections/gallery.blade.php`.
- Ajout de `resources/views/sections/hairstyles.blade.php`.
- Ajout de `resources/views/sections/hero.blade.php`.
- Ajout de `resources/views/sections/products.blade.php`.
- Modification de `tests/Feature/LandingPageTest.php`.
- Modification de `vite.config.js`.

### 2026-09-14 — 2a567bb

**Intitulé enregistré :** feat: Enhance product management with new features and documentation

- Modification de `README.md`.
- Modification de `app/Http/Controllers/HomeController.php`.
- Modification de `config/business.php`.
- Modification de `docs/DWWM.md`.
- Ajout de `docs/PRODUCTS.md`.
- Modification de `resources/css/app.css`.
- Modification de `resources/js/carousels.js`.
- Modification de `resources/js/navigation.js`.
- Modification de `resources/views/partials/navigation.blade.php`.
- Ajout de `resources/views/partials/product-card.blade.php`.
- Modification de `resources/views/sections/products.blade.php`.
- Ajout de `tests/Feature/ProductCardsTest.php`.
- Ajout de `tests/Frontend/carousels.test.js`.
- Ajout de `tests/Frontend/navigation.test.js`.

### 2026-09-14 — fc3c782

**Intitulé enregistré :** Refactor code structure and remove redundant sections for improved readability and maintainability

- Modification de `resources/views/partials/product-card.blade.php`.

### 2026-09-14 — c877d8d

**Intitulé enregistré :** feat: Add product details and background image for enhanced product display

- Modification de `app/Http/Controllers/HomeController.php`.
- Modification de `config/business.php`.
- Modification de `docs/DWWM.md`.
- Modification de `docs/PRODUCTS.md`.
- Ajout de `public/images/business/Product-Shelf.jpg`.
- Ajout de `public/images/products/Design Essentials Almond & Avocado Curl Enhancing Mousse.jpg`.
- Ajout de `public/images/products/Design Essentials Almond & Avocado Honey Curl Forming Custard.jpg`.
- Ajout de `public/images/products/Design Essentials Almond & Avocado Sulfate-Free Shampoo.jpg`.
- Ajout de `public/images/products/Design Essentials Coconut & Monoi Coconut Water Curl Refresher.jpg`.
- Ajout de `public/images/products/Design Essentials Formations Finishing Spritz.jpg`.
- Ajout de `public/images/products/Design Essentials Natural Almond & Avocado Curling Crème.jpg`.
- Ajout de `public/images/products/Design Essentials Rosemary & Mint Moisturizing Conditioner.jpg`.
- Ajout de `public/images/products/Design Essentials Rosemary & Mint Super Moisturizing Conditioner.jpg`.
- Ajout de `public/images/products/Gabri Professional Keratin Hair Gel.jpg`.
- Ajout de `public/images/products/Gabri Professional Natural Cologne.jpg`.
- Ajout de `public/images/products/Gummy Professional 2-in-1 Beard Shampoo & Conditioner.jpeg`.
- Ajout de `public/images/products/Gummy Professional Beard Oil – 50 ml.jpg`.
- Ajout de `public/images/products/Gummy Professional Bump Repair.jpg`.
- Ajout de `public/images/products/Hairgum Menthe Styling Gel.jpg`.
- Ajout de `public/images/products/Hairgum Road Tiaré.jpg`.
- Ajout de `public/images/products/Ilea Cosmetiques Baume Nourrissant Banane.jpg`.
- Ajout de `public/images/products/Iléa Cosmétiques Co-wash Douceur – Grenade & Avocat.jpg`.
- Ajout de `public/images/products/Iléa Cosmétiques Huile Elixir Banane & Maracudja.jpg`.
- Ajout de `public/images/products/Lakmé Teknia White Silver Shampoo.jpg`.
- Ajout de `public/images/products/Masque Douceur Grenade et Avocat.jpg`.
- Ajout de `public/images/products/Morfose Purple Styling Hair Colour Wax.jpeg`.
- Ajout de `public/images/products/Rolda Black Hair Styling Gel.jpg`.
- Ajout de `public/images/products/Rolda Hair Molding Cream White.jpg`.
- Ajout de `public/images/products/Rolda Power Hair Styling Gel.jpg`.
- Ajout de `public/images/products/Taliah Waajid Black Earth Products Strengthener.jpg`.
- Ajout de `public/images/products/Tropical Naturals 100% Pure Shea Butter.jpg`.
- Ajout de `public/images/products/VIOPLANTES TRAITEMENT AU SOUFRE.jpg`.
- Ajout de `public/images/products/YONA T Extra Virgin Coconut Oil.jpg`.
- Modification de `resources/css/app.css`.
- Modification de `resources/views/sections/products.blade.php`.
- Modification de `tests/Feature/ProductCardsTest.php`.

### 2026-09-14 — 4eb8f75

**Intitulé enregistré :** feat: Add product availability and details management to enhance user experience

- Modification de `docs/DWWM.md`.
- Modification de `docs/PRODUCTS.md`.

### 2026-09-14 — 059ac81

**Intitulé enregistré :** feat: enhance product display and interaction features

- Modification de `app/Http/Controllers/HomeController.php`.
- Modification de `config/business.php`.
- Modification de `resources/css/app.css`.
- Modification de `resources/js/app.js`.
- Modification de `resources/js/carousels.js`.
- Ajout de `resources/js/products.js`.
- Modification de `resources/views/partials/product-card.blade.php`.
- Ajout de `resources/views/partials/product-dialog.blade.php`.
- Modification de `resources/views/sections/products.blade.php`.
- Modification de `tests/Feature/ProductCardsTest.php`.
- Modification de `tests/Frontend/carousels.test.js`.
- Ajout de `tests/Frontend/products.test.js`.

### 2026-09-14 — 4d14595

**Intitulé enregistré :** refactor: remove unused files and clean up project structure

- Suppression de `app/Providers/AppServiceProvider.php`.
- Modification de `bootstrap/app.php`.
- Modification de `bootstrap/providers.php`.
- Modification de `composer.json`.
- Suppression de `database/.gitignore`.
- Suppression de `database/seeders/DatabaseSeeder.php`.
- Modification de `phpunit.xml`.
- Suppression de `public/favicon.ico`.
- Suppression de `public/images/branding/.gitkeep`.
- Suppression de `public/images/business/.gitkeep`.
- Suppression de `public/images/products/.gitkeep`.
- Modification de `resources/js/carousels.js`.
- Suppression de `routes/console.php`.
- Suppression de `tests/Feature/ExampleTest.php`.
- Modification de `tests/Frontend/carousels.test.js`.
- Suppression de `tests/Unit/ExampleTest.php`.

### 2026-09-14 — d5ff895

**Intitulé enregistré :** feat: add .gitkeep files to branding and business image directories for better version control

- Ajout de `public/images/branding/.gitkeep`.
- Ajout de `public/images/business/.gitkeep`.

### 2026-09-14 — 2c212ab

**Intitulé enregistré :** Modernize salon landing page design

- Modification de `resources/css/app.css`.
- Modification de `resources/views/partials/navigation.blade.php`.
- Modification de `resources/views/sections/hero.blade.php`.
- Modification de `tests/Feature/LandingPageTest.php`.

### 2026-09-14 — d099cd2

**Intitulé enregistré :** Merge pull request #1 from adekerv/codex/update-code-for-modern-salon-website

**Fusion de branches.** Les modifications des commits parents sont déjà inventoriées ; aucune opération de fichier supplémentaire n’est comptée ici.

### 2026-09-14 — fb56998

**Intitulé enregistré :** Merge branch 'layerOne' of https://github.com/adekerv/Golden-Hair into layerOne

**Fusion de branches.** Les modifications des commits parents sont déjà inventoriées ; aucune opération de fichier supplémentaire n’est comptée ici.

### 2026-09-15 — 35dca5e

**Intitulé enregistré :** feat: enhance legal and privacy pages, update meta tags, and improve navigation

- Modification de `README.md`.
- Ajout de `app/Http/Controllers/InformationController.php`.
- Modification de `config/business.php`.
- Ajout de `config/legal.php`.
- Modification de `docs/DWWM.md`.
- Ajout de `public/images/business/Facebook banner updated.png`.
- Modification de `resources/css/app.css`.
- Ajout de `resources/css/fonts.css`.
- Ajout de `resources/fonts/cormorant-garamond-italic-500-latin-ext.woff2`.
- Ajout de `resources/fonts/cormorant-garamond-italic-500-latin.woff2`.
- Ajout de `resources/fonts/cormorant-garamond-normal-500-latin-ext.woff2`.
- Ajout de `resources/fonts/cormorant-garamond-normal-500-latin.woff2`.
- Ajout de `resources/fonts/cormorantgaramond-OFL.txt`.
- Ajout de `resources/fonts/dm-sans-normal-400-latin-ext.woff2`.
- Ajout de `resources/fonts/dm-sans-normal-400-latin.woff2`.
- Ajout de `resources/fonts/dmsans-OFL.txt`.
- Modification de `resources/views/layouts/app.blade.php`.
- Modification de `resources/views/pages/home.blade.php`.
- Ajout de `resources/views/pages/legal.blade.php`.
- Ajout de `resources/views/pages/privacy.blade.php`.
- Modification de `resources/views/partials/footer.blade.php`.
- Modification de `resources/views/partials/navigation.blade.php`.
- Modification de `resources/views/partials/product-card.blade.php`.
- Modification de `resources/views/partials/product-dialog.blade.php`.
- Modification de `resources/views/sections/contact.blade.php`.
- Modification de `resources/views/sections/gallery.blade.php`.
- Modification de `resources/views/sections/hairstyles.blade.php`.
- Modification de `resources/views/sections/hero.blade.php`.
- Modification de `routes/web.php`.
- Modification de `tests/Feature/LandingPageTest.php`.
- Ajout de `tests/Feature/LegalPagesTest.php`.

### État au terme de la revue documentaire

La rédaction ajoute `docs/DOSSIER_PROFESSIONNEL_GOLDEN_HAIR.md` après la révision de référence. Les sources applicatives restent celles de `35dca5e`. Les contrôles du chapitre 7 ont été exécutés sur cette version ; les informations métier et les points de maintenance à compléter sont explicités au chapitre 8.
