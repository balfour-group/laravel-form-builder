@isset($label)
    @label(['for' => $id, 'required' => $required])
        {{ $label }}
    @endlabel
@endif

<input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}" class="form-control {{ $errors->has($errorKey) ? 'is-invalid' : '' }}" value="{{ $value }}" placeholder="{{ $placeholder }}" {{ $disabled ? 'disabled' : '' }}>

@if ($errors->has($errorKey))
    <div class="invalid-feedback">{{ $errors->first($errorKey) }}</div>
@endif
