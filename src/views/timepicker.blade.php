@isset($label)
    @label(['for' => $id, 'required' => $required])
        {{ $label }}
    @endlabel
@endif

<input type="text" name="{{ $name }}" id="{{ $id }}" class="form-control time-picker {{ $errors->has($name) ? 'is-invalid' : '' }}" value="{{ $value }}" placeholder="{{ $placeholder }}" data-sibling="{{ $sibling }}" {{ $disabled ? 'disabled' : '' }}>

@formerror
    {{ $name }}
@endformerror
