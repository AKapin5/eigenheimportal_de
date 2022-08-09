<x-app>
    <div class="wrapper">
        <section class="sales-offers">
            <h1 class="sales-offers__title">{{ $pageTitle }}</h1>
            <div class="sales-offers__subtitle">{!! $pageDescription !!}</div>
            @isset($category)
                <livewire:apartments :category="$category"/>
            @endisset
        </section>
    </div>
</x-app>
