# Golden Hair

Site vitrine Laravel : présentation du salon, coiffures et tarifs, produits, photos et contact. Aucun compte utilisateur ni base de données nécessaire pour la page.

## Démarrage

```sh
composer run setup
php artisan serve
```

Sur une installation déjà préparée, lancer seulement `php artisan serve`.

Pour modifier le front-end, lancer `npm run dev` dans un deuxième terminal. Pour compiler la version de production : `npm run build`.

## Contenu

Modifier `config/business.php` et ajouter les photos dans `public/images/`. Les coordonnées et prix repris de la maquette restent à confirmer.

Voir [le guide DWWM](docs/DWWM.md) pour la structure, les explications du code et l’ajout de photos/produits.
