@isset($label)
    @label(['for' => $id, 'required' => $required])
        {{ $label }}
    @endlabel
@endif

<input type="password" name="{{ $name }}" id="{{ $id }}" class="form-control {{ implode(' ', $classes) }} {{ $hasErrors ? 'is-invalid' : '' }}" value="{{ $value }}" placeholder="{{ $placeholder }}" {{ $disabled ? 'disabled' : '' }}>

@isset($helpText)
    @helptext
        {{ $helpText }}
    @endlabel
@endif

@if ($hasErrors)
    <div class="invalid-feedback">{{ $error }}</div>
@endif
