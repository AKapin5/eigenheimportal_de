<x-slot:title>
    @if ($apartmentCategory->exists)
        {{ __('Edit apartment category ":name"', ['name' => $apartmentCategory->name]) }}
    @else
        {{ __('Create apartment category') }}
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
                    :attribute="'apartmentCategory.name.' . $language"
                    :model="$apartmentCategory"
                    :label="__('Name')" />

                <x-admin.form.input
                    :attribute="'apartmentCategory.alias.' . $language"
                    :model="$apartmentCategory"
                    :label="__('Alias')" />

                <x-admin.form.textarea
                    :attribute="'apartmentCategory.description.' . $language"
                    :model="$apartmentCategory"
                    :label="__('Description')"
                    :type="'tinymce'">
                </x-admin.form.textarea>

                <x-admin.form.input
                    :attribute="'apartmentCategory.seo_title.' . $language"
                    :model="$apartmentCategory"
                    :label="__('SEO Title')"/>

                <x-admin.form.textarea
                    :attribute="'apartmentCategory.seo_description.' . $language"
                    :model="$apartmentCategory"
                    :label="__('SEO Description')">
                </x-admin.form.textarea>

                <x-admin.form.textarea
                    :attribute="'apartmentCategory.seo_keywords.' . $language"
                    :model="$apartmentCategory"
                    :label="__('SEO Keywords')">
                </x-admin.form.textarea>

            </div>
        @endforeach
    </div>

    <x-admin.form.select
        :type="'select2'"
        :placeholder="''"
        :attribute="'apartmentCategory.parent_id'"
        :options="$categoryOptions"
        :model="$apartmentCategory"
        :label="__('Parent')" />

    <x-admin.form.checkbox
        :attribute="'apartmentCategory.status'"
        :model="$apartmentCategory"
        :label="__('Show')" />

    <x-admin.form.input
        :attribute="'apartmentCategory.sort'"
        :model="$apartmentCategory"
        :label="__('Sort')" />

    <x-admin.form.file
        :model="$apartmentCategory"
        :attribute="'photo'"
        :label="__('Photo')" />

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
