<x-slot:header>
    {{ __('Admin panel') }}
</x-slot>
<div>
    {{ __('Welcome to admin panel of :name!', ['name' => config('app.name')]) }}
</div>
