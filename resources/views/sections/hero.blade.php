<section id="salon" class="hero-section relative isolate overflow-hidden bg-charcoal text-ivory">
    <div class="hero-glow hero-glow-wine" aria-hidden="true"></div>
    <div class="hero-glow hero-glow-gold" aria-hidden="true"></div>
    <div class="hero-grain absolute inset-0 -z-10" aria-hidden="true"></div>

    <div class="mx-auto grid min-h-[760px] max-w-[1440px] items-center gap-14 px-5 py-20 lg:grid-cols-[1.08fr_.92fr] lg:px-16 lg:py-28">
        <div class="min-w-0 max-w-3xl">
            <div class="mb-7 flex items-center gap-4 text-xs font-bold uppercase tracking-[.25em] text-gold">
                <span class="h-px w-10 bg-gold"></span>
                <span>{{ $business['tagline'] }}</span>
            </div>
            <h1 class="hero-title font-display text-6xl font-semibold leading-[.92] sm:text-7xl lg:text-[clamp(4.75rem,8vw,7.5rem)]">
                La beauté,<br>
                <span class="hero-script font-normal text-gold">à votre image.</span>
            </h1>
            <p class="mt-8 max-w-xl text-lg leading-8 text-ivory/70">{{ $business['intro'] }}</p>
            <div class="mt-10 flex flex-col gap-3 sm:flex-row">
                <a href="#coiffures" class="button-primary">Découvrir nos prestations <span aria-hidden="true">↗</span></a>
                <a href="#contact" class="button-secondary">Prendre contact</a>
            </div>
            <div class="mt-12 grid max-w-xl grid-cols-3 gap-3 border-t border-white/15 pt-7">
                <div><strong class="block font-display text-3xl text-gold">Mixte</strong><span class="text-xs uppercase tracking-wider text-ivory/55">Salon pour tous</span></div>
                <div><strong class="block font-display text-3xl text-gold">Sur-mesure</strong><span class="text-xs uppercase tracking-wider text-ivory/55">Conseils experts</span></div>
                <div><strong class="block font-display text-3xl text-gold">Local</strong><span class="text-xs uppercase tracking-wider text-ivory/55">Le Lamentin</span></div>
            </div>
        </div>

        <div class="hero-visual relative mx-auto w-full max-w-[520px] min-w-0">
            <span class="hero-orbit" aria-hidden="true"></span>
            <div class="hero-card relative flex aspect-[4/5] items-center justify-center overflow-hidden rounded-[13rem_13rem_2.5rem_2.5rem] bg-[#151b19] p-10 shadow-2xl">
                @if($heroPhoto)
                    <img src="{{ asset($heroPhoto['src']) }}" alt="{{ $heroPhoto['alt'] }}" width="900" height="1100" fetchpriority="high" class="absolute inset-0 h-full w-full object-cover">
                @else
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_35%,rgba(216,189,126,.16),transparent_43%)]"></div>
                    <img width="520" height="520" fetchpriority="high" src="{{ asset($business['logo']) }}" alt="Logo Golden Hair, Haute Coiffure, Coiffure Mixte" class="relative w-[76%] rounded-full object-contain shadow-2xl ring-1 ring-gold/35">
                @endif
            </div>
            <div class="hero-location absolute -bottom-5 -left-2 rounded-2xl border border-white/15 bg-ivory p-4 text-charcoal shadow-2xl sm:-left-8">
                <p class="text-[.65rem] font-bold uppercase tracking-[.22em] text-wine">Votre salon au Lamentin</p>
                <p class="mt-1 font-display text-xl font-semibold">{{ $business['contact']['address'] }}</p>
            </div>
            <div class="absolute right-0 top-16 grid h-20 w-20 place-items-center rounded-full border border-gold/35 bg-charcoal/80 font-display text-3xl text-gold backdrop-blur" aria-hidden="true">GH</div>
        </div>
    </div>

    <div class="border-y border-white/10 bg-white/[.035]">
        <div class="marquee mx-auto flex max-w-[1440px] items-center justify-between gap-7 overflow-hidden px-5 py-5 text-xs font-bold uppercase tracking-[.24em] text-ivory/65 lg:px-16">
            <span>Coupe</span><i>✦</i><span>Locks</span><i>✦</i><span>Tresses</span><i>✦</i><span>Soins</span><i>✦</i><span>Coloration</span><i>✦</i><span>Conseil</span>
        </div>
    </div>
</section>
