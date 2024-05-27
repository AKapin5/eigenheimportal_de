<div>
    @if ($apartments->isNotEmpty())
        <ul class="card__list {{ $template }}">
            @foreach($apartments as $apartment)
                @include("apartment.$template._item")
            @endforeach
        </ul>
    @endif
    @if ($hasMore)
        <button class="sales-offers__btn" wire:click="loadItems">
            {{ __('app.pagination.showMore') }}
        </button>
    @endif
</div>
