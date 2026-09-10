<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class LandingPageTest extends TestCase
{
    public function test_homepage_renders_without_a_database_and_hides_empty_sections(): void
    {
        config([
            'database.default' => 'unavailable',
            'session.driver' => 'file',
            'cache.default' => 'file',
        ]);

        $this->get('/')
            ->assertSee('Vos cheveux.')
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
            'business.contact.email' => 'test@example.com',
            'business.hours' => [['day' => 'Lundi', 'hours' => '09:00–17:00']],
            'business.services' => [['name' => 'Prestation test', 'description' => '<script>alert(1)</script>']],
        ]);

        $this->get('/')
            ->assertSee('id="informations"', false)
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
            ->assertSee('class="brand-panel"', false)
            ->assertDontSee('id="photos"', false)
            ->assertDontSee('missing.jpg');
    }
}
