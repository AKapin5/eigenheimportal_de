@props(['model', 'attribute', 'label', 'placeholder'])

<div class="file-uploader">
    <label for="{{ shorten($model) }}-{{ $attribute }}">{{ $label }}</label>
    @if ($attributes->get('multiple'))
        <div class="form-group table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th>{{ __('ID') }}</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('MIME type') }}</th>
                    <th>{{ __('Size') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody class="sortable" data-sort-url="{{ route('admin.files.sort') }}">
                    @foreach($model->getMedia($attribute) as $file)
                        <tr class="file-item" data-id="{{ $file->id }}">
                            <td class="handle">
                                <span class="fa fa-align-justify"></span>
                            </td>
                            <td>
                                @if ($thumb = thumb($file, 'fit', 100))
                                    <img src="{{ $thumb }}" alt="">
                                @endif
                            </td>
                            <td>
                                {{ $file->id }}
                            </td>
                            <td>
                                <a download href="{{ $file->getFullUrl() }}">
                                    {{ $file->file_name }}
                                </a>
                            </td>
                            <td>
                                {{ $file->mime_type }}
                            </td>
                            <td>
                                {{ formatBytes($file->size) }}
                            </td>
                            <td>
                                <a href="{{ route('admin.files.remove', ['uuid' => $file->uuid]) }}"
                                   class="btn btn-danger"
                                   data-confirm-text="{{ __('Are you sure you want to delete this file?') }}"
                                   data-remove-file>
                                    {{ __('Delete') }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="form-group">
            <div class="custom-file">
                <input type="file"
                       id="{{ shorten($model) }}-{{ $attribute }}"
                       name="{{ shorten($model) }}{{ dot2Brackets($attribute) }}[]"
                       class="custom-file-input @error(shorten($model) . ".$attribute.*") is-invalid @enderror" {{ $attributes }}>
                @error(shorten($model) . ".$attribute.*")
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <span class="custom-file-label" data-browse="{{ __('Browse') }}">
                    {{ $placeholder ?? __('Select files') }}
                </span>
            </div>
        </div>
    @else
        @if ($file = $model->getFirstMedia($attribute))
            <div class="file-item single form-group @if ($thumb = thumb($file, 'fit', 200)) image @endif">
                <a download href="{{ $file->getFullUrl() }}">
                    @if ($thumb)
                        <img src="{{ $thumb }}" alt="">
                    @else
                        {{ $file->file_name }}
                    @endif
                </a>
                <a href="{{ route('admin.files.remove', ['uuid' => $file->uuid]) }}"
                   title="{{ __('Delete file') }}"
                   data-confirm-text="{{ __('Are you sure you want to delete this file?') }}"
                   data-remove-file>
                    <span class="fa fa-trash"></span>
                </a>
            </div>
        @endif
        <div class="form-group">
            <div class="custom-file">
                <input type="file"
                       id="{{ shorten($model) }}-{{ $attribute }}"
                       name="{{ shorten($model) }}{{ dot2Brackets($attribute) }}"
                       class="custom-file-input @error(shorten($model) . ".$attribute") is-invalid @enderror" {{ $attributes }}>
                @error(shorten($model) . ".$attribute")
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <span class="custom-file-label" data-browse="{{ __('Browse') }}">
                    {{ $placeholder ?? __('Select file') }}
                </span>
            </div>
        </div>
    @endif
</div>
