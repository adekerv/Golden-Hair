<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $business = config('business');
        $photos = array_values(array_filter(array_map(
            fn (mixed $photo): ?array => $this->preparePhoto($photo, 'Photo du salon '.$business['name']),
            $business['photos'],
        )));
        $heroPhoto = $this->preparePhoto($business['hero_photo'], 'Le salon '.$business['name']);
        $productsBackground = $this->preparePhoto($business['products_background'] ?? null, '');
        foreach (['services', 'products'] as $group) {
            foreach ($business[$group] as &$item) {
                $item['photo'] = $this->preparePhoto($item['photo'] ?? null, $item['name'] ?? 'Photo du produit');
                if ($group === 'products') {
                    $item['availability'] = match ($item['stock'] ?? null) {
                        'in_stock' => ['status' => 'in_stock', 'label' => 'En stock'],
                        'out_of_stock' => ['status' => 'out_of_stock', 'label' => 'Rupture de stock'],
                        default => ['status' => 'unknown', 'label' => 'Disponibilité à confirmer'],
                    };
                }
            }
            unset($item);
        }

        return view('pages.home', compact('business', 'photos', 'heroPhoto', 'productsBackground'));
    }

    /**
     * @return array{src: string, url: string, alt: string, caption?: string}|null
     */
    private function preparePhoto(mixed $photo, string $fallbackAlt): ?array
    {
        if (! is_array($photo) || ! is_string($photo['src'] ?? null) || ! str_starts_with($photo['src'], 'images/')) {
            return null;
        }

        $imageRoot = realpath(public_path('images'));
        $path = realpath(public_path($photo['src']));

        $exists = $imageRoot !== false
            && $path !== false
            && str_starts_with($path, $imageRoot.DIRECTORY_SEPARATOR)
            && is_file($path)
            && in_array(strtolower(pathinfo($path, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'webp', 'avif'], true);

        if (! $exists) {
            return null;
        }

        $photo['alt'] = is_string($photo['alt'] ?? null) && trim($photo['alt']) !== ''
            ? $photo['alt'] : $fallbackAlt;
        $photo['url'] = asset(implode('/', array_map('rawurlencode', explode('/', $photo['src']))));

        return $photo;
    }
}
