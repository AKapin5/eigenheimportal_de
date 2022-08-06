@props(['model', 'attribute', 'label', 'containerAttributes'])

<div {!! $containerAttributes ?? 'class="mb-3"' !!}>
    <div class="form-check">
        <input wire:model="{{ $attribute }}"
               type="checkbox"
               value="1"
               {{ $model->$attribute ? 'checked' : '' }}
               {!! $attributes->merge([
                   'value' => $model->$attribute,
                   'class' => 'form-check-input'
               ]) !!} >
        <label class="form-check-label">{{ $label }}</label>
    </div>
    @error($attribute)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
