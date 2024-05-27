<x-app>
    <div class="wrapper">
        <section class="sales-offers">
            <h1 class="sales-offers__title">{{ $pageTitle }}</h1>
            @if ($apartments->isNotEmpty())
                <ul class="card__list">
                    @foreach($apartments as $apartment)
                        @include('apartment.common._item', compact('apartment'))
                    @endforeach
                </ul>
            @endif
        </section>
    </div>
</x-app>
