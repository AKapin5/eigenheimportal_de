<x-slot:title>
    @if ($menu->exists)
        {{ __('Edit menu item ":name"', ['name' => $menu->name]) }}
    @else
        {{ __('Create menu item') }}
    @endif
</x-slot>
<form wire:submit.prevent="store()" method="post" enctype="multipart/form-data">
    @if($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <ul class="nav nav-tabs" id="tabs" role="tablist">
        @foreach($languages as $language)
            <li wire:ignore class="nav-item">
                <a class="nav-link @if ($loop->index == 0) active @endif" id="tab-{{ $language }}" data-bs-toggle="tab"
                   href="#tab-content-{{ $language }}" role="tab" aria-controls="home" aria-selected="true">
                    {{ Str::upper($language) }}
                </a>
            </li>
        @endforeach
    </ul>

    <div class="tab-content">
        @foreach($languages as $language)
            <div wire:ignore.self
                 class="tab-pane fade show @if ($loop->index == 0) active @endif"
                 id="tab-content-{{ $language }}"
                 role="tabpanel" aria-labelledby="tab-{{ $language }}">

                <x-admin.form.input
                    :attribute="'menu.title.' . $language"
                    :model="$menu"
                    :label="__('Title')" />

                <x-admin.form.input
                    :attribute="'menu.url.' . $language"
                    :model="$menu"
                    :label="__('URL')" />

            </div>
        @endforeach
    </div>

    <x-admin.form.select
        :type="'select2'"
        :placeholder="''"
        :attribute="'menu.parent_id'"
        :options="$menuOptions"
        :model="$menu"
        :label="__('Parent')" />

    <x-admin.form.select
        :type="'select2'"
        :attribute="'menu.status'"
        :options="$statusOptions"
        :model="$menu"
        :label="__('Show')" />

    <x-admin.form.input
        :attribute="'menu.sort'"
        :model="$menu"
        :label="__('Sort')" />

    <div class="mb-3">
        <button type="submit" wire:click="$set('_stay', false)" class="btn btn-success">
            {{ __('Save') }}
        </button>
        <button type="submit" class="btn btn-primary" wire:click="$set('_stay', true)">
            {{ __('Save and return') }}
        </button>
        @if ($_return)
            <a href="{{ $_return }}" class="btn btn-secondary">{{ __('← Back') }}</a>
        @endif
    </div>
</form>
