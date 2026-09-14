# Product cards: adding photos and editing the content

Your product carousel contains four example cards. They are examples, not real products or prices. You do not need to edit HTML to replace them or add more cards.

## 1. Put the photo in the correct folder

In VS Code, open:

```text
public/
  images/
    products/
```

Copy or drag your photo into that folder. For the first example, the configured filename is `produit-01.webp`. The other examples use `produit-02.webp`, `produit-03.webp`, and `produit-04.webp`.

You can use your own filenames instead. JPG, JPEG, PNG, WebP and AVIF are supported. Use simple lowercase names with hyphens, such as `shampoing-hydratant.jpg`. Keep the real extension: renaming a JPG to `.webp` does not convert the image. HEIC photos must be exported to a supported format.

The image folder is public. Copy only images intended for display on the website.

## 2. Edit an existing card

Open `config/business.php` and search for `'products' => [`, near the bottom of the file. Each inner array is one product card:

```php
[
    'name' => 'Nom du produit',
    'brand' => 'Nom de la marque',
    'description' => 'Une courte description et le principal usage du produit.',
    'price' => 'Prix à renseigner',
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

A fifth entry automatically creates a fifth card. To remove a card, remove its complete array. To reorder cards, move their arrays. An empty products array displays a short availability message without empty carousel controls.

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

## Where the implementation lives

- Data for each card: `config/business.php`.
- Card HTML: `resources/views/partials/product-card.blade.php`.
- Product section and loop: `resources/views/sections/products.blade.php`.
- Carousel behavior: `resources/js/carousels.js`.
- Styling: `resources/css/app.css`.
- The separate `gallery.blade.php` displays general salon photos, not product cards.

Laravel reads the products array, checks the photo files, and passes the data to Blade. Blade loops over the entries and reuses the same card template. JavaScript adds carousel controls to the native scrollable list. Without JavaScript, the product content and manual scrolling remain available.
