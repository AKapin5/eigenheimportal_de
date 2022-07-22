<x-layout>
    <div class="wrapper">
        <div class="advertising">
            <h1 class="advertising__title">{{ $pageTitle }}</h1>
            <p class="advertising__subtitle">{{ $pageDescription }}</p>

            @if ($subCategories->isNotEmpty())
                <ul class="advertising__list">
                    @foreach($subCategories as $subCategory)
                        <li class="advertising__item">
                            <a class="advertising__item-wrapper-img" href="{{ $subCategory->getLink() }}">
                                @if ($photo = $subCategory->getFirstMedia('photo'))
                                    <img class="advertising__item-img" src="{{ thumb($photo, 'fit', 600) }}" alt="">
                                @endif
                            </a>
                            <div class="advertising__info">
                                <h2 class="advertising__info-title">{{ $subCategory->name }}</h2>
                                <div class="advertising__info-subtitle">
                                    {{ nl2br($subCategory->description) }}
                                </div>
                                @if ($subCategory->children->isNotEmpty())
                                    <div class="advertising__info-category">
                                        @foreach($subCategory->activeChildren as $child)
                                            <a href="{{ $child->getLink() }}" class="advertising__info-link">{{ $child->name }}</a>
                                        @endforeach
                                    </div>
                                @endif
                                <a href="{{ $subCategory->getLink() }}" class="advertising__info-btn">{{ __('Mehr Info') }}</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-layout>
