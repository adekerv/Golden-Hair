# Golden Hair — guide Laravel pour la formation DWWM

## Ce qui a été créé

Le dépôt initial contenait uniquement `README.md`. Il n’y avait donc aucun code applicatif existant à corriger. Le README original est conservé.

Le projet utilise le squelette officiel Laravel 13, Blade, CSS et JavaScript natif. Le texte français est une proposition provisoire : aucun cahier des charges, catalogue, tarif, logo ou contact n’était présent. La page ne comporte pas de réservation ni de boutique fonctionnelle.

## Lancer le projet

Les dépendances PHP sont installées. Le site vitrine fonctionne sans base de données : les sessions et le cache utilisent des fichiers, et aucune tâche en arrière-plan n’est nécessaire.

```sh
php artisan serve
```

Ouvrir l’adresse indiquée dans le terminal, généralement `http://127.0.0.1:8000`.

Pour une nouvelle copie du dépôt, avec PHP et Composer installés :

```sh
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```

Le fichier `composer.lock` fixe les versions réellement installées. Vérifier leur compatibilité avec `composer check-platform-reqs` sur une autre machine. Ne pas partager `.env` : il contient notamment la clé de l’application.

Les fichiers de cette page sont servis directement depuis `public/css` et `public/js` : aucune compilation npm n’est nécessaire. Les fichiers Vite du squelette sont conservés pour une évolution future ; ils ne sont pas chargés par le layout actuel.

## Structure

```text
app/
  Http/Controllers/HomeController.php   Contrôleur de l’accueil
bootstrap/                             Démarrage et configuration du framework
config/
  business.php                         Textes, coordonnées, prestations, horaires et photos
  auth.php                             Aucun guard ni fournisseur d’utilisateurs
database/                              Répertoire Laravel conservé, inutilisé par la page
public/                                Seul dossier à exposer sur un serveur web
  index.php                            Point d’entrée HTTP de Laravel
  css/app.css                          Styles du site
  js/navigation.js                     Menu mobile
  images/business/                     Photo principale et photos du lieu
  images/gallery/                      Photos de la galerie
  images/branding/                     Logo et éléments de marque
resources/views/
  layouts/app.blade.php                 Structure HTML partagée
  pages/home.blade.php                  Contenu de l’accueil
  partials/navigation.blade.php         Barre de navigation
  partials/footer.blade.php             Pied de page
  sections/gallery.blade.php            Galerie facultative
  sections/business-info.blade.php      Coordonnées, horaires et prestations
routes/web.php                         Association URL → contrôleur
storage/                               Logs, caches et fichiers générés
tests/                                 Tests automatisés
artisan                                Commandes Laravel
composer.json                          Dépendances PHP et scripts
composer.lock                          Versions des dépendances
```

## Le code, étape par étape

### 1. La requête arrive sur une route

Dans `routes/web.php`, `Route::get('/', [HomeController::class, 'index'])->name('home')` associe une requête HTTP GET sur `/` à la méthode `index` du contrôleur. Le nom `home` permet de générer son URL avec `route('home')`, sans écrire cette URL partout.

### 2. Le contrôleur choisit la vue

Dans `HomeController`, `index(): View` annonce que la méthode renvoie une vue. `view('pages.home', ...)` charge `resources/views/pages/home.blade.php`. Le point représente un sous-dossier. `config('business')` lit les informations du commerce. Le contrôleur transmet ces informations à Blade et vérifie que les fichiers photo existent dans `public/images`. Aucun modèle ni accès à une base de données n’est nécessaire.

### 3. La page utilise un layout

`@extends('layouts.app')` indique que l’accueil utilise le squelette commun. `@section('title', ...)` définit son titre et `@section('content')` contient son HTML principal. `@endsection` termine cette section.

### 4. Le layout assemble le document

`layouts/app.blade.php` contient `<!DOCTYPE html>`, `<head>` et `<body>`. `@yield('title', 'Golden Hair')` insère le titre avec une valeur par défaut. `@yield('content')` insère le contenu de la page. `@include` charge les fichiers partagés de navigation et de pied de page.

`{{ asset('css/app.css') }}` génère l’URL d’un fichier public. Les doubles accolades Blade échappent le texte affiché. `defer` permet au navigateur d’exécuter le JavaScript une fois le HTML analysé.

### 5. Le HTML donne du sens au contenu

