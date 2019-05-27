@isset($label)
    @label(['for' => $id, 'required' => $required])
        {{ $label }}
    @endlabel
@endif

<textarea name="{{ $name }}" id="{{ $id }}" class="form-control wysiwyg {{ $errors->has($errorKey) ? 'is-invalid' : '' }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}" {{ $disabled ? 'disabled' : '' }}>{{ $value }}</textarea>

@if ($errors->has($errorKey))
    <div class="invalid-feedback">{{ $errors->first($errorKey) }}</div>
@endif
