@if(count($photos) > 0)
    <section class="section container" id="photos" aria-labelledby="photos-title">
        <p class="eyebrow">En images</p>
        <h2 id="photos-title">Découvrez Golden Hair.</h2>
        <div class="photo-grid">
            @foreach($photos as $photo)
                <figure class="photo-card">
                    <img src="{{ asset($photo['src']) }}" alt="{{ $photo['alt'] }}" width="800" height="1000" loading="lazy" decoding="async">
                    @if(!empty($photo['caption']))
                        <figcaption>{{ $photo['caption'] }}</figcaption>
                    @endif
                </figure>
            @endforeach
        </div>
    </section>
@endif
