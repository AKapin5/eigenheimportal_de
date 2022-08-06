<x-app>
    <div class="wrapper">
        <section class="product">
            <div class="product__content">
                <div class="product__header">
                    <h2 class="product__header-title">{{ $apartment->name }}</h2>
                    <a href="{{ $apartment->category->getLink() }}" class="product__header-category">
                        {{ $apartment->category->name }}
                    </a>
                </div>
                @if ($photos = $apartment->getMedia('photos') AND $photos->isNotEmpty())
                    <div class="product__slider js-slick">
                        @foreach($photos as $photo)
                            <a class="product__slide slide_{{ $loop->index }}" href="{{ $photo->getUrl() }}" target="_blank">
                                <img src="{{ thumb($photo, 'fit', 800) }}" alt="">
                            </a>
                        @endforeach
                    </div>
                @endif
                <h3 class="product__title">{{ __('Beschreibung') }}</h3>
                <div class="product__info">
                    {!! $apartment->description !!}
                </div>
                <section class="features">
                    <h3 class="product__title">{{ __('Details & Funktionen') }}</h3>
                    <ul class="features__list">
                        <li class="features__item">
                            <div class="features__wrapper-icon">
                                <img class="features__icon" src="/img/icons/feature-icon_1.svg" alt="">
                            </div>
                            <div class="features__info">
                                <div class="features__info-title">{{ __('Wohnfläche') }}</div>
                                <div class="features__info-value">{{ $apartment->living_space }} m<sup>2</sup></div>
                            </div>
                        </li>
                        <li class="features__item">
                            <div class="features__wrapper-icon">
                                <img class="features__icon" src="/img/icons/feature-icon_2.svg" alt="">
                            </div>
                            <div class="features__info">
                                <div class="features__info-title">{{ __('Baujahr') }}</div>
                                <div class="features__info-value">{{ $apartment->construction_year }}</div>
                            </div>
                        </li>
                        <li class="features__item">
                            <div class="features__wrapper-icon">
                                <img class="features__icon" src="/img/icons/feature-icon_3.svg" alt="">
                            </div>
                            <div class="features__info">
                                <div class="features__info-title">{{ __('Räume') }}</div>
                                <div class="features__info-value">{{ $apartment->rooms_count }}</div>
                            </div>
                        </li>
                        <li class="features__item">
                            <div class="features__wrapper-icon">
                                <img class="features__icon" src="/img/icons/feature-icon_4.svg" alt="">
                            </div>
                            <div class="features__info">
                                <div class="features__info-title">{{ __('Heizung') }}</div>
                                <div class="features__info-value">{{ $apartment->heatingText }}</div>
                            </div>
                        </li>
                    </ul>
                </section>
                <section class="features">
                    <h3 class="product__title">{{ __('Einrichtungen') }}</h3>
                    <ul class="features__list">
                        <li class="features__item">
                            <div class="features__wrapper-icon">
                                <img class="features__icon" src="/img/icons/feature-icon_5.svg" alt="">
                            </div>
                            <div class="features__info">
                                <div class="features__info-title">{{ __('Airport') }}</div>
                                <div class="features__info-value">
                                    {{ __(':time min by car', ['time' => $apartment->airport_travel_time]) }}
                                </div>
                            </div>
                        </li>
                        <li class="features__item">
                            <div class="features__wrapper-icon">
                                <img class="features__icon" src="/img/icons/feature-icon_6.svg" alt="">
                            </div>
                            <div class="features__info">
                                <div class="features__info-title">{{ __('Autobahn') }}</div>
                                <div class="features__info-value">
                                    {{ __(':time min by car', ['time' => $apartment->highway_travel_time]) }}
                                </div>
                            </div>
                        </li>
                        <li class="features__item">
                            <div class="features__wrapper-icon">
                                <img class="features__icon" src="/img/icons/feature-icon_7.svg" alt="">
                            </div>
                            <div class="features__info">
                                <div class="features__info-title">{{ __('Krankenhaus') }}</div>
                                <div class="features__info-value">
                                    {{ __(':time min by car', ['time' => $apartment->hospital_travel_time]) }}
                                </div>
                            </div>
                        </li>
                        <li class="features__item">
                            <div class="features__wrapper-icon">
                                <img class="features__icon" src="/img/icons/feature-icon_8.svg" alt="">
                            </div>
                            <div class="features__info">
                                <div class="features__info-title">{{ __('School') }}</div>
                                <div class="features__info-value">
                                    {{ __(':time min by car', ['time' => $apartment->school_travel_time]) }}
                                </div>
                            </div>
                        </li>
                    </ul>
                </section>
                @if ($floorPlan = $apartment->getFirstMedia('floor_plan'))
                    <section class="product-plan">
                        <h3 class="product__title">{{ __('Grundrisse') }}</h3>
                        <div class="product-plan-wrapper-img">
                            <img class="product-plan-img" src="{{ thumb($floorPlan, 'fit', 800) }}" alt="">
                        </div>
                    </section>
                @endif
                @if ($attachments = $apartment->getMedia('attachments') AND $attachments->isNotEmpty())
                    <section class="download">
                        <h3 class="product__title">{{ __('Anhänge') }}</h3>
                        <ul class="download__list">
                            @foreach($attachments as $attachment)
                                <li class="download__item">
                                    <a href="{{ $attachment->getUrl() }}" download="{{ $attachment->file_name }}" class="download__link">
                                        <div class="download__img"></div>
                                        <div class="download__info">
                                            <div class="download__title">
                                                {{ $attachment->file_name }}
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </section>
                @endif
            </div>
            <aside class="product__details">
                <section class="product__details-container">
                    <h3 class="product__title">{{ __('Detail') }}</h3>
                    <div class="product__details-map">
                        {!! $apartment->location_map !!}
                    </div>
                    <ul class="product__details-list">
                        <li class="product__details-item">
                            <img src="/img/icons/geolocation.svg" alt="" class="product__details-icon">
                            <div class="product__details-info">{{ $apartment->location_address }}</div>
                        </li>
                        <li class="product__details-item">
                            <a href="tel:+16197195939" class="product__details-link">
                                <img src="/img/icons/phone.svg" alt="" class="product__details-icon">
                                <div class="product__details-info">{{ $apartment->contact_phone }}</div>
                            </a>
                        </li>
                        <li class="product__details-item">
                            <a href="mailto:info@www.seotm.net" class="product__details-link">
                                <img src="/img/icons/mail.svg" alt="" class="product__details-icon">
                                <div class="product__details-info">{{ $apartment->contact_email }}</div>
                            </a>
                        </li>
                        <li class="product__details-item">
                            <a href="{{ $apartment->contact_website }}" class="product__details-link">
                                <img src="/img/icons/Internet.svg" alt="" class="product__details-icon">
                                <div class="product__details-info">{{ $apartment->contact_website }}</div>
                            </a>
                        </li>
                    </ul>
                    <a href="#contactForm" class="product__details-btn">{{ __('Contact an agent') }}</a>
                    @if ($apartment->price)
                        <div class="product__details-price">
                            ${{ number_format($apartment->price, 2) }}
                        </div>
                    @endif
                </section>
                @if ($apartment->youtube_video)
                    <section class="product__details-video">
                        <h3 class="product__title">{{ __('Video') }}</h3>
                        <div class="product__video__wrapper">
                            {!! $apartment->youtube_video !!}
                        </div>
                    </section>
                @endif
            </aside>
        </section>
        <livewire:contact-form/>
    </div>
</x-app>
