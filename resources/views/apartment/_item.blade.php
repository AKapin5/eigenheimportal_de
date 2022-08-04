<li class="card__item">
    <figure  class="card">
        <a class="card__wrapper-img" href="{{ $apartment->getLink() }}">
            @if ($photo = $apartment->getFirstMedia('photos'))
                <img class="card__img" src="{{ thumb($photo, 'fit', 600) }}" alt="">
            @endif
        </a>
        <figcaption class="card__container">
            <h4 class="card__title">{{ $apartment->name }}</h4>
            <p class="card__subtitle">{{ nl2br($apartment->short_text) }}</p>
            <a href="{{ $apartment->getLink() }}" class="card__btn">{{ __('app.itemInfo') }}</a>
        </figcaption>
    </figure>
</li>
