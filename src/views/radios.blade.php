@php
$default = old(
    $name,
    request(
        $name,
        isset($default) ? $default : null
    )
);
@endphp

@isset($label)
    @label(['required' => isset($required) ? $required : false])
        {{ $label }}
    @endlabel
@endif
@foreach ($options as $key => $value)
    @php $id = form_label_id($name, $key, $value); @endphp
    <div class="form-check {{ isset($inline) && $inline === true ? 'form-check-inline mr-1' : '' }}">
        <input type="radio" name="{{ $name }}" id="{{ $id }}" class="form-check-input" value="{{ $key }}" {{ isset($disabled) && $disabled === true ? 'disabled' : '' }} {{ $default == $key ? 'checked' : '' }}>
        <label for="{{ $id }}" class="form-check-label">{{ $value }}</label>
    </div>
@endforeach
@formerror
    {{ $name }}
@endformerror
