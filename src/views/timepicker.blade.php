@isset($label)
    @label(['for' => $id, 'required' => $required])
        {{ $label }}
    @endlabel
@endif

<input type="text" name="{{ $name }}" id="{{ $id }}" class="form-control time-picker {{ $errors->has($errorKey) ? 'is-invalid' : '' }}" value="{{ $value }}" placeholder="{{ $placeholder }}" data-sibling="{{ $sibling }}" {{ $disabled ? 'disabled' : '' }}>

@if ($errors->has($errorKey))
    <div class="invalid-feedback">{{ $errors->first($errorKey) }}</div>
@endif
