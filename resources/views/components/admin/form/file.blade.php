@props(['model', 'attribute', 'label', 'placeholder'])

<div class="file-uploader" id="{{ shorten($model) }}form-{{ dot2Hyphen($attribute) }}">
    <label>{{ $label }}</label>
    @if ($attributes->get('multiple'))
        @if ($model->hasMedia($attribute))
            <div class="mb-3 table-responsive">
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
        @endif
        <div class="mb-3"
            x-data="{ isUploading: false, progress: 0 }"
            x-on:livewire-upload-start="isUploading = true"
            x-on:livewire-upload-error="isUploading = false"
            x-on:livewire-upload-finish="isUploading = false"
            x-on:livewire-upload-progress="progress = $event.detail.progress">

            <input multiple wire:model="{{ $attribute }}" type="file"
                   class="form-control @error("$attribute.*") is-invalid @enderror" {{ $attributes }}>
            @error("$attribute.*")
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <div x-show="isUploading">
                <progress max="100" x-bind:value="progress"></progress>
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
        <div class="mb-3"
             x-data="{ isUploading: false, progress: 0 }"
             x-on:livewire-upload-start="isUploading = true"
             x-on:livewire-upload-error="isUploading = false"
             x-on:livewire-upload-finish="isUploading = false"
             x-on:livewire-upload-progress="progress = $event.detail.progress">

            <input wire:model="{{ $attribute }}" type="file"
                   class="form-control @error("$attribute") is-invalid @enderror" {{ $attributes }}>
            @error($attribute)
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <div x-show="isUploading">
                <progress max="100" x-bind:value="progress"></progress>
            </div>
        </div>
    @endif
</div>

@push('js')
    <script>
        (function ($) {
            const fileUploaderPlugin = {
                init: function() {
                    fileUploaderPlugin.handleDelete();
                    fileUploaderPlugin.handleSort();
                },
                handleDelete: function() {
                    $(document).on('click', '#{{ shorten($model) }}form-{{ dot2Hyphen($attribute) }} [data-remove-file]', function(e) {
                        e.preventDefault();
                        let _that = $(this);
                        if (!confirm(_that.data('confirmText'))) {
                            return;
                        }
                        $.ajax({
                            url: _that.attr('href'),
                            type: 'post',
                            dataType: 'json',
                            success: function (data) {
                                if (data.success) {
                                    _that.closest('.file-item').remove();
                                }
                            },
                        });
                    });
                },
                handleSort: function() {
                    $('#{{ shorten($model) }}form-{{ $attribute }} .sortable').sortable({
                        handle: ".handle",
                        stop: function( event, ui ) {
                            const cont = ui.item.closest('tbody');
                            const ids = [];
                            cont.find('tr').map(function() {
                                ids.push($(this).data('id'));
                            });
                            $.ajax({
                                url: cont.attr('data-sort-url'),
                                type: 'post',
                                data: {
                                    ids: ids
                                }
                            });
                        }
                    });
                },
            };
            fileUploaderPlugin.init();
        })(jQuery);
    </script>
@endpush
