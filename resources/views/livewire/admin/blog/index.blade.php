<x-slot:title>
    {{ __('Blogs') }}
    @isset ($category)
        {{ __(' in ":name"', ['name' => $category->name]) }}
    @endif
</x-slot>
<div>
    <livewire:admin.blog.table :category="$category"/>
</div>
