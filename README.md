# Golden Hair

> Une landing page moderne et rapide pour **Golden Hair** — salon de coiffure & barber au Lamentin, Martinique.

[![Laravel 13](https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![PHP 8.3](https://img.shields.io/badge/PHP-8.3-777BB4?logo=php&logoColor=white)](https://www.php.net)
[![Tailwind CSS 4](https://img.shields.io/badge/Tailwind_CSS-4-38BDF8?logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![Vite 8](https://img.shields.io/badge/Vite-8-646CFF?logo=vite&logoColor=white)](https://vite.dev)

## Aperçu

Golden Hair est une landing page pour un salon de coiffure, présentant les prestations du salon, les coiffures, le catalogue de produits, la galerie photo, les tarifs et les coordonnées. Tout le contenu est piloté par des fichiers de configuration — sans base de données ni comptes utilisateurs.

## Fonctionnalités

- **Landing page** — sections hero, prestations, galerie et contact
- **Catalogue de produits** — 28 fiches produits avec fenêtres de détail
- **Grille tarifaire** — tous les tarifs du salon, regroupés par catégorie
- **Pages légales** — `/mentions-legales` et `/confidentialite`
- **Contenu piloté par configuration** — modifiez textes, tarifs et photos sans toucher au code
- **Design responsive** construit avec Tailwind CSS 4
- **Testé** — tests fonctionnels PHP et tests unitaires JavaScript

## Stack technique

| Couche        | Technologie                         |
|---------------|-------------------------------------|
| Backend       | Laravel 13 · PHP 8.3+               |
| Frontend      | Blade · Tailwind CSS 4 · Vite 8     |
| Tests         | PHPUnit 12 · tests unitaires JS     |
| Style de code | Laravel Pint                        |

## Démarrage

### Prérequis

- PHP 8.3+
- Composer
- Node.js & npm

### Installation

```sh
composer run setup
```

Cette commande installe les dépendances PHP et JavaScript, copie le fichier `.env`, génère la clé d'application et compile les assets du frontend.

### Lancer en local

```sh
php artisan serve
```

Pour le développement frontend, lancez le serveur de développement Vite dans un second terminal :

```sh
npm run dev
```

### Build de production

```sh
npm run build
```

## Tests

```sh
php artisan test
```

Les tests unitaires JavaScript se trouvent dans `tests/Frontend/`.

## Structure du projet

```
app/Http/Controllers   # Contrôleurs des pages
config/business.php    # Infos du salon, prestations, tarifs, produits
config/legal.php       # Contenu des mentions légales
resources/views        # Templates Blade (layouts, pages, sections, partials)
routes/web.php         # Routes (accueil + pages légales)
tests/Feature          # Tests fonctionnels PHP
tests/Frontend         # Tests unitaires JavaScript
docs/                  # Documentation DWWM
```

## Personnaliser le contenu

Tout ce qui est visible sur le site est configuré dans `config/business.php` : nom du salon, slogan, coordonnées, horaires d'ouverture, prestations, grilles tarifaires et catalogue de produits. Les photos vont dans `public/images/`. Les mentions légales sont configurées dans `config/legal.php` et affichées sur `/mentions-legales` et `/confidentialite`.

## Documentation

- [Guide DWWM](docs/DWWM.md) — structure du projet, explication du code, ajout de photos & produits
- [Dossier Professionnel](docs/DOSSIER_PROFESSIONNEL_GOLDEN_HAIR.md) — rapport de stage (français)
