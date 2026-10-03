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

    public function test_opening_hours_are_listed_and_summarised_in_the_hero(): void
    {
        $response = $this->get('/')
            ->assertOk()
            ->assertSee('Du lundi au samedi · 8h30 – 17h00')
            ->assertDontSee('À confirmer auprès du salon');

        $hours = collect($response->viewData('business')['hours']);
        $this->assertSame(['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'], $hours->pluck('day')->all());
        $this->assertSame(['8h30 – 17h00'], $hours->take(6)->pluck('hours')->unique()->values()->all());
        $this->assertSame('Fermé', $hours->last()['hours']);
    }

    public function test_hours_fall_back_to_a_notice_when_not_configured(): void
    {
        config(['business.hours' => [], 'business.hours_summary' => null]);

        $this->get('/')->assertSee('À confirmer auprès du salon')->assertDontSee('Du lundi au samedi');
    }

    public function test_price_list_explains_prices_that_depend_on_the_amount_of_hair(): void
    {
        $this->get('/')->assertSee('le tarif dépend de la quantité de cheveux');

        config(['business.price_groups' => [['title' => 'Coupes', 'items' => [['name' => 'Coupe', 'price' => '20 €']]]]]);
        $this->get('/')->assertDontSee('le tarif dépend de la quantité de cheveux');
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

    public function test_hairstyle_gallery_groups_all_twelve_photos_into_ten_styles(): void
    {
        $response = $this->get('/')->assertOk();
        $business = $response->viewData('business');

        $this->assertCount(10, $business['services']);
        $photoCount = 0;
        foreach ($business['services'] as $service) {
            $this->assertNotNull($service['photo']);
            foreach ($service['style_photos'] as $photo) {
                $this->assertFileExists(public_path($photo['src']));
                $this->assertNotEmpty($photo['alt']);
                $photoCount++;
            }
        }
        $this->assertSame(12, $photoCount);
        $response->assertSee('Tresses plaquées avec dégradé')
            ->assertSee('Boucles bordeaux')
            ->assertSee('Microtresses, pas à pas')
            ->assertSee('Vue 2')
            ->assertSee('Consulter la liste complète des tarifs');
    }

    public function test_hairstyle_gallery_uses_a_valid_alternate_when_the_main_photo_is_missing(): void
    {
        $alternate = config('business.services.0.alternate_photos.0');
        config([
            'business.services.0.photo' => ['src' => 'images/services/missing-main.jpg'],
            'business.services.0.alternate_photos' => [
                ['src' => '../private.jpg'],
                ['src' => 'images/services/missing-alternate.jpg'],
                $alternate,
            ],
        ]);

        $response = $this->get('/')->assertOk();
        $service = $response->viewData('business')['services'][0];
        $this->assertCount(1, $service['style_photos']);
        $this->assertSame($alternate['src'], $service['photo']['src']);
        $response->assertDontSee('missing-main.jpg')
            ->assertDontSee('missing-alternate.jpg')
            ->assertDontSee('../private.jpg');
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
