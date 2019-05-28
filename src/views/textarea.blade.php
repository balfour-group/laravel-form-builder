@isset($label)
    @label(['for' => $id, 'required' => $required])
        {{ $label }}
    @endlabel
@endif
<textarea name="{{ $name }}" id="{{ $id }}" class="form-control {{ $hasErrors ? 'is-invalid' : '' }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}" {{ $disabled ? 'disabled' : '' }}>{{ $value }}</textarea>

@if ($hasErrors)
    <div class="invalid-feedback">{{ $error }}</div>
@endif
