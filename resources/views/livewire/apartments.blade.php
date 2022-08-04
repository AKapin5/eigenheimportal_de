<div>
    @if ($apartments->isNotEmpty())
        <ul class="card__list">
            @foreach($apartments as $apartment)
                @include('apartment._item', compact('apartment'))
            @endforeach
        </ul>
    @endif
    @if ($hasMore)
        <button class="sales-offers__btn" wire:click="loadItems">
            {{ __('app.pagination.showMore') }}
        </button>
    @endif
</div>
