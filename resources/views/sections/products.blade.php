    <section id="produits" class="bg-sand py-20 lg:py-28">
      <div class="mx-auto max-w-[1440px] px-5 lg:px-16">
        <div class="max-w-3xl"><p class="text-sm font-bold uppercase tracking-[.22em] text-wine">Sélection au salon</p><h2 class="mt-3 font-display text-5xl font-semibold leading-none lg:text-7xl">Produits &amp; conseils</h2><p class="mt-6 text-charcoal/75">{{ count($business['products']) ? 'Découvrez notre sélection et demandez conseil au salon. Achat sur place uniquement.' : 'Les références seront ajoutées après validation du salon. Achat sur place uniquement.' }}</p></div>
        <div data-carousel class="mt-12">
            <div id="product-track" class="carousel-track" tabindex="0" role="region" aria-label="Sélection de produits">
                @forelse($business['products'] as $product)
                    <article class="carousel-card rounded-3xl border border-charcoal/10 bg-ivory p-5">
                        @if($product['photo'])
                            <img src="{{ asset($product['photo']['src']) }}" alt="{{ $product['photo']['alt'] }}" width="700" height="700" loading="lazy" decoding="async" class="aspect-square w-full rounded-2xl bg-white object-contain">
                        @else
                            <div class="product-placeholder" aria-hidden="true">✦</div>
                        @endif
                        <p class="mt-5 text-sm font-bold uppercase tracking-[.18em] text-wine">{{ $product['brand'] }}</p>
                        <h3 class="mt-2 font-display text-3xl font-semibold">{{ $product['name'] }}</h3>
                        <p class="mt-2 text-charcoal/75">{{ $product['description'] }}</p>
                        @if(!empty($product['price']))<p class="mt-4 font-bold text-wine">{{ $product['price'] }}</p>@endif
                    </article>
                @empty
                    @for($i = 1; $i <= 3; $i++)
                        <article class="carousel-card rounded-3xl border border-charcoal/10 bg-ivory p-5">
                            <div class="product-placeholder" aria-hidden="true">＋</div>
                            <p class="mt-5 text-sm font-bold uppercase tracking-[.18em] text-wine">Bientôt au catalogue</p>
                            <h3 class="mt-2 font-display text-3xl font-semibold">Sélection {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</h3>
                            <p class="mt-2 text-charcoal/75">Les références et les photos seront bientôt disponibles.</p>
                        </article>
                    @endfor
                @endforelse
            </div>
            <div class="mt-4 flex justify-end gap-2" data-carousel-controls hidden>
                <button data-direction="previous" type="button" class="carousel-button border border-charcoal/30" aria-label="Produit précédent" aria-controls="product-track">←</button>
                <button data-direction="next" type="button" class="carousel-button bg-wine text-white" aria-label="Produit suivant" aria-controls="product-track">→</button>
            </div>
        </div>
      </div>
    </section>
