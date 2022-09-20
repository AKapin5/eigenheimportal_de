<footer class="footer">
    <div class="footer__top">
        <div class="wrapper m-secondary">
            <div class="footer__container">
                <div class="footer__item">
                    <a href="{{ route('home') }}" class="footer__item-link">
                        <div class="footer__item-img">
                            <object type="image/svg+xml" data="/img/logo/logo-footer.svg"></object>
                        </div> {{ config('app.name') }}
                    </a>
                    <p class="footer__item-text">
                        {{ __('Gestalten Sie Ihre Zukunft selbst. Die passenden Lösungen gibt es bei uns!') }}
                    </p>
                    <a href="#" class="footer__social">
                        <div class="footer__social-icon-wrapper">
                            <img src="/img/icons/facebook.svg" alt="" class="footer__social-icon">
                        </div>
                        <span class="footer__social-text">{{ __('Impressum') }}</span>
                        <span class="footer__social-text">{{ __('Datenschutzerklärung') }}</span>
                    </a>
                </div>
                <div class="footer__quick-nav">
                    <h5 class="footer__title">{{ __('Schnelle Links') }}</h5>
                    <ul class="footer__quick-nav-list">
                        @foreach($menuItems as $menuItem)
                            <li class="footer__quick-nav-item">
                                <a href="{{ $menuItem->url }}" class="footer__link">{{ $menuItem->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="footer__data">
                    <h5 class="footer__title">{{ __('Data') }}</h5>
                    <ul class="footer__data-list">
                        @foreach($topBlogs as $topBlog)
                            <li class="footer__data-item">
                                <a href="{{ $topBlog->getLink() }}" class="footer__data-link">{{ $topBlog->name }}</a>
                            </li>
                        @endforeach
                        <li class="footer__data-item">
                            <a href="/blog" class="footer__data-link m-secondary">
                                {{ __('Alles sehen') }}
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="footer__services">
                    <h5 class="footer__title">{{ __('Unsere Leistungen') }}</h5>
                    <a href="{{ route('home') }}" class="footer__services-link link_1">{{ config('app.name') }}</a>
                    <p class="footer__services-text">{{ __('Finanzieren Sie Ihr Eigenheim schnell und unkompliziert!') }}</p>
                    <a href="https://eigenheiminfo.de" rel="nofollow" class="footer__services-link link_2">{{ __('EigenheimInfo.de') }}</a>
                    <p class="footer__services-text">{{ __('Berechnen Sie den Wert Ihrer Immobilie schnell und unkompliziert!') }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="footer__bottom">
        <div class="wrapper m-secondary">
            <div class="footer__copy"> {{ __('Copyright :year © :name', ['year' => date('Y'), 'name' => config('app.name')]) }} </div>
        </div>
    </div>
</footer>
