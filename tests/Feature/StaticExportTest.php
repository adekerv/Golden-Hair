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

        $home = File::get($output.'/index.html');
        $this->assertStringContainsString('Tresses plaquées avec dégradé', $home);
        $this->assertStringContainsString('href="/mentions-legales"', $home);
        $this->assertStringContainsString('href="/#coiffures"', $home);
        $this->assertStringNotContainsString('goldenhair-export.invalid', $home);
        $this->assertStringNotContainsString('http://localhost', $home);
        $this->assertStringNotContainsString('browser-logs', $home);
        foreach (['mentions-legales.html', 'confidentialite.html', '404.html', 'images/photo.jpg', 'build/app.js', 'robots.txt'] as $file) {
            $this->assertFileExists($output.'/'.$file);
        }
        foreach (['.env', 'images/private.php', 'build/app.js.map', 'build/manifest.json'] as $file) {
            $this->assertFileDoesNotExist($output.'/'.$file);
        }

        File::put($output.'/obsolete.html', 'Old generated content');
        $this->artisan('site:export', ['--output' => $output])->assertSuccessful();
        $this->assertFileDoesNotExist($output.'/obsolete.html');
    }

    public function test_vercel_serves_the_default_export_directory_without_a_build(): void
    {
        $config = json_decode(File::get(base_path('vercel.json')), true, flags: JSON_THROW_ON_ERROR);

        $this->assertSame('dist', $config['outputDirectory']);
        $this->assertTrue($config['cleanUrls']);
        $this->assertNull($config['framework']);
        $this->assertStringStartsWith('echo ', $config['buildCommand']);
        $this->assertStringStartsWith('echo ', $config['installCommand']);
    }

    public function test_tailwind_only_scans_views_and_scripts_so_builds_do_not_depend_on_the_export(): void
    {
        $css = File::get(resource_path('css/app.css'));

        $this->assertStringContainsString("@import 'tailwindcss' source(none);", $css);
        $this->assertStringContainsString("@source '../views/**/*.blade.php';", $css);
        $this->assertStringContainsString("@source '../js/**/*.js';", $css);
    }

    public function test_check_passes_for_a_current_export_and_never_writes(): void
    {
        $output = $this->temporary.'/output';
        $this->artisan('site:export', ['--output' => $output])->assertSuccessful();
        $before = File::get($output.'/index.html');

        $this->artisan('site:export', ['--output' => $output, '--check' => true])
            ->expectsOutputToContain('up to date')
            ->assertSuccessful();

        $this->assertSame($before, File::get($output.'/index.html'));
        $this->assertSame([], glob(storage_path('framework/cache/static-export-*')));
    }

    public function test_check_reports_changed_missing_and_obsolete_files_without_touching_them(): void
    {
        $output = $this->temporary.'/output';
        $this->artisan('site:export', ['--output' => $output])->assertSuccessful();
        File::put($output.'/index.html', 'tampered');
        File::delete($output.'/robots.txt');
        File::put($output.'/obsolete.html', 'old');

        $this->artisan('site:export', ['--output' => $output, '--check' => true])
            ->expectsOutputToContain('out of date')
            ->expectsOutputToContain('changed: index.html')
            ->expectsOutputToContain('missing: robots.txt')
            ->expectsOutputToContain('obsolete: obsolete.html')
            ->assertFailed();

        $this->assertSame('tampered', File::get($output.'/index.html'));
        $this->assertFileDoesNotExist($output.'/robots.txt');
        $this->assertFileExists($output.'/obsolete.html');
        $this->assertSame([], glob(storage_path('framework/cache/static-export-*')));
    }

    public function test_check_detects_a_changed_public_asset(): void
    {
        $output = $this->temporary.'/output';
        $this->artisan('site:export', ['--output' => $output])->assertSuccessful();
        File::put($this->temporary.'/public/images/photo.jpg', 'replacement-image');

        $this->artisan('site:export', ['--output' => $output, '--check' => true])
            ->expectsOutputToContain('changed: images/photo.jpg')
            ->assertFailed();
    }

    public function test_check_fails_when_there_is_no_export_yet(): void
    {
        $this->artisan('site:export', ['--output' => $this->temporary.'/missing', '--check' => true])->assertFailed();

        $this->assertDirectoryDoesNotExist($this->temporary.'/missing');
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
