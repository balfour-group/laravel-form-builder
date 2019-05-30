@isset($label)
    @label(['for' => $id, 'required' => $required])
        {{ $label }}
    @endlabel
@endif

<input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}" class="form-control {{ implode(' ', $classes) }} {{ $hasErrors ? 'is-invalid' : '' }}" value="{{ $value }}" placeholder="{{ $placeholder }}" {{ $disabled ? 'disabled' : '' }}>

@if ($hasErrors)
    <div class="invalid-feedback">{{ $error }}</div>
@endif
