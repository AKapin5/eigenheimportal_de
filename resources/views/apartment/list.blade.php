<x-layout>
    <div class="wrapper">
        <section class="sales-offers">
            <h1 class="sales-offers__title">{{ $pageTitle }}</h1>
            <p class="sales-offers__subtitle">{{ $pageDescription }}</p>

            <livewire:apartments :category="$category"/>
        </section>
    </div>
</x-layout>
