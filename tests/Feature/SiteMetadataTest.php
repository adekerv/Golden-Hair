<?php

namespace Tests\Feature;

use Tests\TestCase;

class SiteMetadataTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_pages_declare_color_scheme_and_theme_support_without_a_site_url(): void
    {
        config(['business.site_url' => null]);

        $this->get('/')
            ->assertOk()
            ->assertSee('<meta name="color-scheme" content="light dark">', false)
            ->assertSee('<meta name="theme-color" content="#18201d">', false)
            ->assertSee("localStorage.getItem('theme')", false)
            ->assertSee('<meta property="og:title" content="GOLDEN HAIR — Coiffure • Barber au Lamentin">', false)
            ->assertSee('<meta name="twitter:card" content="summary">', false)
            ->assertDontSee('rel="canonical"', false)
            ->assertDontSee('og:image', false);
    }

    public function test_theme_toggle_is_hidden_until_javascript_enables_it(): void
    {
        $html = $this->get('/')->getContent();

        $this->assertSame(2, substr_count($html, 'data-theme-toggle hidden'));
        $this->assertStringContainsString('aria-pressed="false"', $html);
    }

    public function test_configured_site_url_adds_canonical_and_share_image(): void
    {
        config(['business.site_url' => 'https://golden.test/']);

        $this->get('/')
            ->assertSee('<link rel="canonical" href="https://golden.test/">', false)
            ->assertSee('<meta property="og:url" content="https://golden.test/">', false)
            ->assertSee('<meta property="og:image" content="https://golden.test/images/branding/og-image.jpg">', false)
            ->assertSee('<meta name="twitter:card" content="summary_large_image">', false);
    }

    public function test_canonical_is_only_emitted_for_indexable_pages(): void
    {
        config(['business.site_url' => 'https://golden.test', 'legal.confirmed' => false]);
        $this->get('/mentions-legales')->assertSee('noindex', false)->assertDontSee('rel="canonical"', false);
        $this->get('/does-not-exist')->assertNotFound()->assertDontSee('rel="canonical"', false);

        config(['legal.confirmed' => true]);
        $this->get('/mentions-legales')->assertSee('<link rel="canonical" href="https://golden.test/mentions-legales">', false);
        $this->get('/confidentialite')->assertSee('<link rel="canonical" href="https://golden.test/confidentialite">', false);
    }

    public function test_titles_and_descriptions_are_escaped_exactly_once(): void
    {
        config(['business.name' => 'Cheveux & Co', 'business.description' => 'Coupes "chic" & soins']);

        $this->get('/')
            ->assertSee('<meta property="og:site_name" content="Cheveux &amp; Co">', false)
            ->assertSee('<meta name="description" content="Coupes &quot;chic&quot; &amp; soins">', false)
            ->assertDontSee('&amp;amp;', false);
    }

    public function test_structured_data_describes_the_salon_with_confirmed_details_only(): void
    {
        config([
            'business.site_url' => 'https://golden.test',
            'business.contact.address_confirmed' => true,
            'business.contact.phone_confirmed' => false,
        ]);

        $data = $this->structuredData($this->get('/')->getContent());

        $this->assertSame('HairSalon', $data['@type']);
        $this->assertSame('22 Place Emile Berlan', $data['address']['streetAddress']);
        $this->assertSame('97232', $data['address']['postalCode']);
        $this->assertSame('Le Lamentin', $data['address']['addressLocality']);
        $this->assertSame('https://golden.test/images/branding/og-image.jpg', $data['image']);
        $this->assertArrayNotHasKey('telephone', $data);

        config(['business.contact.phone_confirmed' => true]);
        $this->assertSame('+596 696 97 64 78', $this->structuredData($this->get('/')->getContent())['telephone']);

        config(['business.contact.address_confirmed' => false]);
        $this->assertArrayNotHasKey('address', $this->structuredData($this->get('/')->getContent()));
    }

    public function test_structured_data_groups_opening_hours_by_schedule(): void
    {
        $data = $this->structuredData($this->get('/')->getContent());

        $this->assertSame([[
            '@type' => 'OpeningHoursSpecification',
            'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
            'opens' => '08:30',
            'closes' => '17:00',
        ]], $data['openingHoursSpecification']);

        config(['business.hours' => [
            ['day' => 'Lundi', 'hours' => '9h – 12h', 'schema_day' => 'Monday', 'opens' => '09:00', 'closes' => '12:00'],
            ['day' => 'Mardi', 'hours' => '9h – 17h', 'schema_day' => 'Tuesday', 'opens' => '09:00', 'closes' => '17:00'],
            ['day' => 'Mercredi', 'hours' => '9h – 12h', 'schema_day' => 'Wednesday', 'opens' => '09:00', 'closes' => '12:00'],
            ['day' => 'Dimanche', 'hours' => 'Fermé'],
        ]]);
        $specifications = $this->structuredData($this->get('/')->getContent())['openingHoursSpecification'];

        $this->assertSame(['Monday', 'Wednesday'], $specifications[0]['dayOfWeek']);
        $this->assertSame(['Tuesday'], $specifications[1]['dayOfWeek']);

        config(['business.hours' => []]);
        $this->assertArrayNotHasKey('openingHoursSpecification', $this->structuredData($this->get('/')->getContent()));
    }

    public function test_structured_data_cannot_close_its_script_element(): void
    {
        config(['business.description' => '</script><img src=x onerror=alert(1)>']);

        $html = $this->get('/')->getContent();

        $this->assertStringNotContainsString('</script><img', $html);
        $this->assertSame('</script><img src=x onerror=alert(1)>', $this->structuredData($html)['description']);
    }

    public function test_icons_and_share_image_exist(): void
    {
        foreach ([config('business.share_image'), config('business.logo'), 'images/branding/apple-touch-icon.png', 'images/branding/favicon-32.png'] as $file) {
            $this->assertFileExists(public_path($file));
        }
        $this->assertSame([1200, 630], array_slice(getimagesize(public_path(config('business.share_image'))), 0, 2));
    }

    public function test_configured_images_stay_light_enough_for_mobile(): void
    {
        $business = config('business');
        $files = [$business['hero_photo']['src'], $business['products_background']['src'], $business['share_image']];
        foreach (['services', 'products'] as $group) {
            foreach ($business[$group] as $item) {
                $files[] = $item['photo']['src'];
                foreach ($item['alternate_photos'] ?? [] as $photo) {
                    $files[] = $photo['src'];
                }
            }
        }

        foreach ($files as $file) {
            $this->assertLessThanOrEqual(400 * 1024, filesize(public_path($file)), $file.' should be compressed below 400 KB');
        }
    }

    public function test_public_copy_has_no_internal_drafting_notes(): void
    {
        $this->get('/')->assertDontSee('maquette');
        $this->get('/confidentialite')->assertSee('stockage local');
    }

    /**
     * @return array<string, mixed>
     */
    private function structuredData(string $html): array
    {
        $this->assertSame(1, preg_match('#<script type="application/ld\+json">(.*?)</script>#s', $html, $matches));

        return json_decode($matches[1], true, flags: JSON_THROW_ON_ERROR);
    }
}
