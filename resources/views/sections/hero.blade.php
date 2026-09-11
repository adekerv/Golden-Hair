    <section id="salon" class="relative isolate overflow-hidden bg-charcoal text-ivory">
      <div class="absolute inset-0 -z-10 opacity-30" style="background:radial-gradient(circle at 78% 28%,#8d2636 0,transparent 34%),radial-gradient(circle at 72% 72%,#d8bd7e 0,transparent 26%)"></div>
      <div class="mx-auto grid min-h-[690px] max-w-[1440px] items-center gap-10 px-5 py-20 lg:grid-cols-[1.05fr_.95fr] lg:px-16 lg:py-24">
        <div class="min-w-0 max-w-3xl">
          <p class="mb-5 text-sm font-bold uppercase tracking-[.24em] text-gold">{{ $business['tagline'] }}</p>
          <h1 class="font-display hero-title text-6xl font-semibold leading-[1.02] sm:text-7xl lg:text-[clamp(4rem,7.35vw,106px)]">Votre style.<br><span class="text-gold">Votre moment.</span></h1>
          <p class="mt-8 max-w-xl text-lg leading-8 text-ivory/75">{{ $business['intro'] }}</p>
          <div class="mt-10 flex flex-col gap-3 sm:flex-row">
            <a href="#coiffures" class="inline-flex min-h-12 items-center justify-center rounded-full bg-wine px-7 py-3 font-bold text-white transition hover:bg-[#a62e42] focus:outline-none focus:ring-2 focus:ring-gold">Voir les coiffures</a>
            <a href="#contact" class="inline-flex min-h-12 items-center justify-center rounded-full border border-gold px-7 py-3 font-bold text-gold transition hover:bg-gold hover:text-charcoal focus:outline-none focus:ring-2 focus:ring-gold">Contacter le salon</a>
          </div>
        </div>
        <div class="relative mx-auto w-full max-w-[520px] min-w-0">
          <div class="absolute -inset-5 rotate-3 rounded-[40px] border border-gold/35"></div>
          <div class="relative flex aspect-[4/5] items-center justify-center overflow-hidden rounded-[32px] bg-[#111716] p-10 shadow-2xl ring-1 ring-white/10">
            @if($heroPhoto)
                <img src="{{ asset($heroPhoto['src']) }}" alt="{{ $heroPhoto['alt'] }}" width="900" height="1100" fetchpriority="high" class="absolute inset-0 h-full w-full object-cover">
            @else
                <img width="520" height="520" fetchpriority="high" src="{{ asset($business['logo']) }}" alt="Logo Golden Hair, Haute Coiffure, Coiffure Mixte" class="logo-fade w-full object-contain">
            @endif
          </div>
          <p class="relative -mt-5 mx-3 w-fit rounded-2xl bg-gold px-5 py-3 text-sm font-bold text-charcoal">{{ $business['contact']['address'] }} · {{ $business['contact']['postal_city'] }}</p>
        </div>
      </div>
    </section>
