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
                    data-transliteration="{{ (int)empty($model->translate('title', $language, false)) }}"
                    value="{{ old('title.' . $language, $model->translate('title', $language, false)) }}"
                    :attribute="'title.' . $language"
                    :model="$model"
                    :label="__('Title')" />

                <x-admin.input
                    required
                    value="{{ old('url.' . $language, $model->translate('url', $language, false)) }}"
                    :attribute="'url.' . $language"
                    :model="$model"
                    :label="__('URL')" />

            </div>
        @endforeach
    </div>

    <x-admin.checkbox
        :attribute="'status'"
        :model="$model"
        :label="__('Show')" />

    <x-admin.input
        :attribute="'sort'"
        :model="$model"
        :label="__('Sort')" />

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
