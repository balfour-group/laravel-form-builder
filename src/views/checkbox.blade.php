@php
$id = form_label_id($name);

$value = $value ?? 1;

$default = form_input_default_value($name, $default ?? null);
@endphp

<div class="form-check form-check-inline">
    <input type="checkbox" name="{{ $name }}" id="{{ $id }}" class="form-check-input" value="{{ $value }}" {{ isset($disabled) && $disabled === true ? 'disabled' : '' }} {{ $default == $value ? 'checked' : '' }}>
    <label for="{{ $id }}" class="form-check-label">{{ $label }}</label>
</div>
