@isset($label)
    @label(['for' => $id, 'required' => $required])
        {{ $label }}
    @endlabel
@endif

<select name="{{ $name }}" id="{{ $id }}" class="form-control {{ $errors->has($errorKey) ? 'is-invalid' : '' }}" {{ $disabled ? 'disabled' : '' }}>
    @foreach ($options as $k => $v)
        <option value="{{ $k }}" {{ $value == $k ? 'selected' : '' }}>{{ $v }}</option>
    @endforeach
</select>

@if ($errors->has($errorKey))
    <div class="invalid-feedback">{{ $errors->first($errorKey) }}</div>
@endif
