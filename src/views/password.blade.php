@php
$id = form_label_id($name);

$default = form_input_default_value($name, $default ?? null);
@endphp

@isset($label)
    @label(['for' => $id, 'required' => $required ?? false])
        {{ $label }}
    @endlabel
@endif

<input type="password" name="{{ $name }}" id="{{ $id }}" class="form-control {{ $errors->has($name) ? 'is-invalid' : '' }}" value="{{ $default }}" placeholder="{{ $placeholder ?? '' }}" {{ isset($disabled) && $disabled === true ? 'disabled' : '' }}>

@formerror
    {{ $name }}
@endformerror
