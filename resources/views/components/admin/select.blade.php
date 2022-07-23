@props(['model', 'attribute', 'label', 'containerCssClass', 'options', 'placeholder'])

<div class="{{ $containerCssClass ?? 'form-group' }}">
    <label for="{{ shorten($model) }}-{{ $attribute }}">{{ $label }}</label>
    <select {!! $attributes->merge([
        'type' => 'text',
        'id' => shorten($model) . "-$attribute",
        'name' => shorten($model) . dot2Brackets($attribute) . ($attributes->has('multiple') ? "[]" : ''),
        'value' => old($attribute, $model->$attribute),
        'class' => 'form-control ' . ($errors->has(shorten($model) . ".$attribute") ? 'is-invalid' : '')
    ]) !!}>
        @isset($placeholder)
            <option value=""></option>
        @endisset
        @foreach($options as $optionValue => $optionText)
            <option @if ((string)$optionValue === (string)old($attribute, $model->$attribute)) selected
                    @endif value="{{ $optionValue }}">
                {{ $optionText }}
            </option>
        @endforeach
    </select>
    @error(shorten($model) . ".$attribute")
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
