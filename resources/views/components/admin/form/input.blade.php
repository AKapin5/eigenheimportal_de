@props(['model', 'attribute', 'label', 'containerAttributes'])

<div {!! $containerAttributes ?? 'class="mb-3"' !!}>
    <label>{{ $label }}</label>
    <input wire:model="{{ $attribute }}" {!! $attributes->merge([
        'type' => 'text',
        'class' => 'form-control ' . ($errors->has("$attribute") ? 'is-invalid' : '')
    ]) !!}>
    @error($attribute)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