`nav` identifie la navigation, `main` le contenu principal et `footer` le pied de page. Les titres `h1`, `h2` et `h3` structurent la lecture. Les liens avec `#univers` et `#approche` conduisent à des sections existantes. Le lien « Aller au contenu » permet de contourner la navigation au clavier.

### 6. Le CSS adapte la mise en page

Les variables dans `:root` centralisent les couleurs. Flexbox aligne la navigation. CSS Grid organise l’accueil et les trois colonnes. `clamp()` adapte la taille des titres dans des limites définies. La règle `@media (max-width: 48rem)` passe les grilles à une colonne et adapte la navigation aux petits écrans.

### 7. Le JavaScript contrôle le menu

`querySelector` récupère le bouton et les liens. `matchMedia` suit le même seuil que le CSS. `setOpen()` synchronise la visibilité des liens et `aria-expanded`, qui indique l’état du bouton aux technologies d’assistance. Un clic ouvre ou ferme le menu. Échap ferme le menu et replace le focus sur le bouton. Un changement de largeur réinitialise l’état. Sans JavaScript, les liens restent accessibles et le bouton reste masqué.

### 8. Vérifier sans corriger automatiquement

```sh
php artisan test
php artisan route:list --except-vendor
php artisan view:cache
php artisan view:clear
vendor/bin/pint --test
node --check public/js/navigation.js
composer validate --strict
```

Ces commandes ne réécrivent pas les sources. Laravel peut générer des caches temporaires. `pint --test` signale les problèmes de formatage ; lancer Pint sans `--test` modifierait les fichiers.

À vérifier manuellement dans le navigateur : accueil sur ordinateur et mobile, ouverture/fermeture du menu, touche Échap, navigation avec Tab, liens d’ancrage et zoom à 200 %. Les tests PHP ne vérifient pas le rendu visuel ni l’exécution du JavaScript dans un navigateur.

Documentation officielle : https://laravel.com/docs/13.x/installation


## Ajouter les informations et les photos du commerce

1. Modifier `config/business.php` : `intro` et `about` pour les paragraphes, `contact` pour les coordonnées, `hours` pour les horaires et `services` pour les prestations. Les commentaires donnent le format de chaque entrée. Remplacer les textes provisoires par les informations réelles.
2. Copier vos images JPG, PNG, WebP ou AVIF dans `public/images/business/` ou `public/images/gallery/`. Le dossier `public/images/branding/` peut recevoir votre logo ; il n’est pas encore chargé automatiquement dans la navigation.
3. Dans `hero_photo`, remplacer `null` par `['src' => 'images/business/hero.jpg', 'alt' => 'Description précise de votre photo']` en utilisant le vrai nom de fichier.
4. Dans `photos`, ajouter une entrée par photo avec `src`, `alt` et éventuellement `caption`. Le chemin commence par `images/`, sans `public/`. Ajouter une virgule entre les entrées.
5. Exécuter `php artisan config:clear` si la configuration était mise en cache, puis actualiser la page.

Les photos absentes sont ignorées pour éviter les images cassées. La galerie et son lien de navigation apparaissent dès qu’une photo configurée existe. Les informations pratiques apparaissent dès qu’au moins une coordonnée, un horaire ou une prestation est renseigné. Les images sont recadrées visuellement par `object-fit: cover` ; leurs fichiers originaux restent intacts.

## Pourquoi retirer l’authentification ?

Un site vitrine présente des informations publiques. Il n’a besoin ni de compte visiteur, ni de connexion, ni de réinitialisation de mot de passe. Le modèle User, sa factory et les migrations du squelette ont été retirés. Le seeder ne crée plus de compte de démonstration. `config/auth.php` conserve uniquement une configuration vide explicite, pour ne pas réactiver les valeurs par défaut du framework.

Le fichier SQLite local précédemment créé est conservé avec ses anciennes tables ; aucune donnée existante n’a été effacée. Il n’est plus utilisé par la page. Les fonctions internes d’authentification de Laravel restent dans `vendor/`, comme le reste du framework ; elles ne constituent pas des fonctionnalités actives du site.

`Controller.php` est simplement la classe de base commune aux contrôleurs. Elle n’impose aucune authentification. `HomeController.php` reste le point d’entrée du contenu.

`composer run setup` prépare désormais uniquement PHP et la clé de l’application. `composer run dev` lance le serveur Laravel, sans worker ni compilation JavaScript. Laravel Boost a été installé comme dépendance de développement conformément aux instructions AGENTS.md du projet.
