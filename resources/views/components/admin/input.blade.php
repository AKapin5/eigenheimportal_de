@props(['model', 'attribute', 'label', 'containerCssClass'])

<div class="{{ $containerCssClass ?? 'form-group' }}">
    <label for="{{ shorten($model) }}-{{ $attribute }}">{{ $label }}</label>
    <input {!! $attributes->merge([
        'type' => 'text',
        'id' => shorten($model) . "-$attribute",
        'name' => shorten($model) . dot2Brackets($attribute),
        'value' => old($attribute, $model->$attribute),
        'class' => 'form-control ' . ($errors->has(shorten($model) . ".$attribute") ? 'is-invalid' : '')
    ]) !!}>
    @error(shorten($model) . ".$attribute")
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
