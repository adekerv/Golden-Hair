@if($hasBusinessInfo)
    <section class="section container business-info" id="informations" aria-labelledby="info-title">
        <p class="eyebrow">Votre visite</p>
        <h2 id="info-title">Informations pratiques</h2>
        <div class="info-grid">
            @if(count($business['services']) > 0)
                <div>
                    <h3>Nos prestations</h3>
                    <dl class="business-list">
                        @foreach($business['services'] as $service)
                            <div><dt>{{ $service['name'] }}</dt><dd>{{ $service['description'] }}</dd></div>
                        @endforeach
                    </dl>
                </div>
            @endif
            @if(count(array_filter($business['contact'])) > 0)
                <div>
                    <h3>Nous contacter</h3>
                    <address class="contact-details">
                        @if($business['contact']['address'])
                            <p>{{ $business['contact']['address'] }}</p>
                        @endif
                        @if($business['contact']['phone'])
                            <p><a href="tel:{{ preg_replace('/[^0-9+]/', '', $business['contact']['phone']) }}">{{ $business['contact']['phone'] }}</a></p>
                        @endif
                        @if($business['contact']['email'])
                            <p><a href="mailto:{{ $business['contact']['email'] }}">{{ $business['contact']['email'] }}</a></p>
                        @endif
                    </address>
                </div>
            @endif
            @if(count($business['hours']) > 0)
                <div>
                    <h3>Nos horaires</h3>
                    <dl class="business-list">
                        @foreach($business['hours'] as $opening)
                            <div><dt>{{ $opening['day'] }}</dt><dd>{{ $opening['hours'] }}</dd></div>
                        @endforeach
                    </dl>
                </div>
            @endif
        </div>
    </section>
@endif
