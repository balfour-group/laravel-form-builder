@php
$id = form_label_id($name);

$default = old(
    $name,
    request(
        $name,
        isset($default) ? $default : null
    )
);
@endphp

@isset($label)
    @label(['for' => $id, 'required' => isset($required) ? $required : false])
        {{ $label }}
    @endlabel
@endif
<input type="password" name="{{ $name }}" id="{{ $id }}" class="form-control {{ $errors->has($name) ? 'is-invalid' : '' }}" value="{{ $default }}" placeholder="{{ isset($placeholder) ? $placeholder : '' }}" {{ isset($disabled) && $disabled === true ? 'disabled' : '' }}>
@formerror
    {{ $name }}
@endformerror
