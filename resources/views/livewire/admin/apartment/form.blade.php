<x-slot:title>
    @if ($apartment->exists)
        {{ __('Edit apartment ":name"', ['name' => $apartment->name]) }}
    @else
        {{ __('Create apartment') }}
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
                    :attribute="'apartment.name.' . $language"
                    :model="$apartment"
                    :label="__('Name')" />

                <x-admin.form.input
                    :attribute="'apartment.alias.' . $language"
                    :model="$apartment"
                    :label="__('Alias')" />

                <x-admin.form.textarea
                    :attribute="'apartment.short_text.' . $language"
                    :model="$apartment"
                    :label="__('Short text')">
                </x-admin.form.textarea>

                <x-admin.form.textarea
                    :attribute="'apartment.description.' . $language"
                    :model="$apartment"
                    :label="__('Description')"
                    :type="'tinymce'">
                </x-admin.form.textarea>

                <x-admin.form.input
                    :attribute="'apartment.seo_title.' . $language"
                    :model="$apartment"
                    :label="__('SEO Title')"/>

                <x-admin.form.textarea
                    :attribute="'apartment.seo_description.' . $language"
                    :model="$apartment"
                    :label="__('SEO Description')">
                </x-admin.form.textarea>

                <x-admin.form.textarea
                    :attribute="'apartment.seo_keywords.' . $language"
                    :model="$apartment"
                    :label="__('SEO Keywords')">
                </x-admin.form.textarea>

            </div>
        @endforeach
    </div>

    <x-admin.form.checkbox
        :attribute="'apartment.status'"
        :model="$apartment"
        :label="__('Show')" />

    <x-admin.form.checkbox
        :attribute="'apartment.is_top'"
        :model="$apartment"
        :label="__('Is top')" />

    <x-admin.form.checkbox
        :attribute="'apartment.is_reference'"
        :model="$apartment"
        :label="__('Is reference')" />

    <x-admin.form.input
        :attribute="'apartment.price'"
        :model="$apartment"
        :label="__('Price $')" />

    <x-admin.form.select
        :type="'select2'"
        :placeholder="''"
        :attribute="'apartment.category_id'"
        :options="$categoryOptions"
        :model="$apartment"
        :label="__('Category')" />

    <x-admin.form.file
        :model="$apartment"
        :attribute="'floor_plan'"
        :label="__('Floor plan')" />

    <x-admin.form.file
        multiple
        :model="$apartment"
        :attribute="'photos'"
        :label="__('Photos')" />

    <x-admin.form.file
        multiple
        :model="$apartment"
        :attribute="'attachments'"
        :label="__('Attachments')" />

    <div class="card">
        <div class="card-body">
            <h4>
                {{ __('Features') }}
            </h4>
            <div class="row">
                <div class="col-md-3">
                    <x-admin.form.input
                        :attribute="'apartment.living_space'"
                        :model="$apartment"
                        :label="__('Living space m2')"
                    />
                </div>
                <div class="col-md-3">
                    <x-admin.form.input
                        :attribute="'apartment.construction_year'"
                        :model="$apartment"
                        :label="__('Year of construction')"
                    />
                </div>
                <div class="col-md-3">
                    <x-admin.form.input
                        :attribute="'apartment.rooms_count'"
                        :model="$apartment"
                        :label="__('Rooms count')"
                    />
                </div>
                <div class="col-md-3">
                    <x-admin.form.select
                        :attribute="'apartment.heating'"
                        :model="$apartment"
                        :options="$heatingOptions"
                        :label="__('Heating')"
                        :placeholder="''"
                    />
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <x-admin.form.input
                        :attribute="'apartment.airport_travel_time'"
                        :model="$apartment"
                        :label="__('Airport distance (min)')"
                    />
                </div>
                <div class="col-md-3">
                    <x-admin.form.input
                        :attribute="'apartment.highway_travel_time'"
                        :model="$apartment"
                        :label="__('Highway distance (min)')"
                    />
                </div>
                <div class="col-md-3">
                    <x-admin.form.input
                        :attribute="'apartment.hospital_travel_time'"
                        :model="$apartment"
                        :label="__('Hospital distance (min)')"
                    />
                </div>
                <div class="col-md-3">
                    <x-admin.form.input
                        :attribute="'apartment.school_travel_time'"
                        :model="$apartment"
                        :label="__('School distance (min)')"
                    />
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <x-admin.form.input
                        :attribute="'apartment.contact_phone'"
                        :model="$apartment"
                        :label="__('Contact phone')"
                    />
                </div>
                <div class="col-md-3">
                    <x-admin.form.input
                        :attribute="'apartment.contact_email'"
                        :model="$apartment"
                        :label="__('Contact e-mail')"
                    />
                </div>
                <div class="col-md-3">
                    <x-admin.form.input
                        :attribute="'apartment.contact_website'"
                        :model="$apartment"
                        :label="__('Contact website')"
                    />
                </div>
                <div class="col-md-3">
                    <x-admin.form.input
                        :attribute="'apartment.location_address'"
                        :model="$apartment"
                        :label="__('Location address')"
                    />
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <x-admin.form.input
                        :attribute="'apartment.location_map'"
                        :model="$apartment"
                        :label="__('Location map (frame)')"
                    />
                </div>
                <div class="col-md-6">
                    <x-admin.form.input
                        :attribute="'apartment.youtube_video'"
                        :model="$apartment"
                        :label="__('Youtube video (frame)')"
                    />
                </div>
            </div>
        </div>
    </div>

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
