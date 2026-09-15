<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class LegalPagesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    #[DataProvider('publicPages')]
    public function test_public_pages_work_without_sessions_or_tracking(string $routeName): void
    {
        config(['session.driver' => 'unavailable', 'database.default' => 'unavailable']);

        $this->get(route($routeName))
            ->assertOk()
            ->assertHeaderMissing('Set-Cookie')
            ->assertDontSee('fonts.googleapis.com')
            ->assertDontSee('fonts.gstatic.com')
            ->assertSee('href="'.route('legal').'"', false)
            ->assertSee('href="'.route('privacy').'"', false)
            ->assertSee('href="'.route('home').'#produits"', false);
    }

    /**
     * @return array<string, array{string}>
     */
    public static function publicPages(): array
    {
        return ['home' => ['home'], 'legal' => ['legal'], 'privacy' => ['privacy']];
    }

    #[DataProvider('informationPages')]
    public function test_incomplete_notices_are_identified_as_drafts(string $routeName): void
    {
        config(['legal.confirmed' => false, 'legal.editor.legal_name' => null]);

        $this->get(route($routeName))
            ->assertSee('Non renseigné')
            ->assertSee('avant publication définitive')
            ->assertSee('<meta name="robots" content="noindex, follow">', false);
    }

    #[DataProvider('informationPages')]
    public function test_completed_notices_render_configured_identity_as_text(string $routeName): void
    {
        config([
            'legal.confirmed' => true,
            'legal.editor.legal_name' => 'Exploitant <script>alert(1)</script>',
        ]);

        $this->get(route($routeName))
            ->assertSee('Exploitant <script>alert(1)</script>')
            ->assertDontSee('<script>alert(1)</script>', false)
            ->assertDontSee('name="robots"', false)
            ->assertDontSee('avant publication définitive');
    }

    /**
     * @return array<string, array{string}>
     */
    public static function informationPages(): array
    {
        return ['legal' => ['legal'], 'privacy' => ['privacy']];
    }

    public function test_homepage_uses_the_confirmed_contact_details(): void
    {
        $this->get(route('home'))
            ->assertSee('Coiffure • Barber')
            ->assertSee('22 Place Emile Berlan')
            ->assertSee('97232 LE LAMENTIN, Martinique')
            ->assertSee('href="tel:+596696976478"', false)
            ->assertSee('href="https://wa.me/596696180834"', false)
            ->assertSee('href="mailto:goldenhair.martinique@gmail.com"', false)
            ->assertSee('href="https://www.instagram.com/goldenhair.martinique/"', false)
            ->assertDontSee('Le numéro de téléphone est en cours de confirmation.');
    }
}
