<header class="header">
    <div class="wrapper m-secondary">
        <div class="header__wrapper">
            <nav class="nav">
                <ul class="nav__list">
                    <li class="nav__item">
                        <a href="{{ route('home') }}" class="nav__link link-1 m-active">
                            <div class="nav__link-img">
                                <object type="image/svg+xml" data="/img/logo/logo-portal.svg"></object>
                            </div> {{ config('app.name') }}
                        </a>
                    </li>
                    <li class="nav__item">
                        <a href="https://eigenheimwunsch.de" class="nav__link link_2" rel="nofollow">
                            <div class="nav__link-img">
                                <object type="image/svg+xml" data="/img/logo/logo-wunsch.svg"></object>
                            </div> EigenheimWunsch.de
                        </a>
                    </li>
                    <li class="nav__item">
                        <a href="https://eigenheiminfo.de" class="nav__link link_3" rel="nofollow">
                            <div class="nav__link-img">
                                <object type="image/svg+xml" data="/img/logo/logo-info.svg"></object>
                            </div> Eigenheiminfo.de
                        </a>
                    </li>
                </ul>
            </nav>
            <nav class="menu">
                <ul class="menu__list js-menu-list">
                    @foreach($menuItems as $menuItem)
                        <li class="menu__item @if ($menuItem->url == '/' . request()->path()) m-active @endif">
                            <a class="menu__link" href="{{ $menuItem->url }}">{{ $menuItem->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </nav>
            <div class="burger-menu js-burger-menu">
                <span></span>
            </div>
        </div>
        <x-breadcrumbs />
    </div>
</header>
