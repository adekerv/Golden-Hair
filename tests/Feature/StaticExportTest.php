<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

class StaticExportTest extends TestCase
{
    private string $temporary;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->temporary = storage_path('framework/testing/static-'.uniqid());
        File::ensureDirectoryExists($this->temporary.'/public/build');
        File::ensureDirectoryExists($this->temporary.'/public/images');
        File::put($this->temporary.'/public/build/manifest.json', '{}');
        File::put($this->temporary.'/public/build/app.js', 'export {};');
        File::put($this->temporary.'/public/images/photo.jpg', 'image-fixture');
        File::put($this->temporary.'/public/images/private.php', '<?php secret();');
        File::put($this->temporary.'/public/build/app.js.map', 'source-code');
        File::put($this->temporary.'/public/.env', 'PRIVATE=value');
        File::put($this->temporary.'/public/robots.txt', "User-agent: *\nAllow: /\n");
        $this->app->usePublicPath($this->temporary.'/public');
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->temporary);
        parent::tearDown();
    }

    public function test_export_has_portable_pages_and_only_public_assets(): void
    {
        $output = $this->temporary.'/output';
        $this->artisan('site:export', ['--output' => $output])->assertSuccessful();

        $home = File::get($output.'/static/index.html');
        $this->assertStringContainsString('Tresses plaquées avec dégradé', $home);
        $this->assertStringContainsString('href="/mentions-legales"', $home);
        $this->assertStringContainsString('href="/#coiffures"', $home);
        $this->assertStringNotContainsString('goldenhair-export.invalid', $home);
        $this->assertStringNotContainsString('http://localhost', $home);
        $this->assertStringNotContainsString('browser-logs', $home);
        foreach (['mentions-legales.html', 'confidentialite.html', '404.html', 'images/photo.jpg', 'build/app.js', 'robots.txt'] as $file) {
            $this->assertFileExists($output.'/static/'.$file);
        }
        foreach (['.env', 'images/private.php', 'build/app.js.map', 'build/manifest.json'] as $file) {
            $this->assertFileDoesNotExist($output.'/static/'.$file);
        }
        $this->assertSame(3, json_decode(File::get($output.'/config.json'), true)['version']);

        File::put($output.'/static/obsolete.html', 'Old generated content');
        $this->artisan('site:export', ['--output' => $output])->assertSuccessful();
        $this->assertFileDoesNotExist($output.'/static/obsolete.html');
    }

    public function test_export_refuses_to_replace_an_unrelated_directory(): void
    {
        $output = $this->temporary.'/unrelated';
        File::ensureDirectoryExists($output);
        File::put($output.'/keep.txt', 'Keep this file');
        $this->artisan('site:export', ['--output' => $output])->assertFailed();
        $this->assertSame('Keep this file', File::get($output.'/keep.txt'));
    }

    public function test_export_requires_production_assets(): void
    {
        File::put($this->temporary.'/public/hot', 'http://localhost:5173');
        $this->artisan('site:export', ['--output' => $this->temporary.'/output'])->assertFailed();
        $this->assertDirectoryDoesNotExist($this->temporary.'/output');
    }
}
