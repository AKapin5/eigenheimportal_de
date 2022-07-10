@props(['model', 'attribute', 'label', 'containerCssClass'])

<div class="{{ $containerCssClass ?? 'form-group' }}">
    <label for="{{ shorten($model) }}-{{ $attribute }}">{{ $label }}</label>
    <textarea {!! $attributes->merge([
        'id' => shorten($model) . "-$attribute",
        'name' => shorten($model) . dot2Brackets($attribute),
        'class' => 'form-control ' . ($errors->has(shorten($model) . ".$attribute") ? 'is-invalid' : '')
    ]) !!}>{{ $slot ?? old($attribute, $model->$attribute) }}</textarea>
    @error(shorten($model) . ".$attribute")
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
