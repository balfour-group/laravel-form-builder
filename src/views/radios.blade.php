@isset($label)
    @label(['required' => $required])
        {{ $label }}
    @endlabel
@endif

@foreach ($options as $k => $v)
    @php $id = \Balfour\LaravelFormBuilder\FormUtils::generateComponentID($name, $k, $v); @endphp
    <div class="form-check {{ $inline ? 'form-check-inline mr-1' : '' }}">
        <input type="radio" name="{{ $name }}" id="{{ $id }}" class="form-check-input {{ implode(' ', $classes) }}" value="{{ $k }}" {{ $disabled ? 'disabled' : '' }} {{ $value == $k ? 'checked' : '' }}>
        <label for="{{ $id }}" class="form-check-label">{{ $v }}</label>
    </div>
@endforeach

@isset($helpText)
    @helptext
        {{ $helpText }}
    @endlabel
@endif

@if ($hasErrors)
    <div class="invalid-feedback">{{ $error }}</div>
@endif
