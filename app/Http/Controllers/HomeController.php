<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $business = config('business');
        $photos = array_values(array_filter($business['photos'], $this->photoExists(...)));
        $heroPhoto = $this->photoExists($business['hero_photo']) ? $business['hero_photo'] : null;
        foreach (['services', 'products'] as $group) {
            foreach ($business[$group] as &$item) {
                $item['photo'] = $this->photoExists($item['photo'] ?? null) ? $item['photo'] : null;
            }
            unset($item);
        }

        return view('pages.home', compact('business', 'photos', 'heroPhoto'));
    }

    /**
     * @param  array{src: string, alt: string, caption?: string}|null  $photo
     */
    private function photoExists(?array $photo): bool
    {
        if (! $photo || empty($photo['src'])) {
            return false;
        }

        $imageRoot = realpath(public_path('images'));
        $path = realpath(public_path($photo['src']));

        return $imageRoot !== false
            && $path !== false
            && str_starts_with($path, $imageRoot.DIRECTORY_SEPARATOR)
            && is_file($path)
            && in_array(strtolower(pathinfo($path, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'webp', 'avif'], true);
    }
}
