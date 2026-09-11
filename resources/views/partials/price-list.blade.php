<details class="price-list mt-10 rounded-3xl border border-charcoal/10 bg-sand p-5 lg:p-8">
    <summary class="flex cursor-pointer items-center justify-between gap-5 font-bold">
        <span>Consulter la liste complète des tarifs</span>
        <span class="price-toggle flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-charcoal text-gold" aria-hidden="true">+</span>
    </summary>
    <div class="mt-8 grid gap-8 border-t border-charcoal/10 pt-8 lg:grid-cols-3">
        @foreach($business['price_groups'] as $group)
            <div class="min-w-0">
                <h3 class="font-display text-3xl font-semibold">{{ $group['title'] }}</h3>
                <dl class="mt-5 space-y-3 text-sm">
                    @foreach($group['items'] as $item)
                        <div class="price-row"><dt>{{ $item['name'] }}</dt><dd class="font-bold">{{ $item['price'] }}</dd></div>
                    @endforeach
                </dl>
                @if($group['title'] === 'Locks' && $business['locks_note'])
                    <p class="mt-5 text-sm text-charcoal/75">{{ $business['locks_note'] }}</p>
                @endif
            </div>
        @endforeach
    </div>
    @if(!$business['prices_confirmed'])
        <p class="mt-8 text-sm text-charcoal/75">{{ $business['prices_note'] }}</p>
    @endif
</details>
