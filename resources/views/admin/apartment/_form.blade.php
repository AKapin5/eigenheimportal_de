<form action="{{ $action }}" method="post" enctype="multipart/form-data">
    @csrf
    @method($method)

    <ul class="nav nav-tabs" id="tabs" role="tablist">
        @foreach($languages as $language)
            <li class="nav-item">
                <a class="nav-link @if ($loop->index == 0) active @endif" id="tab-{{ $language }}" data-toggle="tab"
                   href="#tab-content-{{ $language }}" role="tab" aria-controls="home" aria-selected="true">
                    {{ Str::upper($language) }}
                </a>
            </li>
        @endforeach
    </ul>
    <div class="tab-content" id="localFields">
        @foreach($languages as $language)
            <div class="tab-pane fade show @if ($loop->index == 0) active @endif" id="tab-content-{{ $language }}"
                 role="tabpanel" aria-labelledby="tab-{{ $language }}">
                <x-admin.input
                    required
                    data-transliteration="{{ (int)empty($model->translate('alias', $language, false)) }}"
                    value="{{ old('title.' . $language, $model->translate('name', $language, false)) }}"
                    :attribute="'name.' . $language"
                    :model="$model"
                    :label="__('Name')" />

                <x-admin.input
                    required
                    data-slug
                    value="{{ old('alias.' . $language, $model->translate('alias', $language, false)) }}"
                    :attribute="'alias.' . $language"
                    :model="$model"
                    :label="__('Alias')" />

                <x-admin.textarea
                    class="editor"
                    :attribute="'description.' . $language"
                    :model="$model"
                    :label="__('Description')">
                    {{ old('content.' . $language, $model->translate('description', $language, false)) }}
                </x-admin.textarea>

                <x-admin.input
                    value="{{ old('seo_title.' . $language, $model->translate('seo_title', $language, false)) }}"
                    :attribute="'seo_title.' . $language"
                    :model="$model"
                    :label="__('SEO title')" />

                <x-admin.textarea
                    :attribute="'seo_description.' . $language"
                    :model="$model"
                    :label="__('SEO description')">
                    {{ old('seo_description.' . $language, $model->translate('seo_description', $language, false)) }}
                </x-admin.textarea>

                <x-admin.textarea
                    :attribute="'seo_keywords.' . $language"
                    :model="$model"
                    :label="__('SEO keywords')">
                    {{ old('seo_keywords.' . $language, $model->translate('seo_keywords', $language, false)) }}
                </x-admin.textarea>

            </div>
        @endforeach
    </div>

    <x-admin.checkbox
        :attribute="'status'"
        :model="$model"
        :label="__('Show')" />

    <x-admin.select
        :attribute="'category_id'"
        :model="$model"
        :options="$categoryOptions"
        :label="__('Category')"
        :class="'select2'"
        :placeholder="''" />

    <x-admin.file
        multiple
        :model="$model"
        :attribute="'photos'"
        :label="__('Photos')" />

    <div class="card">
        <div class="card-body">
            <h4>
                {{ __('Features') }}
            </h4>
            <div class="row">
                <div class="col-md-3">
                    <x-admin.input
                        :attribute="'living_space'"
                        :model="$model"
                        :label="__('Living space m2')"
                        :placeholder="''"
                    />
                </div>
                <div class="col-md-3">
                    <x-admin.input
                        :attribute="'construction_year'"
                        :model="$model"
                        :label="__('Year of construction')"
                        :placeholder="''"
                    />
                </div>
                <div class="col-md-3">
                    <x-admin.input
                        :attribute="'rooms_count'"
                        :model="$model"
                        :label="__('Rooms count')"
                        :placeholder="''"
                    />
                </div>
                <div class="col-md-3">
                    <x-admin.select
                        :attribute="'heating'"
                        :model="$model"
                        :options="$heatingOptions"
                        :label="__('Heating')"
                        :placeholder="''"
                    />
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <x-admin.input
                        :attribute="'airport_travel_time'"
                        :model="$model"
                        :label="__('Airport distance (min)')"
                        :placeholder="''"
                    />
                </div>
                <div class="col-md-3">
                    <x-admin.input
                        :attribute="'highway_travel_time'"
                        :model="$model"
                        :label="__('Highway distance (min)')"
                        :placeholder="''"
                    />
                </div>
                <div class="col-md-3">
                    <x-admin.input
                        :attribute="'hospital_travel_time'"
                        :model="$model"
                        :label="__('Hospital distance (min)')"
                        :placeholder="''"
                    />
                </div>
                <div class="col-md-3">
                    <x-admin.input
                        :attribute="'school_travel_time'"
                        :model="$model"
                        :label="__('School distance (min)')"
                        :placeholder="''"
                    />
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <x-admin.input
                        :attribute="'contact_phone'"
                        :model="$model"
                        :label="__('Contact phone')"
                        :placeholder="''"
                    />
                </div>
                <div class="col-md-3">
                    <x-admin.input
                        :attribute="'contact_email'"
                        :model="$model"
                        :label="__('Contact e-mail')"
                        :placeholder="''"
                    />
                </div>
                <div class="col-md-3">
                    <x-admin.input
                        :attribute="'$contact_website'"
                        :model="$model"
                        :label="__('Contact website')"
                        :placeholder="''"
                    />
                </div>
                <div class="col-md-3">
                    <x-admin.input
                        :attribute="'location_address'"
                        :model="$model"
                        :label="__('Location address')"
                        :placeholder="''"
                    />
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <x-admin.textarea
                        :attribute="'location_map'"
                        :model="$model"
                        :label="__('Location map')"
                        :placeholder="''"
                    />
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <button type="submit" name="save" class="btn btn-primary">{{ __('Save') }}</button>
        <button type="submit" name="save_and_return" class="btn btn-success">{{ __('Save & return') }}</button>
        @if ($return_url)
            <a href="{{ $return_url }}" class="btn btn-default">
                {{ __('Back') }}
            </a>
        @endif
    </div>
</form>
