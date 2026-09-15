<footer class="bg-charcoal text-ivory">
    <div class="mx-auto grid max-w-[1440px] gap-10 px-5 py-14 lg:grid-cols-[1fr_auto] lg:px-16">
        <div class="flex min-w-0 items-center gap-4">
            <img width="520" height="520" src="{{ asset($business['logo']) }}" alt="" class="h-16 w-16 shrink-0 rounded-full object-cover ring-1 ring-gold/40">
            <div class="min-w-0"><p class="font-display text-2xl font-semibold tracking-[.12em] text-gold">{{ $business['name'] }}</p><p class="text-sm text-ivory/75">{{ $business['activity'] }}</p></div>
        </div>
        <nav class="grid grid-cols-2 gap-x-8 gap-y-3 text-sm lg:text-right" aria-label="Navigation secondaire">
            <a class="footer-link" href="{{ route('home') }}#salon">Le salon</a>
            <a class="footer-link" href="{{ route('home') }}#coiffures">Coiffures</a>
            <a class="footer-link" href="{{ route('home') }}#produits">Produits</a>
            <a class="footer-link" href="{{ route('home') }}#contact">Contact</a>
        </nav>
    </div>
    <div class="border-t border-white/10">
        <div class="mx-auto flex max-w-[1440px] flex-col gap-3 px-5 py-6 text-sm text-ivory/75 sm:flex-row sm:items-center sm:justify-between lg:px-16">
            <p>© {{ date('Y') }} {{ $business['name'] }} · {{ $business['activity'] }}</p>
            <nav class="flex flex-wrap gap-x-5" aria-label="Informations légales">
                <a class="footer-link" href="{{ route('legal') }}">Mentions légales</a>
                <a class="footer-link" href="{{ route('privacy') }}">Confidentialité</a>
            </nav>
        </div>
    </div>
</footer>
