<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ProductCardsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_uploaded_products_render_with_unique_photos_and_readable_details(): void
    {
        $products = config('business.products');
        $this->assertCount(28, $products);
        $this->assertCount(28, array_unique(array_column(array_column($products, 'photo'), 'src')));

        $response = $this->get('/')->assertOk()
            ->assertSee('Prix sur demande')
            ->assertSee('En stock')
            ->assertDontSee('Produit exemple')
            ->assertDontSee('Photo à venir');

        foreach ($products as $product) {
            $this->assertFileExists(public_path($product['photo']['src']));
            $this->assertNotFalse(getimagesize(public_path($product['photo']['src'])));
            $response->assertSee($product['name'])
                ->assertSee($product['brand'])
                ->assertSee($product['description'])
                ->assertSee($product['details'])
                ->assertSee($product['photo']['alt']);
            $this->assertSame('in_stock', $product['stock']);
        }

        $document = new \DOMDocument;
        @$document->loadHTML($response->getContent());
        $images = (new \DOMXPath($document))->query('//*[@id="product-track"]//img');
        $this->assertCount(28, $images);
        $xpath = new \DOMXPath($document);
        $this->assertCount(28, $xpath->query('//*[@id="product-track"]//details/summary[@data-product-open]'));
        $this->assertCount(28, $xpath->query('//*[@id="product-track"]//*[@data-stock="in_stock"]'));
        $this->assertCount(1, $xpath->query('//dialog[@aria-labelledby="product-dialog-title"]'));
        foreach ($images as $image) {
            $src = $image->getAttribute('src');
            $this->assertStringNotContainsString(' ', $src);
            $this->assertFileExists(public_path(ltrim(rawurldecode(parse_url($src, PHP_URL_PATH)), '/')));
            $this->assertSame('lazy', $image->getAttribute('loading'));
        }
    }

    public function test_shelf_photo_is_rendered_as_a_decorative_background(): void
    {
        $this->get('/')->assertOk()
            ->assertSee('class="products-backdrop" aria-hidden="true"', false)
            ->assertSee('/images/business/Product-Shelf.jpg" alt=""', false);
    }

    public function test_missing_shelf_photo_leaves_the_catalogue_usable(): void
    {
        config(['business.products_background' => ['src' => 'images/business/missing.jpg']]);

        $this->get('/')->assertOk()
            ->assertSee('id="product-track"', false)
            ->assertDontSee('class="products-backdrop"', false)
            ->assertDontSee('/images/business/missing.jpg', false);
    }

    public function test_optional_product_fields_have_readable_fallbacks(): void
    {
        config(['business.products' => [['name' => 'Mon produit']]]);

        $this->get('/')
            ->assertSee('Mon produit')
            ->assertSee('Description à renseigner.')
            ->assertSee('Prix à renseigner')
            ->assertSee('Disponibilité à confirmer')
            ->assertSee('Pour en savoir plus sur ce produit')
            ->assertSee('Photo à venir');
    }

    public function test_empty_catalogue_has_no_empty_carousel_controls(): void
    {
        config(['business.products' => []]);

        $this->get('/')
            ->assertSee('Notre sélection de produits sera bientôt disponible.')
            ->assertDontSee('id="product-track"', false)
            ->assertDontSee('<dialog', false)
            ->assertDontSee('aria-label="Produit suivant"', false);
    }

    public function test_product_text_is_escaped_in_each_editable_field(): void
    {
        config(['business.products' => [[
            'name' => '<script>name</script>',
            'brand' => '<script>brand</script>',
            'description' => '<script>description</script>',
            'price' => '<script>price</script>',
            'details' => '<script>details</script>',
            'size' => '<script>size</script>',
        ]]]);

        $response = $this->get('/');
        foreach (['name', 'brand', 'description', 'price', 'details', 'size'] as $field) {
            $response->assertSee('<script>'.$field.'</script>')
                ->assertDontSee('<script>'.$field.'</script>', false);
        }
    }

    #[DataProvider('stockStatuses')]
    public function test_each_product_displays_its_own_stock_status(mixed $stock, string $label): void
    {
        config(['business.products' => [[
            'name' => 'Produit test',
            'stock' => $stock,
            'details' => 'Informations complémentaires sur ce produit.',
            'size' => '250 ml',
        ]]]);

        $this->get('/')->assertOk()
            ->assertSee($label)
            ->assertSee('Informations complémentaires sur ce produit.')
            ->assertSee('250 ml')
            ->assertSee('data-product-open', false);
    }

    public static function stockStatuses(): array
    {
        return [
            'available' => ['in_stock', 'En stock'],
            'unavailable' => ['out_of_stock', 'Rupture de stock'],
            'unconfirmed' => ['unknown', 'Disponibilité à confirmer'],
            'missing' => [null, 'Disponibilité à confirmer'],
            'typo' => ['in-stok', 'Disponibilité à confirmer'],
            'wrong type' => [true, 'Disponibilité à confirmer'],
        ];
    }

    #[DataProvider('invalidPhotos')]
    public function test_invalid_photo_configuration_falls_back_instead_of_crashing(mixed $photo): void
    {
        config(['business.products' => [['name' => 'Produit test', 'photo' => $photo]]]);

        $this->get('/')->assertSee('Produit test')->assertSee('Photo à venir');
    }

    public static function invalidPhotos(): array
    {
        return [
            'string instead of array' => ['images/products/photo.webp'],
            'missing path' => [['alt' => 'Photo']],
            'path with wrong type' => [['src' => []]],
            'external source' => [['src' => 'https://example.com/photo.webp']],
        ];
    }

    public function test_real_product_photo_loads_and_uses_product_name_when_alt_is_missing(): void
    {
        $public = storage_path('framework/testing/products-'.uniqid());
        File::makeDirectory($public.'/images/products', 0755, true);
        File::put($public.'/images/products/shampoo.png', base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+aWQAAAABJRU5ErkJggg=='
        ));
        $this->app->usePublicPath($public);
        config(['business.products' => [[
            'name' => 'Shampoing test',
            'price' => '12,50 €',
            'photo' => ['src' => 'images/products/shampoo.png'],
        ]]]);

        try {
            $this->get('/')
                ->assertSee('/images/products/shampoo.png', false)
                ->assertSee('alt="Shampoing test"', false)
                ->assertSee('12,50 €')
                ->assertSee('loading="lazy"', false)
                ->assertDontSee('Photo à venir');
        } finally {
            File::deleteDirectory($public);
        }
    }
}
