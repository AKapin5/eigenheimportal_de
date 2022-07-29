<x-layout>
    <div class="wrapper">
        <section class="sales-offers">
            <h1 class="sales-offers__title">{{ $pageTitle }}</h1>
            <p class="sales-offers__subtitle">{{ $pageDescription }}</p>
            @isset($category)
                <livewire:apartments :category="$category"/>
            @endisset
        </section>
    </div>
</x-layout>
