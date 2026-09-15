<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class LandingPageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_homepage_renders_without_a_database_and_hides_empty_sections(): void
    {
        config([
            'database.default' => 'unavailable',
            'session.driver' => 'file',
            'cache.default' => 'file',
        ]);

        $this->get('/')
            ->assertSee('La beauté,')
            ->assertSee('à votre image.')
            ->assertSee('Découvrir nos prestations')
            ->assertSee('Consulter la liste complète des tarifs')
            ->assertDontSee('id="photos"', false)
            ->assertDontSee('id="informations"', false);
    }

    #[DataProvider('authenticationPaths')]
    public function test_authentication_pages_are_not_available(string $path): void
    {
        $this->get($path)->assertNotFound();
    }

    public static function authenticationPaths(): array
    {
        return [['/login'], ['/register'], ['/forgot-password'], ['/reset-password/example']];
    }

    public function test_configured_business_details_render_with_contact_links(): void
    {
        config([
            'business.contact.address' => 'Adresse de démonstration',
            'business.contact.phone' => '+596 696 00 00 00',
            'business.contact.phone_confirmed' => true,
            'business.contact.email' => 'test@example.com',
            'business.hours' => [['day' => 'Lundi', 'hours' => '09:00–17:00']],
            'business.services.0.name' => 'Prestation test',
            'business.services.0.description' => '<script>alert(1)</script>',
        ]);

        $this->get('/')
            ->assertSee('id="contact"', false)
            ->assertSee('Adresse de démonstration')
            ->assertSee('href="tel:+596696000000"', false)
            ->assertSee('href="mailto:test@example.com"', false)
            ->assertSee('09:00–17:00')
            ->assertSee('Prestation test')
            ->assertSee('<script>alert(1)</script>')
            ->assertDontSee('<script>alert(1)</script>', false);
    }

    public function test_photos_render_with_alt_text_and_missing_files_are_omitted(): void
    {
        $public = storage_path('framework/testing/landing-'.uniqid());
        File::makeDirectory($public.'/images/gallery', 0755, true);
        File::put($public.'/images/gallery/sample.png', base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+aWQAAAABJRU5ErkJggg=='
        ));
        $this->app->usePublicPath($public);
        config([
            'business.hero_photo' => ['src' => 'images/gallery/sample.png', 'alt' => 'Photo principale test'],
            'business.photos' => [
                ['src' => 'images/gallery/sample.png', 'alt' => 'Photo galerie test', 'caption' => 'Légende test'],
                ['src' => 'images/gallery/missing.jpg', 'alt' => 'Photo manquante'],
                ['src' => '../private.jpg', 'alt' => 'Photo hors dossier'],
            ],
        ]);

        try {
            $this->get('/')
                ->assertSee('id="photos"', false)
                ->assertSee('alt="Photo principale test"', false)
                ->assertSee('alt="Photo galerie test"', false)
                ->assertSee('loading="lazy"', false)
                ->assertSee('Légende test')
                ->assertDontSee('missing.jpg')
                ->assertDontSee('../private.jpg');
        } finally {
            File::deleteDirectory($public);
        }
    }

    public function test_missing_photos_hide_gallery_and_keep_brand_panel(): void
    {
        config([
            'business.hero_photo' => ['src' => 'images/business/missing.jpg', 'alt' => 'Missing hero'],
            'business.photos' => [['src' => 'images/gallery/missing.jpg', 'alt' => 'Missing photo']],
        ]);

        $this->get('/')
            ->assertSee('alt="Logo Golden Hair, Haute Coiffure, Coiffure Mixte"', false)
            ->assertDontSee('id="photos"', false)
            ->assertDontSee('missing.jpg');
    }

    public function test_unconfirmed_phone_number_has_no_call_link(): void
    {
        config([
            'business.contact.phone' => '0596 97 64 78',
            'business.contact.phone_confirmed' => false,
            'business.contact.whatsapp' => null,
            'business.contact.email' => null,
        ]);

        $this->get('/')
            ->assertSee('0596 97 64 78')
            ->assertSee('Le numéro de téléphone est en cours de confirmation.')
            ->assertDontSee('href="tel:', false)
            ->assertDontSee('href="https://wa.me/', false)
            ->assertDontSee('href="mailto:', false);
    }

    public function test_all_supplied_price_groups_are_rendered(): void
    {
        $this->get('/')
            ->assertSee('Coiffures & coupes')
            ->assertSee('Soins & techniques')
            ->assertSee('Micro locks avec mèches')
            ->assertSee('Dès 600 €')
            ->assertSee('Shampoing + Crème + Séchage');
    }

    public function test_configured_products_replace_placeholder_cards(): void
    {
        config(['business.products' => [[
            'name' => 'Soin test',
            'brand' => 'Marque test',
            'description' => 'Description test',
            'price' => '15 €',
            'photo' => ['src' => 'images/products/missing.webp', 'alt' => 'Missing product'],
        ]]]);

        $this->get('/')
            ->assertSee('Soin test')
            ->assertSee('Marque test')
            ->assertSee('15 €')
            ->assertDontSee('Bientôt au catalogue')
            ->assertDontSee('missing.webp');
    }
}
