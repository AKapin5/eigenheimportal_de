<x-slot:title>
    {{ __('Apartments') }}
    @isset ($category)
        {{ __(' in ":name"', ['name' => $category->name]) }}
    @endif
</x-slot>
<div>
    <livewire:admin.apartment.table :category="$category"/>
</div>
