<section id="salon" class="hero-section relative isolate overflow-hidden bg-charcoal text-ivory">
    <div class="hero-content relative z-10 mx-auto w-full max-w-[1440px] px-5 pb-10 pt-16 lg:px-16 lg:py-28">
        <div class="min-w-0 max-w-xl">
            <p class="mb-7 text-xs font-bold uppercase tracking-[.25em] text-gold">{{ $business['tagline'] }}</p>
            <h1 class="hero-title font-display text-6xl font-semibold leading-[.95] sm:text-7xl lg:text-[clamp(4.75rem,7vw,6.5rem)]">
                La beauté,<br>
                <span class="hero-script font-normal text-gold">à votre image.</span>
            </h1>
            <p class="mt-8 max-w-lg text-lg leading-8 text-ivory/90">{{ $business['intro'] }}</p>
            <div class="mt-10 flex flex-wrap gap-3">
                <a href="#coiffures" class="button-primary">Découvrir nos prestations <span aria-hidden="true">↗</span></a>
                <a href="#contact" class="button-secondary">Prendre contact</a>
            </div>
            <p class="mt-8 text-sm leading-6 text-ivory/85">{{ $business['contact']['address'] }}<br>{{ $business['contact']['postal_city'] }}</p>
        </div>
    </div>
    <div class="hero-scene {{ $heroPhoto ? '' : 'hero-scene-placeholder' }}">
        @if($heroPhoto)
            <img src="{{ $heroPhoto['url'] }}" alt="{{ $heroPhoto['alt'] }}" width="2060" height="763" fetchpriority="high" decoding="async">
        @else
            <img src="{{ asset($business['logo']) }}" alt="Logo Golden Hair, Haute Coiffure, Coiffure Mixte" width="520" height="520" fetchpriority="high">
        @endif
    </div>
    <div class="relative z-10 mt-10 border-y border-white/10 bg-charcoal/80 lg:mt-0">
        <div class="marquee mx-auto flex max-w-[1440px] flex-wrap items-center justify-center gap-x-7 gap-y-3 px-5 py-5 text-xs font-bold uppercase tracking-[.24em] text-ivory/85 lg:justify-between lg:px-16">
            <span>Coupe</span><i aria-hidden="true">✦</i><span>Barber</span><i aria-hidden="true">✦</i><span>Locks</span><i aria-hidden="true">✦</i><span>Tresses</span><i aria-hidden="true">✦</i><span>Soins</span><i aria-hidden="true">✦</i><span>Conseil</span>
        </div>
    </div>
</section>
