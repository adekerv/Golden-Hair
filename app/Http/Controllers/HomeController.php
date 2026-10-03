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
                if ($group === 'services') {
                    $alternatePhotos = array_map(
                        fn (mixed $photo): ?array => $this->preparePhoto($photo, $item['name']),
                        $item['alternate_photos'] ?? [],
                    );
                    $item['style_photos'] = array_values(array_filter([$item['photo'], ...$alternatePhotos]));
                    $item['photo'] = $item['style_photos'][0] ?? null;
                }
                if ($group === 'products') {
                    $item['category'] = array_key_exists($item['category'] ?? '', $business['product_categories'] ?? []) ? $item['category'] : null;
                    $item['availability'] = match ($item['stock'] ?? null) {
                        'in_stock' => ['status' => 'in_stock', 'label' => 'En stock'],
                        'out_of_stock' => ['status' => 'out_of_stock', 'label' => 'Rupture de stock'],
                        default => ['status' => 'unknown', 'label' => 'Disponibilité à confirmer'],
                    };
                }
            }
            unset($item);
        }

        $structuredData = $this->structuredData($business);
        $productCategories = $this->productCategories($business);

        return view('pages.home', compact('business', 'photos', 'heroPhoto', 'productsBackground', 'structuredData', 'productCategories'));
    }

    /**
     * Filter options for the catalogue: only categories that contain at least one product.
     *
     * @param  array<string, mixed>  $business
     * @return array<string, array{label: string, count: int}>
     */
    private function productCategories(array $business): array
    {
        $counts = array_count_values(array_filter(array_column($business['products'], 'category')));
        $categories = [];

        foreach ($business['product_categories'] ?? [] as $slug => $label) {
            if (($counts[$slug] ?? 0) > 0) {
                $categories[$slug] = ['label' => $label, 'count' => $counts[$slug]];
            }
        }

        return $categories;
    }

    /**
     * Schema.org description of the salon, limited to details marked as confirmed.
     *
     * @param  array<string, mixed>  $business
     */
    private function structuredData(array $business): string
    {
        $contact = $business['contact'];
        $siteUrl = rtrim((string) ($business['site_url'] ?? ''), '/');
        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'HairSalon',
            'name' => $business['name'],
            'description' => $business['description'],
        ];

        if ($siteUrl !== '') {
            $data['url'] = $siteUrl.'/';
            $data['image'] = $siteUrl.'/'.$business['share_image'];
            $data['logo'] = $siteUrl.'/'.$business['logo'];
        }

        if ($contact['address_confirmed'] && $contact['address']) {
            $data['address'] = ['@type' => 'PostalAddress', 'streetAddress' => $contact['address'], 'addressCountry' => 'MQ'];

            if (preg_match('/^(\d{5})\s+([^,]+)/u', (string) $contact['postal_city'], $place)) {
                $data['address']['postalCode'] = $place[1];
                $data['address']['addressLocality'] = mb_convert_case($place[2], MB_CASE_TITLE, 'UTF-8');
            }
        }

        if ($contact['phone_confirmed'] && $contact['phone']) {
            $data['telephone'] = $contact['phone'];
        }

        if ($contact['email']) {
            $data['email'] = $contact['email'];
        }

        $specifications = [];
        foreach ($business['hours'] as $opening) {
            if (! isset($opening['schema_day'], $opening['opens'], $opening['closes'])) {
                continue;
            }

            $key = $opening['opens'].'-'.$opening['closes'];
            $specifications[$key] ??= [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => [],
                'opens' => $opening['opens'],
                'closes' => $opening['closes'],
            ];
            $specifications[$key]['dayOfWeek'][] = $opening['schema_day'];
        }

        if ($specifications !== []) {
            $data['openingHoursSpecification'] = array_values($specifications);
        }

        if (! empty($contact['instagram'])) {
            $data['sameAs'] = [$contact['instagram']];
        }

        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_THROW_ON_ERROR);
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
