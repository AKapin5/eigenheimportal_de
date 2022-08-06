<x-slot:title>
    @if ($blog->exists)
        {{ __('Edit blog ":name"', ['name' => $blog->name]) }}
    @else
        {{ __('Create blog') }}
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
                    :attribute="'blog.name.' . $language"
                    :model="$blog"
                    :label="__('Name')" />

                <x-admin.form.input
                    :attribute="'blog.alias.' . $language"
                    :model="$blog"
                    :label="__('Alias')" />

                <x-admin.form.textarea
                    :attribute="'blog.short_text.' . $language"
                    :model="$blog"
                    :label="__('Short text')">
                </x-admin.form.textarea>

                <x-admin.form.textarea
                    :attribute="'blog.description.' . $language"
                    :model="$blog"
                    :label="__('Description')"
                    :type="'tinymce'">
                </x-admin.form.textarea>

                <x-admin.form.input
                    :attribute="'blog.seo_title.' . $language"
                    :model="$blog"
                    :label="__('SEO Title')"/>

                <x-admin.form.textarea
                    :attribute="'blog.seo_description.' . $language"
                    :model="$blog"
                    :label="__('SEO Description')">
                </x-admin.form.textarea>

                <x-admin.form.textarea
                    :attribute="'blog.seo_keywords.' . $language"
                    :model="$blog"
                    :label="__('SEO Keywords')">
                </x-admin.form.textarea>

            </div>
        @endforeach
    </div>

    <x-admin.form.checkbox
        :attribute="'blog.status'"
        :model="$blog"
        :label="__('Show')" />

    <x-admin.form.checkbox
        :attribute="'blog.is_top'"
        :model="$blog"
        :label="__('Is top')" />

    <x-admin.form.select
        :type="'select2'"
        :placeholder="''"
        :attribute="'blog.category_id'"
        :options="$categoryOptions"
        :model="$blog"
        :label="__('Category')" />


    <x-admin.form.file
        :model="$blog"
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
