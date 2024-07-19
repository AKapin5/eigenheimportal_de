<li class="card__item">
    <figure  class="card">
        <a class="card__wrapper-img" href="{{ $apartment->getLink() }}">
            @if ($photo = $apartment->getFirstMedia('photos'))
                <img class="card__img" src="{{ thumb($photo, 'fit', 600, null) }}" alt="">
            @endif
            <div class="features layout-top">
                <div class="feature space">
                    {{ round($apartment->living_space) }} m<sup>2</sup>
                </div>
                <div class="feature rooms">
                    <img src="/img/icons/feature-icon_9.svg" alt="">
                    <span>{{ __(':rooms räume', ['rooms' => $apartment->rooms_count]) }}</span>
                </div>
            </div>
            <div class="features layout-bottom">
                <div class="feature category">
                    {{ $apartment->category->name }}
                </div>
            </div>
        </a>
        <figcaption class="card__container">
            <h4 class="card__title">
                <a href="{{ $apartment->getLink() }}">
                    {{ $apartment->name }}
                </a>
            </h4>
            <p class="card__subtitle">
                <img src="/img/icons/geolocation.svg" alt="" class="card__location-icon">
                {{ nl2br($apartment->short_text) }}
            </p>
        </figcaption>
    </figure>
</li>
