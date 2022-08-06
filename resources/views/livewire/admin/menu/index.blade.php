<x-slot:title>
    {{ __('Menus') }}
</x-slot>
<div>
    <livewire:admin.menu.table :parent="$parent"/>
</div>
