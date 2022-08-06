<x-slot:title>
    {{ __('Blog categories') }}
    @if ($parent)
        {{ __(' - ":name"', ['name' => $parent->name]) }}
    @endif
</x-slot>
<div>
    <livewire:admin.blog-category.table :parent="$parent"/>
</div>
