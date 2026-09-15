    <section id="coiffures" class="bg-ivory py-20 lg:py-28">
      <div class="mx-auto max-w-[1440px] px-5 lg:px-16">
        <div class="flex flex-col justify-between gap-6 lg:flex-row lg:items-end">
          <div><p class="text-sm font-bold uppercase tracking-[.22em] text-wine">Coiffures &amp; tarifs</p><h2 class="mt-3 font-display text-5xl font-semibold leading-none lg:text-7xl">Trouvez votre prochain style</h2></div>
          <p class="max-w-md text-base leading-7 text-charcoal/75">Une sélection de prestations. Les tarifs variables suivent l’ordre Court / Mi-long / Long.</p>
        </div>
        <div data-carousel class="mt-12">
            <div id="hairstyle-track" class="carousel-track" tabindex="0" role="region" aria-label="Sélection de coiffures">
                @foreach($business['services'] as $service)
                    <article class="carousel-card overflow-hidden rounded-3xl bg-white shadow-soft">
                        @if($service['photo'])
                            <img src="{{ $service['photo']['url'] }}" alt="{{ $service['photo']['alt'] }}" width="800" height="600" loading="lazy" decoding="async" class="aspect-[4/3] w-full object-cover">
                        @else
                            <div class="service-placeholder flex aspect-[4/3] items-center justify-center p-8 text-center">
                                <div><span class="text-5xl" aria-hidden="true">✦</span><p class="mt-4 text-sm uppercase tracking-[.2em]">{{ $service['category'] }}</p></div>
                            </div>
                        @endif
                        <div class="p-6">
                            <p class="text-sm font-bold uppercase tracking-[.18em] text-wine">{{ $service['category'] }}</p>
                            <h3 class="mt-2 font-display text-3xl font-semibold">{{ $service['name'] }}</h3>
                            <p class="mt-3 text-charcoal/75">{{ $service['description'] }}</p>
                            <div class="mt-6 flex flex-wrap items-end justify-between gap-3">
                                <span class="text-sm text-charcoal/75">{{ $service['price_label'] }}</span>
                                <strong class="text-xl text-wine">{{ $service['price'] }}</strong>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
            <div class="mt-4 flex flex-wrap items-center justify-between gap-4">
                <p class="text-sm text-charcoal/75">Faites défiler les cartes horizontalement</p>
                <div class="flex gap-2" data-carousel-controls hidden>
                    <button data-direction="previous" type="button" class="carousel-button border border-charcoal/30" aria-label="Coiffure précédente" aria-controls="hairstyle-track">←</button>
                    <button data-direction="next" type="button" class="carousel-button bg-charcoal text-ivory" aria-label="Coiffure suivante" aria-controls="hairstyle-track">→</button>
                </div>
            </div>
        </div>
        @include('partials.price-list')
      </div>
    </section>
