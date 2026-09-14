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

    public function test_example_cards_show_editable_fields_without_broken_images(): void
    {
        $this->get('/')
            ->assertSee('Produit exemple 01')
            ->assertSee('Produit exemple 04')
            ->assertSee('Marque à renseigner')
            ->assertSee('Prix à renseigner')
            ->assertSee('Ajoutez ici une courte description')
            ->assertSee('Photo à venir')
            ->assertDontSee('src="http://localhost/images/products/produit-01.webp"', false);
    }

    public function test_optional_product_fields_have_readable_fallbacks(): void
    {
        config(['business.products' => [['name' => 'Mon produit']]]);

        $this->get('/')
            ->assertSee('Mon produit')
            ->assertSee('Description à renseigner.')
            ->assertSee('Prix à renseigner')
            ->assertSee('Photo à venir');
    }

    public function test_empty_catalogue_has_no_empty_carousel_controls(): void
    {
        config(['business.products' => []]);

        $this->get('/')
            ->assertSee('Notre sélection de produits sera bientôt disponible.')
            ->assertDontSee('id="product-track"', false)
            ->assertDontSee('aria-label="Produit suivant"', false);
    }

    public function test_product_text_is_escaped_in_each_editable_field(): void
    {
        config(['business.products' => [[
            'name' => '<script>name</script>',
            'brand' => '<script>brand</script>',
            'description' => '<script>description</script>',
            'price' => '<script>price</script>',
        ]]]);

        $response = $this->get('/');
        foreach (['name', 'brand', 'description', 'price'] as $field) {
            $response->assertSee('<script>'.$field.'</script>')
                ->assertDontSee('<script>'.$field.'</script>', false);
        }
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
