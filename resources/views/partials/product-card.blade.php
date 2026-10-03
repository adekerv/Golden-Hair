<article data-product-card data-category="{{ $product['category'] ?? '' }}" class="product-card rounded-2xl border border-ink/10 bg-card-alt p-3 sm:p-4" aria-labelledby="product-title-{{ $cardNumber }}">
    @if($product['photo'] ?? null)
        <img data-product-image src="{{ $product['photo']['url'] }}" alt="{{ $product['photo']['alt'] }}" width="700" height="700" loading="lazy" decoding="async" class="aspect-square w-full rounded-xl bg-white object-contain">
    @else
        <div data-product-image class="product-placeholder"><span class="text-base">Photo à venir</span></div>
    @endif
    @if(!empty($product['brand']))
        <p data-product-brand class="mt-4 text-[.7rem] font-bold uppercase tracking-[.16em] text-accent sm:text-xs">{{ $product['brand'] }}</p>
    @endif
    <h3 data-product-title id="product-title-{{ $cardNumber }}" class="mt-1 font-display text-xl font-semibold leading-tight sm:text-2xl">{{ $product['name'] ?? 'Produit à renseigner' }}</h3>
    <p data-product-description class="mt-2 hidden text-sm leading-6 text-ink/75 sm:line-clamp-2">{{ $product['description'] ?? 'Description à renseigner.' }}</p>
    <p class="product-price pt-3 text-sm font-bold text-accent sm:text-base"><span class="sr-only">Prix : </span><span data-product-price>{{ ($product['price'] ?? '') !== '' ? $product['price'] : 'Prix à renseigner' }}</span></p>
    <p class="mt-2"><span data-product-stock data-stock="{{ $product['availability']['status'] }}" class="stock-badge">{{ $product['availability']['label'] }}</span></p>
    <details class="product-details mt-3 border-t border-ink/10 pt-3">
        <summary data-product-open class="product-details-trigger text-sm font-bold text-accent">Voir la fiche <span aria-hidden="true">↗</span><span class="sr-only"> : {{ $product['name'] ?? 'Produit à renseigner' }}</span></summary>
        <div data-product-details class="product-details-copy mt-4 space-y-4 text-ink/75">
            <p class="whitespace-pre-line">{{ ($product['details'] ?? '') !== '' ? $product['details'] : 'Pour en savoir plus sur ce produit, demandez conseil à notre équipe au salon.' }}</p>
            @if(!empty($product['size']))
                <p><strong>Format :</strong> {{ $product['size'] }}</p>
            @endif
            <p class="text-sm">Achat au salon uniquement. Notre équipe vous accompagne dans le choix de vos produits.</p>
        </div>
    </details>
</article>
