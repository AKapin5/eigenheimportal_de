@props(['model', 'attribute', 'label', 'containerCssClass'])

<div class="{{ $containerCssClass ?? 'form-group' }}">
    <div class="form-check">
        <input type="hidden" name="{{ shorten($model) . dot2Brackets($attribute) }}" value="0">
        <input type="checkbox" value="1" {{ old('status', $model->$attribute) ? 'checked' : '' }} {!! $attributes->merge([
            'id' => shorten($model) . "-$attribute",
            'name' => shorten($model) . dot2Brackets($attribute),
            'value' => old($attribute, $model->$attribute),
            'class' => 'form-check-input'
        ]) !!} >
        <label class="form-check-label" for="{{ shorten($model) }}-{{ $attribute }}">{{ $label }}</label>
    </div>
    @error(shorten($model) . ".$attribute")
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
