@isset($label)
    @label(['for' => $id, 'required' => $required])
        {{ $label }}
    @endlabel
@endif
<textarea name="{{ $name }}" id="{{ $id }}" class="form-control {{ $errors->has($name) ? 'is-invalid' : '' }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}" {{ $disabled ? 'disabled' : '' }}>{{ $value }}</textarea>

@formerror
    {{ $name }}
@endformerror
