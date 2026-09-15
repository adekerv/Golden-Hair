<article data-product-card class="carousel-card product-card rounded-3xl border border-charcoal/10 bg-ivory p-5" aria-labelledby="product-title-{{ $cardNumber }}">
    @if($product['photo'] ?? null)
        <img data-product-image src="{{ $product['photo']['url'] }}" alt="{{ $product['photo']['alt'] }}" width="700" height="700" loading="lazy" decoding="async" class="aspect-square w-full rounded-2xl bg-white object-contain">
    @else
        <div data-product-image class="product-placeholder"><span class="text-base">Photo à venir</span></div>
    @endif
    @if(!empty($product['brand']))
        <p data-product-brand class="mt-5 text-sm font-bold uppercase tracking-[.18em] text-wine">{{ $product['brand'] }}</p>
    @endif
    <h3 data-product-title id="product-title-{{ $cardNumber }}" class="mt-2 font-display text-3xl font-semibold">{{ $product['name'] ?? 'Produit à renseigner' }}</h3>
    <p data-product-description class="mt-2 text-charcoal/75">{{ $product['description'] ?? 'Description à renseigner.' }}</p>
    <p data-product-price class="product-price pt-4 text-lg font-bold text-wine"><span class="sr-only">Prix : </span>{{ ($product['price'] ?? '') !== '' ? $product['price'] : 'Prix à renseigner' }}</p>
    <p class="mt-3"><span data-product-stock data-stock="{{ $product['availability']['status'] }}" class="stock-badge">{{ $product['availability']['label'] }}</span></p>
    <details class="product-details mt-4 border-t border-charcoal/10 pt-4">
        <summary data-product-open class="product-details-trigger font-bold text-wine">Voir la fiche <span aria-hidden="true">↗</span><span class="sr-only"> : {{ $product['name'] ?? 'Produit à renseigner' }}</span></summary>
        <div data-product-details class="product-details-copy mt-4 space-y-4 text-charcoal/75">
            <p class="whitespace-pre-line">{{ ($product['details'] ?? '') !== '' ? $product['details'] : 'Pour en savoir plus sur ce produit, demandez conseil à notre équipe au salon.' }}</p>
            @if(!empty($product['size']))
                <p><strong>Format :</strong> {{ $product['size'] }}</p>
            @endif
            <p class="text-sm">Achat au salon uniquement. Notre équipe vous accompagne dans le choix de vos produits.</p>
        </div>
    </details>
</article>
