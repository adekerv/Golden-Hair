  <header class="sticky top-0 z-40 border-b border-white/10 bg-charcoal/90 text-ivory shadow-[0_12px_40px_rgba(0,0,0,.12)] backdrop-blur-xl">
    <nav class="mx-auto flex max-w-[1440px] items-center justify-between px-5 py-3 lg:px-16" aria-label="Navigation principale">
      <a href="{{ route('home') }}#salon" class="flex items-center gap-3 rounded focus:outline-none focus:ring-2 focus:ring-gold" aria-label="GOLDEN HAIR — accueil">
        <img width="520" height="520" src="{{ asset($business['logo']) }}" alt="" class="h-14 w-14 rounded-full object-cover object-center ring-1 ring-gold/40 lg:h-16 lg:w-16">
        <span><span class="block font-display text-lg font-semibold tracking-[.10em] text-gold lg:text-2xl">GOLDEN HAIR</span><span class="hidden text-[.58rem] uppercase tracking-[.27em] text-ivory/45 sm:block">{{ $business['activity'] }} · Martinique</span></span>
      </a>
      <div class="hidden items-center gap-8 text-sm font-semibold lg:flex">
        <a class="transition hover:text-gold focus:outline-none focus:ring-2 focus:ring-gold" href="{{ route('home') }}#salon">Le salon</a>
        <a class="transition hover:text-gold focus:outline-none focus:ring-2 focus:ring-gold" href="{{ route('home') }}#coiffures">Coiffures &amp; tarifs</a>
        <a class="transition hover:text-gold focus:outline-none focus:ring-2 focus:ring-gold" href="{{ route('home') }}#produits">Produits</a>
        <a class="rounded-full bg-gold px-6 py-3 text-charcoal transition hover:bg-[#ead49e] focus:outline-none focus:ring-2 focus:ring-gold" href="{{ route('home') }}#contact">Nous contacter <span aria-hidden="true">↗</span></a>
      </div>
      <details data-mobile-menu class="group relative lg:hidden">
        <summary class="flex h-12 w-12 cursor-pointer list-none items-center justify-center rounded-full border border-gold/60 text-gold focus:outline-none focus:ring-2 focus:ring-gold" aria-label="Menu principal">
          <svg aria-hidden="true" class="h-6 w-6 group-open:hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
          <svg aria-hidden="true" class="hidden h-6 w-6 group-open:block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 6l12 12M18 6L6 18"/></svg>
        </summary>
        <div class="absolute right-0 top-14 max-h-[calc(100dvh-7rem)] w-72 max-w-[calc(100vw-2.5rem)] overflow-y-auto rounded-2xl border border-gold/25 bg-charcoal p-3 shadow-2xl">
          <a class="block rounded-xl px-4 py-3 hover:bg-white/5" href="{{ route('home') }}#salon">Le salon</a>
          <a class="block rounded-xl px-4 py-3 hover:bg-white/5" href="{{ route('home') }}#coiffures">Coiffures &amp; tarifs</a>
          <a class="block rounded-xl px-4 py-3 hover:bg-white/5" href="{{ route('home') }}#produits">Produits</a>
          <a class="mt-2 block rounded-xl bg-wine px-4 py-3 text-center font-bold" href="{{ route('home') }}#contact">Nous contacter</a>
        </div>
      </details>
    </nav>
  </header>
