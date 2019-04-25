@php
$id = form_label_id($name);

$value = isset($value) ? $value : 1;

$default = old(
    $name,
    request(
        $name,
        isset($default) ? $default : null
    )
);
@endphp

<div class="form-check form-check-inline">
    <input type="checkbox" name="{{ $name }}" id="{{ $id }}" class="form-check-input" value="{{ $value }}" {{ isset($disabled) && $disabled === true ? 'disabled' : '' }} {{ $default == $value ? 'checked' : '' }}>
    <label for="{{ $id }}" class="form-check-label">{{ $label }}</label>
</div>
