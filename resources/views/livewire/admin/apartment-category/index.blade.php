<x-slot:title>
    {{ __('Apartment categories') }}
    @if ($parent)
        {{ __(' - ":name"', ['name' => $parent->name]) }}
    @endif
</x-slot>
<div>
    <livewire:admin.apartment-category.table :parent="$parent"/>
</div>
