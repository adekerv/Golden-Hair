<section id="coiffures" class="bg-ivory py-20 lg:py-28" aria-labelledby="hairstyles-heading">
    <div class="mx-auto max-w-[1440px] px-5 lg:px-16">
        <div class="flex flex-col justify-between gap-6 lg:flex-row lg:items-end">
            <div>
                <p class="text-sm font-bold uppercase tracking-[.22em] text-wine">Coiffures &amp; tarifs</p>
                <h2 id="hairstyles-heading" class="mt-3 font-display text-5xl font-semibold leading-none lg:text-7xl">Trouvez votre prochain style</h2>
            </div>
            <p class="max-w-md text-base leading-7 text-charcoal/75">Tresses, coupes, boucles et locks : découvrez nos réalisations et trouvez l’inspiration pour votre prochaine visite.</p>
        </div>
        <div data-carousel class="mt-12">
            <div id="hairstyle-track" class="carousel-track" tabindex="0" role="region" aria-label="Réalisations Golden Hair">
                @foreach($business['services'] as $service)
                    <article data-hairstyle-card class="hairstyle-card carousel-card overflow-hidden rounded-3xl border border-charcoal/10 bg-white">
                        <div class="relative shrink-0">
                            @if($service['photo'])
                                <img id="hairstyle-photo-{{ $loop->iteration }}" data-hairstyle-photo src="{{ $service['photo']['url'] }}" alt="{{ $service['photo']['alt'] }}" width="960" height="1280" loading="lazy" decoding="async" class="aspect-[3/4] w-full bg-sand object-cover">
                                @if(count($service['style_photos']) > 1)
                                    <nav class="hairstyle-views" aria-label="Vues de {{ $service['name'] }}">
                                        @foreach($service['style_photos'] as $photo)
                                            <a data-hairstyle-view href="{{ $photo['url'] }}" data-image-alt="{{ $photo['alt'] }}" aria-controls="hairstyle-photo-{{ $loop->parent->iteration }}" aria-current="{{ $loop->first ? 'true' : 'false' }}" aria-label="Vue {{ $loop->iteration }} : {{ $photo['alt'] }}">Vue {{ $loop->iteration }}</a>
                                        @endforeach
                                    </nav>
                                @endif
                            @else
                                <div class="service-placeholder flex aspect-[3/4] items-center justify-center p-8 text-center">
                                    <p class="text-sm uppercase tracking-[.2em]">{{ $service['category'] }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-1 flex-col p-6">
                            <p class="text-xs font-bold uppercase tracking-[.18em] text-wine">{{ $service['category'] }}</p>
                            <h3 class="mt-3 font-display text-3xl font-semibold leading-tight">{{ $service['name'] }}</h3>
                            <p class="mt-3 text-sm leading-6 text-charcoal/75">{{ $service['description'] }}</p>
                            @if(!empty($service['price']))
                                <p class="mt-5 text-sm text-charcoal/75">{{ $service['price_label'] ?? 'Tarif' }} <strong class="ml-2 text-wine">{{ $service['price'] }}</strong></p>
                            @endif
                            <div class="mt-auto pt-6">
                                <a href="#contact" class="hairstyle-contact" aria-label="Contacter le salon pour : {{ $service['name'] }}">Parlons de votre style <span aria-hidden="true">↗</span></a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
            <div class="mt-4 flex flex-wrap items-center justify-between gap-4">
                <p class="text-sm text-charcoal/75">{{ count($business['services']) }} styles à découvrir · Faites défiler les photos</p>
                <div class="flex gap-2" data-carousel-controls hidden>
                    <button data-direction="previous" type="button" class="carousel-button border border-charcoal/30" aria-label="Coiffure précédente" aria-controls="hairstyle-track">←</button>
                    <button data-direction="next" type="button" class="carousel-button bg-charcoal text-ivory" aria-label="Coiffure suivante" aria-controls="hairstyle-track">→</button>
                </div>
                <p data-carousel-status class="sr-only" aria-live="polite" aria-atomic="true"></p>
            </div>
        </div>
        @include('partials.price-list')
    </div>
</section>
