@props(['model', 'attribute', 'label', 'containerAttributes', 'type'])

<div {!! $containerAttributes ?? 'class="mb-2 ' . ($errors->has("$attribute") ? 'has-errors' : '') . '"' !!}>
    <div wire:ignore>
        <label>{{ $label }}</label>
        <textarea
            id="{{ shorten($model) }}form-{{ dot2Hyphen($attribute) }}"
            wire:model="{{ $attribute }}"
            {!! $attributes->merge(['class' => 'form-control']) !!}></textarea>
    </div>
    @error($attribute)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
@if (isset($type) AND $type == 'tinymce')
    @push('js')
        <script>
            (function() {
                const tinyMcePlugin = {
                    init: function () {
                        const editor_config = {
                            path_absolute: "/admin/",
                            selector: '#{{ shorten($model) }}form-{{ dot2Hyphen($attribute) }}',
                            relative_urls: false,
                            height: 400,
                            language: 'en',
                            plugins: [
                                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                                "searchreplace wordcount visualblocks visualchars code fullscreen",
                                "insertdatetime media nonbreaking save table directionality",
                                "emoticons template paste textpattern"
                            ],
                            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
                            extended_valid_elements: 'script[src|async|defer|type|charset]',
                            file_picker_callback : function(callback, value, meta) {
                                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                                var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                                var cmsURL = editor_config.path_absolute + 'fm/?editor=' + meta.fieldname;
                                if (meta.filetype == 'image') {
                                    cmsURL = cmsURL + "&type=Images";
                                } else {
                                    cmsURL = cmsURL + "&type=Files";
                                }

                                tinyMCE.activeEditor.windowManager.openUrl({
                                    url : cmsURL,
                                    title : 'File manager',
                                    width : x * 0.8,
                                    height : y * 0.8,
                                    resizable : "yes",
                                    close_previous : "no",
                                    onMessage: (api, message) => {
                                        callback(message.content);
                                    }
                                });
                            },
                            setup: function (editor) {
                                editor.on('init change', function () {
                                    editor.save();
                                });
                                editor.on('change', function () {
                                    @this.set('{{ $attribute }}', editor.getContent());
                                });
                            }
                        };
                        tinymce.init(editor_config);
                    }
                };
                tinyMcePlugin.init();
                @this.on('hydrate', () => {
                    tinyMcePlugin.init();
                });
            })();
        </script>
    @endpush
@endisset
