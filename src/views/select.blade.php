@php
$id = form_label_id($name);

$default = old(
    $name,
    request(
        $name,
        isset($default) ? $default : null
    )
);

if (isset($empty_option) && $empty_option === true) {
    $options = ['' => '-'] + $options;
}
@endphp

@isset($label)
    @label(['for' => $id, 'required' => isset($required) ? $required : false])
        {{ $label }}
    @endlabel
@endif
<select name="{{ $name }}" id="{{ $id }}" class="form-control {{ $errors->has($name) ? 'is-invalid' : '' }}" {{ isset($disabled) && $disabled === true ? 'disabled' : '' }}>
    @foreach ($options as $key => $value)
        <option value="{{ $key }}" {{ $default == $key ? 'selected' : '' }}>{{ $value }}</option>
    @endforeach
</select>
@formerror
    {{ $name }}
@endformerror
