@isset($label)
    @label(['for' => $id, 'required' => $required])
        {{ $label }}
    @endlabel
@endif

<select name="{{ $name }}" id="{{ $id }}" class="form-control {{ $errors->has($name) ? 'is-invalid' : '' }}" {{ $disabled ? 'disabled' : '' }}>
    @foreach ($options as $k => $v)
        <option value="{{ $k }}" {{ $value == $k ? 'selected' : '' }}>{{ $v }}</option>
    @endforeach
</select>

@formerror
    {{ $name }}
@endformerror
