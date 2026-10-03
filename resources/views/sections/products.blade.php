<section id="produits" class="products-section bg-surface-alt py-20 lg:py-28" aria-labelledby="products-title">
    @if($productsBackground)
        <div class="products-backdrop" aria-hidden="true">
            <img src="{{ $productsBackground['url'] }}" alt="" width="1280" height="484" loading="lazy" decoding="async">
        </div>
    @endif
    <div class="mx-auto max-w-[1440px] px-5 lg:px-16">
        <div class="max-w-3xl">
            <p class="text-sm font-bold uppercase tracking-[.22em] text-accent">Sélection au salon</p>
            <h2 id="products-title" class="mt-3 font-display text-5xl font-semibold leading-none lg:text-7xl">Produits &amp; conseils</h2>
            <p class="mt-6 text-ink/75">Découvrez notre sélection et demandez conseil au salon. Achat sur place uniquement.</p>
        </div>
        @if(count($business['products']))
            <div data-product-catalog class="mt-10">
                @if(count($productCategories) > 1)
                    <div data-product-filters hidden class="flex flex-wrap gap-2" role="group" aria-label="Filtrer les produits par catégorie">
                        <button type="button" data-product-filter="all" aria-pressed="true" class="filter-chip">Tous <span class="filter-count">{{ count($business['products']) }}</span></button>
                        @foreach($productCategories as $slug => $category)
                            <button type="button" data-product-filter="{{ $slug }}" aria-pressed="false" class="filter-chip">{{ $category['label'] }} <span class="filter-count">{{ $category['count'] }}</span></button>
                        @endforeach
                    </div>
                @endif
                <p data-product-status class="mt-5 min-h-6 text-sm text-ink/75" role="status" aria-live="polite" aria-atomic="true"></p>
                <div id="product-grid" class="mt-3 grid grid-cols-2 gap-3 sm:gap-5 md:grid-cols-3 xl:grid-cols-4">
                    @foreach($business['products'] as $product)
                        @include('partials.product-card', ['product' => $product, 'cardNumber' => $loop->iteration])
                    @endforeach
                </div>
                <div data-product-more-wrap hidden class="mt-8 flex justify-center">
                    <button type="button" data-product-more class="more-button" aria-controls="product-grid">Afficher plus de produits</button>
                </div>
            </div>
            @include('partials.product-dialog')
        @else
            <p class="mt-10 text-ink/75">Notre sélection de produits sera bientôt disponible.</p>
        @endif
    </div>
</section>
