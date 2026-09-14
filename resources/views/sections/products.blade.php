<section id="produits" class="bg-sand py-20 lg:py-28" aria-labelledby="products-title">
    <div class="mx-auto max-w-[1440px] px-5 lg:px-16">
        <div class="max-w-3xl">
            <p class="text-sm font-bold uppercase tracking-[.22em] text-wine">Sélection au salon</p>
            <h2 id="products-title" class="mt-3 font-display text-5xl font-semibold leading-none lg:text-7xl">Produits &amp; conseils</h2>
            <p class="mt-6 text-charcoal/75">Découvrez notre sélection et demandez conseil au salon. Achat sur place uniquement.</p>
        </div>
        @if(count($business['products']))
            <div data-carousel class="mt-12">
                <p id="products-help" class="mb-4 text-sm text-charcoal/75">Faites glisser les cartes ou utilisez les flèches du clavier lorsque la liste est sélectionnée.</p>
                <div id="product-track" class="carousel-track" tabindex="0" role="region" aria-label="Sélection de produits" aria-describedby="products-help">
                    @foreach($business['products'] as $product)
                        @include('partials.product-card', ['product' => $product, 'cardNumber' => $loop->iteration])
                    @endforeach
                </div>
                <div class="mt-4 flex flex-wrap items-center justify-between gap-4">
                    <p data-carousel-status class="text-sm text-charcoal/75" role="status" aria-live="polite" aria-atomic="true"></p>
                    <div class="flex gap-2" data-carousel-controls hidden>
                        <button data-direction="previous" type="button" class="carousel-button border border-charcoal/30" aria-label="Produit précédent" aria-controls="product-track">←</button>
                        <button data-direction="next" type="button" class="carousel-button bg-wine text-white" aria-label="Produit suivant" aria-controls="product-track">→</button>
                    </div>
                </div>
            </div>
        @else
            <p class="mt-10 text-charcoal/75">Notre sélection de produits sera bientôt disponible.</p>
        @endif
    </div>
</section>
