<x-layout>
    <section class="banner-hero">
        <div class="banner-hero__bg">
            <div class="wrapper m-secondary">
                <div class="banner-hero__wrapper">
                    <div class="banner-hero__info">
                        <h1 class="banner-hero__title"> {{ __('Gestalten Sie Ihre Zukunft selbst.') }} </h1>
                        <p class="banner-hero__text"> {{ __('Die passenden Lösungen gibt es bei uns!') }} </p>
                        <a href="{{ route('apartment.index') }}" class="banner-hero__btn"> {{ __('Objekte') }} </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="info">
        <div class="wrapper">
            <h2 class="info__title"> {{ __('Wie verkaufe ich meine Immobilie selbst') }} </h2>
            <ul class="info__list">
                <li class="info__item">
                    <div class="info__item-wrapper-img">
                        <img class="info__item-img" src="/img/icons/layout.svg" alt="">
                    </div>
                    <p class="info__item-text">
                        {{ __('Richten Sie ihre bestehenden Unterlagen zum Objekt: wie Pläne, Grundrisse, Höhenschnitt, Ansichten, Wohnflächen-berechnung und Kubatur-Berechnung. Wichtig zu bedenken ist, dass beim Verkaufspreis der von Ihnen ausgewählte Käufer Kosten wie Grunderwerbsteuer (je nach Bundesland ca. 5%) und Notar + Eintragungskosten (ca. 2%) tragen muss.') }}
                    </p>
                </li>
                <li class="info__item">
                    <div class="info__item-wrapper-img">
                        <img class="info__item-img" src="/img/icons/house-document.svg" alt="">
                    </div>
                    <p class="info__item-text">
                        {{ __('Machen Sie eine hochwertige Objektbeschreibung: Lage des Objekts, welche Einkaufsmöglichkeiten es gibt, Entfernung zu den Kindergärten und Schulen, wie sind diese erreichbar. Farbbilder von Küche, Bad Wohnzimmer, eventuell Garage. Auch alle Außen-Fotos der Immobilie sind wichtig und selbstverständlich der Garten.') }}
                    </p>
                </li>
                <li class="info__item">
                    <div class="info__item-wrapper-img">
                        <img class="info__item-img" src="/img/icons/house-reports.svg" alt="">
                    </div>
                    <p class="info__item-text">
                        {{ __('Besuchen Sie unsere Seite Eigenheiminfo.de und machen Sie eine Objektbewertung ihres Hauses oder Wohnung. Damit erhalten Sie einen aktuellen Marktwert, den Sie mit ihrem Wunschpreis vergleichen sollten. Dann können Sie sich Gedanken machen zu welchem Preis sie die Wohnung oder das Haus verkaufen möchten.') }}
                    </p>
                </li>
                <li class="info__item">
                    <div class="info__item-wrapper-img">
                        <img class="info__item-img" src="/img/icons/house-building.svg" alt="">
                    </div>
                    <p class="info__item-text">
                        {{ __('Eine kosmetische Aufwertung ihrer Immobilie macht immer Sinn. Der erste Eindruck des Objektes auf den Fotos und bei der Besichtigung kann einen höheren Verkaufspreis ermöglichen. Deshalb machen Sie sich Gedanken, ob die von Ihnen gemachte Bilder das Interesse des potenziellen Käufers steigern.') }}
                    </p>
                </li>
                <li class="info__item">
                    <div class="info__item-wrapper-img">
                        <img class="info__item-img" src="/img/icons/laptop.svg" alt="">
                    </div>
                    <p class="info__item-text">
                        {{ __('Wenn alle Unterlagen gerichtet und eingescannt sind und ihre Wertermittlung auch abgeschlossen ist, sollten Sie die Immobilie auf ein ihnen bekanntes Internetportal stellen. Selbstverständlich können wir Ihnen in dieser Situation unsere Hilfe anbieten und mit Ihnen gemeinsam den passenden Partner aussuchen und die Daten eingeben.') }}
                    </p>
                </li>
                <li class="info__item">
                    <div class="info__item-wrapper-img">
                        <img class="info__item-img" src="/img/icons/house-keys.svg" alt="">
                    </div>
                    <p class="info__item-text">
                        {{ __('Sobald sie und der neue Eigentümer sich einig sind, sollte der Käufer Ihnen eine Finanzierungsbestätigung seitens seiner Bank vorlegen damit sie sicher sind, dass er sich ihre') }}
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
                        {{ __('Wir begleiten unsere Business Kunden und Kapitalanleger durch den gesamten Prozess.') }}
                    </h2>
                    <ul class="progression__list">
                        <li class="progression__item">
                            <div class="progression__item-icon">
                                <span>1</span>
                            </div>
                            <div class="progression__item-text">
                                <h3 class="progression__item-title">{{ __('Projekt') }}</h3>
                                <p class="progression__item-subtitle">
                                    {{ __('Sie entscheiden sich für ein Objekt aus unserem Portfolio oder haben eine andere Immobilie in Aussicht. Über die Kontaktfunktion vereinbaren sie ein Termin mit unserem Team') }}
                                </p>
                            </div>
                        </li>
                        <li class="progression__item">
                            <div class="progression__item-icon">
                                <span>2</span>
                            </div>
                            <div class="progression__item-text">
                                <h3 class="progression__item-title">{{ __('Analysegespräch') }}</h3>
                                <p class="progression__item-subtitle">
                                    {{ __('Es erfolgt eine individuelle Analyse Ihrer persönlichen Situation durch unser Team, dabei werden Ihre Ziele und Wünsche festgehalten') }}
                                </p>
                            </div>
                        </li>
                        <li class="progression__item">
                            <div class="progression__item-icon">
                                <span>3</span>
                            </div>
                            <div class="progression__item-text">
                                <h3 class="progression__item-title">{{ __('Informationen') }}</h3>
                                <p class="progression__item-subtitle">
                                    {{ __('Unsere Kooperationspartner erstellen eine Steuerliche- und eine Renditeberechnung für einen bestimmten Zeitraum. Dabei wird auch das Einsparpotenzial während der Kaufabwicklung berücksichtigt') }}
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
                                <h3 class="progression__item-title">{{ __('Projekt') }}</h3>
                                <p class="progression__item-subtitle">
                                    {{ __('Sie entscheiden sich für ein Objekt aus unserem Portfolio oder haben eine andere Immobilie in Aussicht. Über die Kontaktfunktion vereinbaren sie ein Termin mit unserem Team') }}
                                </p>
                            </div>
                        </li>
                        <li class="progression__item">
                            <div class="progression__item-icon">
                                <span>5</span>
                            </div>
                            <div class="progression__item-text">
                                <h3 class="progression__item-title">{{ __('Analysegespräch') }}</h3>
                                <p class="progression__item-subtitle">
                                    {{ __('Es erfolgt eine individuelle Analyse Ihrer persönlichen Situation durch unser Team, dabei werden Ihre Ziele und Wünsche festgehalten') }}
                                </p>
                            </div>
                        </li>
                        <li class="progression__item">
                            <div class="progression__item-icon">
                                <span>6</span>
                            </div>
                            <div class="progression__item-text">
                                <h3 class="progression__item-title">{{ __('Informationen') }}</h3>
                                <p class="progression__item-subtitle">
                                    {{ __('Unsere Kooperationspartner erstellen eine Steuerliche- und eine Renditeberechnung für einen bestimmten Zeitraum. Dabei wird auch das Einsparpotenzial während der Kaufabwicklung berücksichtigt') }}
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
        <section class="real-estate">
            <div class="wrapper">
                <h2 class="real-estate-title">{{ __('TOP Immobilien') }}</h2>
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
                                        {{ __('Mehr Info') }}
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
                <h2 class="blog__title">{{ __('Blog') }}</h2>
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
                                    <a href="{{ route('blog.show', ['category' => $topBlog->category->alias, 'alias' => $topBlog->alias]) }} }}"
                                       class="card__btn">
                                        {{ __('Mehr Info') }}
                                    </a>
                                </div>
                            </figure>
                        </li>
                    @endforeach
                </ul>
                <div class="blog__container">
                    <a href="{{ route('blog.index') }}" class="blog__btn">
                        {{ __('Alles sehen') }}
                    </a>
                </div>
            </div>
        </section>
    @endif
</x-layout>
