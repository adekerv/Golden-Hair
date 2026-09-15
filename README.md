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

Modifier `config/business.php` et ajouter les photos dans `public/images/`. Les coordonnées ont été mises à jour avec les informations du salon. Les horaires et tarifs restent à confirmer.

Les pages `/mentions-legales` et `/confidentialite` sont accessibles depuis le pied de page. Compléter `config/legal.php` avec l’identité de l’exploitant, l’hébergeur, le médiateur et les informations de conservation/transfert des données. Les informations manquantes sont signalées ; ces notices restent à finaliser avant publication.

Voir [le guide DWWM](docs/DWWM.md) pour la structure, les explications du code et l’ajout de photos/produits.

Pour ajouter vos photos et modifier les cartes produits, suivez [le guide des produits](docs/PRODUCTS.md).
