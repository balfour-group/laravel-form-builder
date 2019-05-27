@isset($label)
    @label(['required' => $required])
        {{ $label }}
    @endlabel
@endif

@foreach ($options as $k => $v)
    @php $id = \Balfour\LaravelFormBuilder\FormUtils::generateComponentID($name, $k, $v); @endphp
    <div class="form-check {{ $inline ? 'form-check-inline mr-1' : '' }}">
        <input type="radio" name="{{ $name }}" id="{{ $id }}" class="form-check-input" value="{{ $k }}" {{ $disabled ? 'disabled' : '' }} {{ $value == $k ? 'checked' : '' }}>
        <label for="{{ $id }}" class="form-check-label">{{ $v }}</label>
    </div>
@endforeach

@if ($errors->has($errorKey))
    <div class="invalid-feedback">{{ $errors->first($errorKey) }}</div>
@endif
