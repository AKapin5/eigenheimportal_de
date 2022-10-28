<x-app>
    <section class="banner-hero">
        <div class="banner-hero__bg">
            <div class="wrapper m-secondary">
                <div class="banner-hero__wrapper">
                    <div class="banner-hero__info">
                        <h1 class="banner-hero__title"> {{ __('app.home.mainBanner.title') }} </h1>
                        <p class="banner-hero__text"> {{ __('app.home.mainBanner.heroText') }} </p>
                        <a href="{{ route('apartment.index') }}" class="banner-hero__btn"> {{ __('app.home.mainBanner.buttonText') }} </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="info">
        <div class="wrapper">
            <h2 class="info__title"> {{ __('app.home.infoBlock.title') }} </h2>
            <ul class="info__list">
                <li class="info__item">
                    <div class="info__item-wrapper-img">
                        <img class="info__item-img" src="/img/icons/layout.svg" alt="">
                    </div>
                    <p class="info__item-text">
                        {{ __('app.home.infoBlock.text1') }}
                    </p>
                </li>
                <li class="info__item">
                    <div class="info__item-wrapper-img">
                        <img class="info__item-img" src="/img/icons/house-document.svg" alt="">
                    </div>
                    <p class="info__item-text">
                        {{ __('app.home.infoBlock.text2') }}
                    </p>
                </li>
                <li class="info__item">
                    <div class="info__item-wrapper-img">
                        <img class="info__item-img" src="/img/icons/house-reports.svg" alt="">
                    </div>
                    <p class="info__item-text">
                        {{ __('app.home.infoBlock.text3') }}
                    </p>
                </li>
                <li class="info__item">
                    <div class="info__item-wrapper-img">
                        <img class="info__item-img" src="/img/icons/house-building.svg" alt="">
                    </div>
                    <p class="info__item-text">
                        {{ __('app.home.infoBlock.text4') }}
                    </p>
                </li>
                <li class="info__item">
                    <div class="info__item-wrapper-img">
                        <img class="info__item-img" src="/img/icons/laptop.svg" alt="">
                    </div>
                    <p class="info__item-text">
                        {{ __('app.home.infoBlock.text5') }}
                    </p>
                </li>
                <li class="info__item">
                    <div class="info__item-wrapper-img">
                        <img class="info__item-img" src="/img/icons/house-keys.svg" alt="">
                    </div>
                    <p class="info__item-text">
                        {{ __('app.home.infoBlock.text6') }}
                    </p>
                </li>
            </ul>
        </div>
    </section>
    <section class="progression">
        <div class="wrapper">
            <div class="progression__container">
                <div class="progression__wrapper-img">
                    <img class="progression__img" src="/img/man-with-laptop.png" alt="">
                </div>
                <div class="progression__info">
                    <h2 class="progression__info-title">
                        {{ __('app.home.progressionBlock.title') }}
                    </h2>
                    <ul class="progression__list">
                        <li class="progression__item">
                            <div class="progression__item-icon">
                                <span>1</span>
                            </div>
                            <div class="progression__item-text">
                                <h3 class="progression__item-title">{{ __('app.home.progressionBlock.item1.title') }}</h3>
                                <p class="progression__item-subtitle">
                                    {{ __('app.home.progressionBlock.item1.description') }}
                                </p>
                            </div>
                        </li>
                        <li class="progression__item">
                            <div class="progression__item-icon">
                                <span>2</span>
                            </div>
                            <div class="progression__item-text">
                                <h3 class="progression__item-title">{{ __('app.home.progressionBlock.item2.title') }}</h3>
                                <p class="progression__item-subtitle">
                                    {{ __('app.home.progressionBlock.item2.description') }}
                                </p>
                            </div>
                        </li>
                        <li class="progression__item">
                            <div class="progression__item-icon">
                                <span>3</span>
                            </div>
                            <div class="progression__item-text">
                                <h3 class="progression__item-title">{{ __('app.home.progressionBlock.item3.title') }}</h3>
                                <p class="progression__item-subtitle">
                                    {{ __('app.home.progressionBlock.item3.description') }}
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="progression__container">
                <div class="progression__info">
                    <ul class="progression__list">
                        <li class="progression__item">
                            <div class="progression__item-icon">
                                <span>4</span>
                            </div>
                            <div class="progression__item-text">
                                <h3 class="progression__item-title">{{ __('app.home.progressionBlock.item4.title') }}</h3>
                                <p class="progression__item-subtitle">
                                    {{ __('app.home.progressionBlock.item4.description') }}
                                </p>
                            </div>
                        </li>
                        <li class="progression__item">
                            <div class="progression__item-icon">
                                <span>5</span>
                            </div>
                            <div class="progression__item-text">
                                <h3 class="progression__item-title">{{ __('app.home.progressionBlock.item5.title') }}</h3>
                                <p class="progression__item-subtitle">
                                    {{ __('app.home.progressionBlock.item5.description') }}
                                </p>
                            </div>
                        </li>
                        <li class="progression__item">
                            <div class="progression__item-icon">
                                <span>6</span>
                            </div>
                            <div class="progression__item-text">
                                <h3 class="progression__item-title">{{ __('app.home.progressionBlock.item6.title') }}</h3>
                                <p class="progression__item-subtitle">
                                    {{ __('app.home.progressionBlock.item6.description') }}
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="progression__wrapper-img">
                    <img class="progression__img" src="/img/man-with-purchase.png" alt="">
                </div>
            </div>
        </div>
    </section>
    @if (!$topApartments->isEmpty())
        <section class="real-estate" style="display: none">
            <div class="wrapper">
                <h2 class="real-estate-title">{{ __('app.home.topApartmentsBlock.title') }}</h2>
                <ul class="card__list">
                    @foreach($topApartments as $topApartment)
                        <li class="card__item">
                            <figure class="card">
                                <a class="card__wrapper-img" href="{{ $topApartment->getLink() }}">
                                    <img class="card__img" src="{{ thumb($topApartment->getFirstMedia('photos'), 'fit', 400) }}" alt="">
                                </a>
                                <figcaption class="card__container">
                                    <h4 class="card__title">
                                        <a href="{{ $topApartment->getLink() }}">{{ $topApartment->name }}</a>
                                    </h4>
                                    <p class="card__subtitle">{{ $topApartment->category->name }}</p>
                                    <a href="{{ $topApartment->getLink() }}" class="card__btn">
                                        {{ __('app.itemInfo') }}
                                    </a>
                                </figcaption>
                            </figure>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    @endif
    <section class="banner m-secondary">
        <div class="wrapper">
            <div class="banner__wrapper">
                <img src="/img/banner-secondary.jpg" alt="" class="banner__img">
            </div>
        </div>
    </section>
    @if ($topBlogs->isNotEmpty())
        <section class="blog">
            <div class="wrapper">
                <h2 class="blog__title">{{ __('app.home.latestBlogsBlock.title') }}</h2>
                <ul class="card__list">
                    @foreach($topBlogs as $topBlog)
                        <li class="card__item m-secondary">
                            <figure class="card">
                                @if ($photo = $topBlog->getFirstMedia('photo'))
                                    <a class="card__wrapper-img" href="{{ route('blog.show', ['category' => $topBlog->category->alias, 'alias' => $topBlog->alias]) }}">
                                        <img class="card__img" src="{{ thumb($photo, 'fit', 800, 400) }}" alt="">
                                    </a>
                                @endif
                                <div class="card__info">
                                    <figcaption class="card__container m-secondary">
                                        <div class="card__date">
                                            <div class="card__date-icon"></div>
                                            <p class="card__date-text">{{ date('M d, Y', $topBlog->from_date) }}</p>
                                        </div>
                                        <h4 class="card__title">{{ $topBlog->name }}</h4>
                                        <p class="card__subtitle">{{ $topBlog->short_text }}</p>
                                    </figcaption>
                                    <a href="{{ $topBlog->getLink() }}" class="card__btn">
                                        {{ __('app.itemInfo') }}
                                    </a>
                                </div>
                            </figure>
                        </li>
                    @endforeach
                </ul>
                <div class="blog__container">
                    <a href="{{ route('blog.index') }}" class="blog__btn">
                        {{ __('app.pagination.showAll') }}
                    </a>
                </div>
            </div>
        </section>
    @endif
</x-app>
