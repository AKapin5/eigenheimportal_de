<x-app>
    <div class="wrapper m-secondary">
        <section class="sales-offers">
            <h1 class="sales-offers__title">{{ $pageTitle }}</h1>
            <div class="sales-offers__subtitle">{!! $pageDescription !!}</div>
            <div class="sales-offers__category-links">
                <div class="sales-offers__category-links__inner">
                    @foreach($categoryLinks as $categoryLink)
                        <a  href="{{ route('apartment.index', ['path' => $categoryLink['path']]) }}"
                            class="sales-offers__category-link
                        @if ($categoryLink['active']) active @endif">
                            <span class="icon" style="mask-image: url('/img/icons/categories/{{ $categoryLink['icon'] }}.svg')"></span>
                            {{ $categoryLink['name'] }}
                        </a>
                    @endforeach
                </div>
            </div>
            <livewire:apartments :template="'alternate'" :category="$category"/>
        </section>
    </div>
</x-app>
