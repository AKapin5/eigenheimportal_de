 @props(['model', 'attribute', 'label', 'containerAttributes', 'options', 'type', 'placeholder'])

<div {!! $containerAttributes ?? 'class="mb-3"' !!}>
    <label>{{ $label }}</label>
    <select
        id="{{ shorten($model) }}form-{{ dot2Hyphen($attribute) }}"
        wire:model="{{ $attribute }}" {!! $attributes->merge([
        'type' => 'text',
        'class' => 'form-control ' . ($errors->has("$attribute") ? 'is-invalid' : '')
    ]) !!}>
        @if (!$attributes->has('multiple') AND isset($placeholder))
            <option value="">{{ $placeholder }}</option>
        @endif
        @foreach($options as $optionValue => $optionText)
            <option value="{{ $optionValue }}">
                {{ $optionText }}
            </option>
        @endforeach
    </select>
    @error($attribute)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
@if (isset($type) AND $type == 'select2')
    @push('js')
        <script>
            (function ($) {
                const select2Plugin = {
                    init: function () {
                        const el = $('#{{ shorten($model) }}form-{{ dot2Hyphen($attribute) }}');
                        const options = {
                            theme: 'bootstrap-5',
                            language: '{{ app()->getLocale() }}',
                        };
                        @isset($placeholder)
                            options.placeholder = '{{ $placeholder }}';
                            options.allowClear = true;
                        @endisset
                        el.select2(options);
                        el.on('change', function() {
                            @this.set('{{ $attribute }}', $(this).val());
                        });
                    }
                };
                select2Plugin.init();
                @this.on('hydrate', () => {
                    select2Plugin.init();
                });
            })(jQuery);
        </script>
    @endpush
@endif
