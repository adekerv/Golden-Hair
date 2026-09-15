# Product cards: adding photos and editing the content

Your product carousel contains 28 cards using the photos you supplied. Names and short French descriptions follow the visible product labels. Prices display “Prix sur demande” until you confirm them; handwritten prices remain visible in some original photos. You do not need to edit HTML to change the content or add more cards.

The Rosemary & Mint conditioner has separate tube and pot cards. The Gabri Cologne photo shows S1, S2 and S3 together in one card.

## 1. Put the photo in the correct folder

In VS Code, open:

```text
public/
  images/
    products/
```

Copy or drag your photo into that folder. Your current filenames have been retained, including spaces and accents; their URLs are encoded automatically. Copy the filename exactly when filling in `photo.src`. Adding a file alone does not create a card: add its data in the next steps.

You can use your own filenames instead. JPG, JPEG, PNG, WebP and AVIF are supported. Use simple lowercase names with hyphens, such as `shampoing-hydratant.jpg`. Keep the real extension: renaming a JPG to `.webp` does not convert the image. HEIC photos must be exported to a supported format.

The image folder is public. Copy only images intended for display on the website.

## 2. Edit an existing card

Open `config/business.php` and search for `'products' => [`, near the bottom of the file. Each inner array is one product card:

```php
[
    'name' => 'Nom du produit',
    'brand' => 'Nom de la marque',
    'description' => 'Une courte description et le principal usage du produit.',
    'price' => 'Prix sur demande',
    'photo' => [
        'src' => 'images/products/shampoing-hydratant.jpg',
        'alt' => 'Flacon du shampoing hydratant, marque et contenance',
    ],
],
```

| Field | What to enter |
| --- | --- |
| `name` | Product name shown as the card heading |
| `brand` | Brand name; optional |
| `description` | One or two short sentences |
| `price` | Confirmed price as text, for example `12,50 €` |
| `photo.src` | Exact filename and path, starting with `images/products/` |
| `photo.alt` | A useful description of what the photo shows |

The file on disk is `public/images/products/shampoing-hydratant.jpg`, but the config path is `images/products/shampoing-hydratant.jpg`. Do not include `public/`, an absolute computer path, or a leading slash.

## 3. Add a new product card

1. Copy your new photo into `public/images/products/`.
2. Copy one complete product array, from its opening `[` to its closing `],`.
3. Paste it inside the `products` array, after the last card and before the final closing `],` for the products list.
4. Change the name, brand, description, price, photo path and alternative text.
5. Keep the commas between entries. Inside single-quoted PHP text, write an apostrophe as `\'`, for example `'Huile d\'argan'`.
6. Save, run `php artisan config:clear` and refresh the page.

Each additional entry automatically creates another card. To remove a card, remove its complete array. To reorder cards, move their arrays. An empty products array displays a short availability message without empty carousel controls.

## 4. Check the result

```sh
php artisan config:clear
php artisan serve
```

Open the address printed by Artisan and go to “Produits”. On phones, swipe horizontally; on a keyboard, Tab to the product list and use Left/Right, Home or End. Previous/next buttons are available when the cards overflow. When all cards fit, unnecessary buttons are hidden. There is no autoplay.

You do not need to rebuild for product text or photos. If you change styles, JavaScript or Tailwind classes, run `npm run build`, or keep `npm run dev` running in another terminal while editing.

## If a photo does not appear

- Check the filename, extension and capitalization. `.jpg` and `.jpeg` are different filenames.
- Check that the file is inside `public/images/products/` and that the `src` matches it exactly.
- Run `php artisan config:clear` and refresh. If you replaced the image using the same name, a hard refresh may be needed.
- A missing or unsupported image shows “Photo à venir”; it does not break the page.
- For a temporary photo-free card, set `'photo' => null`.

Photos display inside a square area with `object-fit: contain`, so the whole product remains visible. The original file is not cropped or converted. Export reasonably sized images, rather than uploading full-resolution phone originals, to reduce download size. Photos below the hero use lazy loading.

## Shelf background

`public/images/business/Product-Shelf.jpg` appears behind the products section. Its path is set in `config/business.php`, under `products_background`. Set that value to `null` to remove the photo and keep the sand-colored background.

The fade is controlled by `.products-backdrop img` in `resources/css/app.css`: `opacity: .18` means 18% visibility. The cards stay opaque so their labels remain readable. Run `npm run build` after changing this style. The background is decorative and ignored by screen readers. If its file is missing, the section still works.

## Where the implementation lives

- Data for each card: `config/business.php`.
- Card HTML: `resources/views/partials/product-card.blade.php`.
- Product section and loop: `resources/views/sections/products.blade.php`.
- Carousel behavior: `resources/js/carousels.js`.
- Styling: `resources/css/app.css`.
- The separate `gallery.blade.php` displays general salon photos, not product cards.

Laravel reads the products array, checks the photo files, and passes the data to Blade. Blade loops over the entries and reuses the same card template. JavaScript adds carousel controls to the native scrollable list. Without JavaScript, the product content and manual scrolling remain available.
