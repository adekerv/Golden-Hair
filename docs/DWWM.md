# Golden Hair — intégration Laravel et guide DWWM

## Le projet

Site vitrine public pour GOLDEN HAIR, basé sur la maquette HTML fournie. Il présente le salon, les coiffures, les tarifs, les produits et les coordonnées. Aucun compte, aucune réservation en ligne, aucun paiement et aucune base de données ne sont nécessaires.

La maquette fournie est la référence visuelle : charbon, ivoire, or et bordeaux ; polices Cormorant Garamond et DM Sans ; grand logo ; cartes défilantes ; liste de tarifs dépliable.

## Lancer et modifier le site

Sur cette machine, les dépendances et les fichiers compilés sont prêts :

```sh
php artisan serve
```

Ouvrir `http://127.0.0.1:8000` (ou le port indiqué par Artisan).

Pour modifier les styles ou le JavaScript avec rechargement automatique, garder Artisan ouvert et lancer dans un deuxième terminal :

```sh
npm run dev
```

Sans serveur Vite actif, recompiler après une modification du CSS, du JavaScript ou des classes Tailwind dans les vues :

```sh
npm run build
```

Sur une nouvelle copie : `composer run setup`, puis `php artisan serve`. Le script installe les dépendances PHP et npm, prépare `.env` et compile les assets. Pas de migration nécessaire. Ne pas régénérer la clé d’une application déjà déployée : le script setup sert à l’initialisation.

Les fichiers `.env`, `vendor/`, `node_modules/` et `public/build/` ne sont pas versionnés. `composer.lock` et `package-lock.json` fixent les versions des dépendances. Le serveur web doit exposer uniquement `public/`.

## Où modifier quoi ?

| Fichier ou dossier | Rôle |
| --- | --- |
| `routes/web.php` | Routes publiques `home`, `legal` et `privacy`, sans session |
| `app/Http/Controllers/Controller.php` | Classe de base des contrôleurs ; aucune authentification |
| `app/Http/Controllers/HomeController.php` | Charge les informations et vérifie les fichiers photo |
| `app/Http/Controllers/InformationController.php` | Charge les pages légales et de confidentialité |
| `config/business.php` | Coordonnées, prestations, 50 tarifs, produits et photos |
| `config/legal.php` | Identité juridique, hébergement, médiation et confidentialité à compléter |
| `resources/views/layouts/app.blade.php` | Document HTML, métadonnées, polices et assets Vite |
| `resources/views/pages/home.blade.php` | Assemble les sections |
| `resources/views/partials/navigation.blade.php` | Navigation ordinateur et menu mobile |
| `resources/views/partials/price-list.blade.php` | Liste complète des tarifs |
| `resources/views/partials/footer.blade.php` | Pied de page |
| `resources/views/sections/` | Hero, coiffures, produits, galerie facultative et contact |
| `resources/css/app.css` | Thème Tailwind 4 et règles complémentaires |
| `resources/css/fonts.css` et `resources/fonts/` | Polices locales WOFF2 et leurs licences |
| `resources/js/navigation.js` | Fermeture du menu, touche Échap, gestion du focus |
| `resources/js/carousels.js` | Flèches, défilement clavier et état des boutons |
| `resources/js/app.js` | Point d’entrée JavaScript |
| `public/images/branding/` | Logo extrait du HTML fourni, sans transformation |
| `public/images/business/` | Photo principale facultative |
| `public/images/services/` | Photos des coiffures |
| `public/images/products/` | Photos des produits |
| `public/images/gallery/` | Autres photos du salon |
| `tests/Feature/LandingPageTest.php` | Tests du rendu et du contenu |

## Le fonctionnement, étape par étape

1. Le navigateur demande `/`. Laravel trouve la route dans `routes/web.php` et appelle `HomeController::index()`.
2. `config('business')` lit le tableau PHP contenant les informations du salon. Le contrôleur prépare les données pour la vue et ignore les fichiers photo absents, hors de `public/images` ou d’un format non pris en charge.
3. `view('pages.home', compact(...))` transmet les variables à la page. La notation avec un point correspond aux sous-dossiers de `resources/views`.
4. `@extends('layouts.app')` utilise le document partagé. `@section` définit le contenu et `@yield` l’insère. Les `@include` assemblent les sections.
5. `@foreach` construit les cartes et les lignes de tarifs à partir des tableaux. `@if` affiche une photo si elle existe. `@forelse` affiche les produits renseignés ou les cartes d’attente. `{{ ... }}` échappe le texte HTML pour éviter qu’une description devienne du code exécuté.
6. `@vite` charge le CSS et le JavaScript. En production, les noms de fichiers contiennent un hash : une nouvelle compilation crée une nouvelle URL, ce qui évite de garder une ancienne version en cache.
7. Tailwind génère les styles des classes présentes dans les vues. Les couleurs et les polices sont définies dans `@theme`. Les préfixes `sm:` et `lg:` adaptent la présentation à la largeur de l’écran. Les quelques règles CSS supplémentaires gèrent les carrousels, les prix et le focus clavier.
8. Les carrousels utilisent le défilement natif et le scroll snap souple. JavaScript ajoute le déplacement d’une carte avec les boutons ou les flèches du clavier quand la piste a le focus. Les boutons sont masqués si toutes les cartes sont visibles. En début/fin de piste, aria-disabled indique la limite sans retirer le focus clavier. Il n’y a pas de défilement automatique.
9. Le menu et les tarifs utilisent `<details>` et `<summary>`, utilisables sans JavaScript. JavaScript ferme le menu après un lien, un clic extérieur ou Échap et ajuste le focus.

