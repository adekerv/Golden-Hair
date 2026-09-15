<article class="carousel-card product-card rounded-3xl border border-charcoal/10 bg-ivory p-5" aria-labelledby="product-title-{{ $cardNumber }}">
    @if($product['photo'] ?? null)
        <img src="{{ $product['photo']['url'] }}" alt="{{ $product['photo']['alt'] }}" width="700" height="700" loading="lazy" decoding="async" class="aspect-square w-full rounded-2xl bg-white object-contain">
    @else
        <div class="product-placeholder"><span class="text-base">Photo à venir</span></div>
    @endif
    @if(!empty($product['brand']))
        <p class="mt-5 text-sm font-bold uppercase tracking-[.18em] text-wine">{{ $product['brand'] }}</p>
    @endif
    <h3 id="product-title-{{ $cardNumber }}" class="mt-2 font-display text-3xl font-semibold">{{ $product['name'] ?? 'Produit à renseigner' }}</h3>
    <p class="mt-2 text-charcoal/75">{{ $product['description'] ?? 'Description à renseigner.' }}</p>
    <p class="product-price pt-4 text-lg font-bold text-wine"><span class="sr-only">Prix : </span>{{ ($product['price'] ?? '') !== '' ? $product['price'] : 'Prix à renseigner' }}</p>
</article>
