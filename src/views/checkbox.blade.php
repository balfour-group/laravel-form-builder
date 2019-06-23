<div class="form-check form-check-inline">
    <input type="checkbox" name="{{ $name }}" id="{{ $id }}" class="form-check-input {{ implode(' ', $classes) }}" value="1" {{ $disabled ? 'disabled' : '' }} {{ $isChecked ? 'checked' : '' }}>
    <label for="{{ $id }}" class="form-check-label">{{ $label }}</label>
</div>

@isset($helpText)
    @helptext
        {{ $helpText }}
    @endlabel
@endif

@if ($hasErrors)
    <div class="invalid-feedback">{{ $error }}</div>
@endif
