<div class="form-check form-check-inline">
    <input type="checkbox" name="{{ $name }}" id="{{ $id }}" class="form-check-input" value="{{ $value }}" {{ $disabled ? 'disabled' : '' }} {{ $isChecked ? 'checked' : '' }}>
    <label for="{{ $id }}" class="form-check-label">{{ $label }}</label>
</div>

@if ($errors->has($errorKey))
    <div class="invalid-feedback">{{ $errors->first($errorKey) }}</div>
@endif
