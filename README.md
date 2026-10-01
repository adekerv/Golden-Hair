# Golden Hair

> A modern, fast showcase website for **Golden Hair** — hair salon & barbershop in Le Lamentin, Martinique.

[![Laravel 13](https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![PHP 8.3](https://img.shields.io/badge/PHP-8.3-777BB4?logo=php&logoColor=white)](https://www.php.net)
[![Tailwind CSS 4](https://img.shields.io/badge/Tailwind_CSS-4-38BDF8?logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![Vite 8](https://img.shields.io/badge/Vite-8-646CFF?logo=vite&logoColor=white)](https://vite.dev)

## Overview

Golden Hair is a single-page Laravel application presenting the salon's services, hairstyles, product catalog, photo gallery, prices and contact information. All content is driven by configuration files — no database or user accounts required.

## Features

- **Landing page** — hero, services, gallery and contact sections
- **Product catalog** — 28 product cards with detail dialogs
- **Price list** — full salon pricing grouped by category
- **Legal pages** — `/mentions-legales` and `/confidentialite`
- **Config-driven content** — update texts, prices and photos without touching code
- **Responsive design** built with Tailwind CSS 4
- **Tested** — PHP feature tests and JavaScript unit tests

## Tech stack

| Layer      | Technology                         |
|------------|------------------------------------|
| Backend    | Laravel 13 · PHP 8.3+              |
| Frontend   | Blade · Tailwind CSS 4 · Vite 8    |
| Testing    | PHPUnit 12 · JavaScript unit tests |
| Code style | Laravel Pint                       |

## Getting started

### Prerequisites

- PHP 8.3+
- Composer
- Node.js & npm

### Installation

```sh
composer run setup
```

This installs PHP and JavaScript dependencies, copies `.env`, generates the application key and builds the frontend assets.

### Run locally

```sh
php artisan serve
```

For frontend development, start the Vite dev server in a second terminal:

```sh
npm run dev
```

### Production build

```sh
npm run build
```

## Testing

```sh
php artisan test
```

JavaScript unit tests live in `tests/Frontend/`.

## Project structure

```
app/Http/Controllers   # Page controllers
config/business.php    # Salon info, services, prices, products
config/legal.php       # Legal notice content
resources/views        # Blade templates (layouts, pages, sections, partials)
routes/web.php         # Routes (home + legal pages)
tests/Feature          # PHP feature tests
tests/Frontend         # JavaScript unit tests
docs/                  # DWWM documentation
```

## Customizing content

Everything visible on the site is configured in `config/business.php`: salon name, tagline, contact details, opening hours, services, price groups and product catalog entries. Photos go in `public/images/`. Legal notices are configured in `config/legal.php` and rendered at `/mentions-legales` and `/confidentialite`.

## Documentation

- [DWWM guide](docs/DWWM.md) — project structure, code walkthrough, adding photos & products
- [Dossier Professionnel](docs/DOSSIER_PROFESSIONNEL_GOLDEN_HAIR.md) — internship report (French)

## License

MIT
