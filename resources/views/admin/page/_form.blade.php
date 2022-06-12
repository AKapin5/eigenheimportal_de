<form action="{{ $action }}" method="post" enctype="multipart/form-data">
    @csrf
    @method($method)

    <x-admin.checkbox
        :attribute="'status'"
        :model="$model"
        :label="__('Отображать')" />

    <x-admin.file
        multiple
        :model="$model"
        :attribute="'attachments'"
        :label="__('Файлы')" />

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
                    value="{{ old('name.' . $language, $model->translate('name', $language, false)) }}"
                    :attribute="'name.' . $language"
                    :model="$model"
                    :label="__('Название')" />

                <x-admin.input
                    required
                    data-slug
                    value="{{ old('alias.' . $language, $model->translate('alias', $language, false)) }}"
                    :attribute="'alias.' . $language"
                    :model="$model"
                    :label="__('Алиас')" />

                <x-admin.textarea
                    class="editor"
                    :attribute="'content.' . $language"
                    :model="$model"
                    :label="__('Описание')">
                    {{ old('content.' . $language, $model->translate('content', $language, false)) }}
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

    <div class="form-group">
        <button type="submit" name="save" class="btn btn-primary">{{ __('Сохранить') }}</button>
        <button type="submit" name="save_and_return" class="btn btn-success">{{ __('Сохранить и вернуться') }}</button>
        @if ($return_url)
            <a href="{{ $return_url }}" class="btn btn-default">
                {{ __('Вернуться') }}
            </a>
        @endif
    </div>
</form>
