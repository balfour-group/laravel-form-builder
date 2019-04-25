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
<textarea name="{{ $name }}" id="{{ $id }}" class="form-control wysiwyg {{ $errors->has($name) ? 'is-invalid' : '' }}" rows="{{ isset($rows) ? $rows : 5 }}" placeholder="{{ isset($placeholder) ? $placeholder : '' }}" {{ isset($disabled) && $disabled === true ? 'disabled' : '' }}>
    {{ $default }}
</textarea>
@formerror
    {{ $name }}
@endformerror