## Ajouter les vraies informations

Modifier `config/business.php`, puis exécuter `php artisan config:clear` si nécessaire.

- `contact.phone` contient le numéro affiché. Mettre `contact.phone_confirmed` à `true` seulement après confirmation pour afficher le lien d’appel.
- `contact.address` et `contact.postal_city` contiennent l’adresse. `address_confirmed` retire la mention « à confirmer ».
- `contact.whatsapp` contient le numéro WhatsApp international confirmé. Mettre `null` pour masquer ce moyen de contact. Le site ouvre WhatsApp ; il n’envoie aucun message automatiquement.
- `contact.email` active un lien email lorsqu’il est renseigné.
- `contact.instagram` contient l’URL du profil et `contact.instagram_label` son nom affiché.
- `hours` accepte des entrées `['day' => 'Lundi', 'hours' => '09:00–17:00']`.
- `price_groups` contient tous les tarifs de la maquette. Les prix des trois cartes dans `services` sont séparés : mettre à jour les deux emplacements si un prix change.
- `prices_confirmed` contrôle la note générale des prix. Vérifier aussi le libellé « keeneez » et `locks_note`.

## Ajouter une photo

Copier votre fichier WebP, JPG, PNG ou AVIF dans le dossier approprié puis renseigner le champ `photo` de la carte :

```php
'photo' => [
    'src' => 'images/services/tresses.webp',
    'alt' => 'Description précise de la coiffure photographiée',
],
```

La bannière `public/images/business/Facebook banner updated.png` est renseignée dans `hero_photo`. Elle apparaît derrière le texte sur ordinateur, avec un dégradé pour préserver la lisibilité, et sous le texte sur mobile pour garder le visuel entier. Pour la remplacer, modifier `hero_photo`. Pour la galerie facultative, ajouter des entrées à `photos`, avec une `caption` facultative. Les chemins commencent par `images/`, sans `public/`.

Les proportions des images réservent leur espace pour réduire les déplacements de mise en page. Les photos sous l’accueil sont chargées à la demande (`loading="lazy"`). Le CSS recadre les photos de coiffures avec `object-fit: cover` ; les produits utilisent `contain` pour montrer le flacon entier. Les fichiers originaux ne sont pas modifiés.

## Ajouter un produit

Les 28 photos fournies ont maintenant leur carte dans `products`, avec un nom, une marque et une description. Les prix restent « Prix sur demande » en attendant confirmation. Modifier les valeurs ou dupliquer une entrée pour ajouter une carte :

```php
'products' => [
    [
        'name' => 'Nom réel du produit',
        'brand' => 'Marque réelle',
        'description' => 'Usage du produit',
        'price' => 'Prix confirmé',
        'photo' => [
            'src' => 'images/products/produit.webp',
            'alt' => 'Nom et présentation du produit',
        ],
    ],
],
```

Chaque entrée de products produit une carte. Une photo manquante affiche « Photo à venir », et un prix absent affiche « Prix à renseigner ». Le site présente les produits ; l’achat se fait au salon.

## Analyse de la maquette et corrections

- Les boutons des deux carrousels étaient uniquement visuels : leurs interactions sont maintenant programmées.
- Le menu mobile restait ouvert après navigation : fermeture et gestion du focus ajoutées.
- Le logo était répété trois fois en base64 : un seul fichier WebP est maintenant réutilisé et peut être mis en cache.
- Le script CDN Tailwind compilait dans le navigateur : il est remplacé par les dépendances Tailwind/Vite déjà déclarées dans le projet, avec un build local minifié.
- Les titres avaient un interligne très serré : il a été augmenté. Les prix et coordonnées peuvent revenir à la ligne ; le menu tient dans les petits écrans.
- Les textes secondaires ont un contraste plus élevé. Les zones cliquables et le focus clavier sont visibles. La préférence de réduction des animations est respectée.
- Les coordonnées fournies par le salon sont désormais confirmées : téléphone, WhatsApp, adresse, e-mail et Instagram. Les liens facultatifs sont masqués si leur valeur devient `null`.
- La piste du carrousel sert de référence aux éléments masqués pour les lecteurs d’écran (`position: relative`). Ceux-ci n’étendent plus la largeur du document. Le bandeau des prestations et les coordonnées reviennent à la ligne sur mobile.
- L’affirmation « retranscrits depuis l’affiche fournie » a été remplacée : seul le HTML a été reçu dans cette conversation, pas l’affiche originale.
- Les fichiers CSS/JS de l’ancien design et l’ancienne section d’informations ont été retirés pour garder un seul point d’entrée.

