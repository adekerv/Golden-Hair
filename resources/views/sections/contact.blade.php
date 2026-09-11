<section id="contact" class="bg-wine py-20 text-white lg:py-28">
    <div class="mx-auto grid max-w-[1440px] gap-12 px-5 lg:grid-cols-2 lg:gap-20 lg:px-16">
        <div class="min-w-0">
            <p class="text-sm font-bold uppercase tracking-[.22em] text-gold">Contact</p>
            <h2 class="mt-3 max-w-xl font-display text-5xl font-semibold leading-[1.05] lg:text-7xl">Parlons de votre prochain style</h2>
            <p class="mt-7 max-w-lg text-white/80">Pour une information sur une prestation ou une disponibilité, contactez directement le salon.</p>
            <div class="mt-9 flex flex-wrap gap-3">
                @if($business['contact']['phone_confirmed'] && $business['contact']['phone'])
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $business['contact']['phone']) }}" class="contact-button">Appeler le salon</a>
                @else
                    <p class="rounded-2xl bg-white/10 px-5 py-4 text-white/85">Le numéro de téléphone est en cours de confirmation.</p>
                @endif
                @if($business['contact']['whatsapp'])
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $business['contact']['whatsapp']) }}" class="contact-button">WhatsApp</a>
                @endif
                @if($business['contact']['email'])
                    <a href="mailto:{{ $business['contact']['email'] }}" class="contact-button">Écrire au salon</a>
                @endif
            </div>
        </div>
        <div class="min-w-0 rounded-[32px] bg-ivory p-7 text-charcoal shadow-2xl lg:p-10">
            <p class="text-sm font-bold uppercase tracking-[.18em] text-wine">Venir au salon</p>
            <h3 class="mt-3 font-display text-4xl font-semibold">{{ $business['name'] }}</h3>
            <div class="mt-8 space-y-7">
                <div class="border-b border-charcoal/10 pb-6">
                    <p class="text-sm font-bold text-charcoal/75">ADRESSE @if(!$business['contact']['address_confirmed']) · À CONFIRMER @endif</p>
                    <address class="mt-2 text-lg font-semibold not-italic">{{ $business['contact']['address'] }}<br>{{ $business['contact']['postal_city'] }}</address>
                </div>
                @if($business['contact']['phone'])
                    <div class="border-b border-charcoal/10 pb-6">
                        <p class="text-sm font-bold text-charcoal/75">TÉLÉPHONE @if(!$business['contact']['phone_confirmed']) · À CONFIRMER @endif</p>
                        <p class="mt-2 text-lg font-semibold">{{ $business['contact']['phone'] }}</p>
                    </div>
                @endif
                <div>
                    <h4 class="text-sm font-bold text-charcoal/75">HORAIRES</h4>
                    @if(count($business['hours']))
                        <dl class="mt-2 space-y-2">
                            @foreach($business['hours'] as $opening)
                                <div class="flex flex-wrap justify-between gap-2"><dt>{{ $opening['day'] }}</dt><dd class="font-semibold">{{ $opening['hours'] }}</dd></div>
                            @endforeach
                        </dl>
                    @else
                        <p class="mt-2 text-lg font-semibold">À confirmer auprès du salon</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
