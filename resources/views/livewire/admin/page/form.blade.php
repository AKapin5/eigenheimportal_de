<x-slot:title>
    @if ($page->exists)
        {{ __('Edit page ":title"', ['title' => $page->title]) }}
    @else
        {{ __('Create a page') }}
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
                    :attribute="'page.title.' . $language"
                    :model="$page"
                    :label="__('Title')" />

                <x-admin.form.input
                    :attribute="'page.alias.' . $language"
                    :model="$page"
                    :label="__('Alias')" />

                <x-admin.form.textarea
                    :attribute="'page.content.' . $language"
                    :model="$page"
                    :label="__('Content')"
                    :type="'tinymce'">
                </x-admin.form.textarea>

                <x-admin.form.input
                    :attribute="'page.seo_title.' . $language"
                    :model="$page"
                    :label="__('SEO Title')"/>

                <x-admin.form.textarea
                    :attribute="'page.seo_description.' . $language"
                    :model="$page"
                    :label="__('SEO Description')">
                </x-admin.form.textarea>

                <x-admin.form.textarea
                    :attribute="'page.seo_keywords.' . $language"
                    :model="$page"
                    :label="__('SEO Keywords')">
                </x-admin.form.textarea>

            </div>
        @endforeach
    </div>

    <x-admin.form.checkbox
        :attribute="'page.status'"
        :model="$page"
        :label="__('Show')" />

    <x-admin.form.file
        :model="$page"
        :attribute="'photo'"
        :label="__('Photo')" />

    <x-admin.form.file
        multiple
        :model="$page"
        :attribute="'attachments'"
        :label="__('Attachments')" />

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