## Limites et améliorations à prévoir

Les 28 produits, leurs photos, les visuels du salon et les coordonnées fournies sont intégrés. Les horaires et les tarifs restent à confirmer. Le stock est manuel et les prix des produits restent « Prix sur demande ».

Les pages légales et de confidentialité s’appuient sur les références officielles liées dans leur contenu, mais restent incomplètes. Dans `config/legal.php`, renseigner l’identité et la forme juridique, l’immatriculation, le directeur de publication, le capital et la TVA si applicables, l’hébergeur et le médiateur auquel le salon est réellement affilié. Renseigner aussi les prestataires, les durées de conservation et les éventuels transferts. Utiliser « Non applicable » uniquement après vérification. Mettre `confirmed` à `true` seulement après avoir complété et validé la notice entière ; cela retire le message provisoire et la directive `noindex`. Mettre à jour `updated_on`.

Les deux polices sont maintenant servies localement par Vite avec `font-display: swap` et des polices de secours. Les pages publiques ne démarrent aucune session et ne déposent pas de cookie. Aucun outil de suivi ni contenu social embarqué n’est intégré. Il faut réexaminer la notice si l’hébergeur ajoute des services ou si le site évolue vers des formulaires, statistiques ou commandes.

Amélioration possible : fournir des versions WebP/AVIF plus légères des grandes photos et plusieurs tailles avec `srcset`. Les fichiers originaux sont conservés.

Aucun fichier SQLite n’est nécessaire. Le cache reste sur fichiers. Laravel Boost est un outil de développement installé selon les instructions du dépôt.

## Vérifications

```sh
php artisan test --compact
npm run build
composer validate --strict
node --check resources/js/navigation.js
node --check resources/js/carousels.js
```

Le build et les tests serveur ne remplacent pas une vérification visuelle. Vérifier dans un navigateur : largeurs 320, 375, 768 et 1440 pixels, zoom 200 %, menu et Échap, liens d’ancrage sous l’en-tête fixe, défilement tactile/clavier, ouverture de la liste des prix, et absence d’images cassées.

Références officielles : [Blade](https://laravel.com/docs/13.x/blade), [Tailwind avec Vite](https://tailwindcss.com/docs/installation/using-vite), [thème Tailwind](https://tailwindcss.com/docs/theme).


## Guide pratique des produits

Voir [PRODUCTS.md](PRODUCTS.md) pour les étapes en anglais : dossier des photos, champs à modifier, duplication d’une carte et résolution des images absentes. Le template réutilisable est `resources/views/partials/product-card.blade.php`.

Tests JavaScript sans dépendance supplémentaire : `node --test tests/Frontend/*.test.js`. Ils simulent les interactions et ne remplacent pas une vérification visuelle dans un navigateur.


## Fiches produit et disponibilité

1. Dans `config/business.php`, chaque produit possède `stock`, `details` et `size`. Le stock confirmé est actuellement `in_stock` pour les 28 produits. Passer à `out_of_stock` en cas de rupture ; `unknown` indique une disponibilité non confirmée.
2. `HomeController` transforme la valeur du stock en libellé français. Une valeur absente ou incorrecte ne devient jamais automatiquement « En stock ».
3. Blade affiche le badge et un élément HTML natif `<details>` par produit. Les champs restent échappés avec `{{ }}`.
4. `products.js` améliore le clic : il copie les informations de la carte sélectionnée dans une seule fenêtre `<dialog>`. Aucune requête réseau ni nouvelle page ne sont nécessaires.
5. `showModal()` rend la fenêtre modale et le reste de la page inactif. Le navigateur gère la navigation au clavier et Échap. À la fermeture, le code rétablit le focus sur « Voir la fiche » sans faire défiler la page.
6. Sans JavaScript, `<details>` permet toujours de consulter les informations. Le stock reste manuel : modifier la configuration, vider son cache puis actualiser la page.

Le carrousel conserve le défilement natif du navigateur. Il vise maintenant les positions exactes des cartes, mémorise la destination lors de clics rapides et limite les mises à jour visuelles avec `requestAnimationFrame`. Les annonces de position sont différées jusqu’à la fin du mouvement.
