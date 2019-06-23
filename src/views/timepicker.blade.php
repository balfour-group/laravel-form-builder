@isset($label)
    @label(['for' => $id, 'required' => $required])
        {{ $label }}
    @endlabel
@endif

<input type="text" name="{{ $name }}" id="{{ $id }}" class="form-control time-picker {{ implode(' ', $classes) }} {{ $hasErrors ? 'is-invalid' : '' }}" value="{{ $value }}" placeholder="{{ $placeholder }}" data-sibling="{{ $sibling }}" {{ $disabled ? 'disabled' : '' }}>

@isset($helpText)
    @helptext
        {{ $helpText }}
    @endlabel
@endif

@if ($hasErrors)
    <div class="invalid-feedback">{{ $error }}</div>
@endif
