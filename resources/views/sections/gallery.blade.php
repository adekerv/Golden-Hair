@if(count($photos))
    <section id="photos" class="bg-ivory px-5 py-20 lg:px-16" aria-labelledby="photos-title">
        <div class="mx-auto max-w-[1312px]">
            <h2 id="photos-title" class="font-display text-5xl font-semibold">Le salon en images</h2>
            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($photos as $photo)
                    <figure class="min-w-0">
                        <img src="{{ asset($photo['src']) }}" alt="{{ $photo['alt'] }}" width="800" height="1000" loading="lazy" decoding="async" class="aspect-[4/5] w-full rounded-3xl object-cover">
                        @if(!empty($photo['caption']))<figcaption class="mt-3 text-charcoal/75">{{ $photo['caption'] }}</figcaption>@endif
                    </figure>
                @endforeach
            </div>
        </div>
    </section>
@endif
