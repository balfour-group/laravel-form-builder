@isset($label)
    @label(['required' => $required])
        {{ $label }}
    @endlabel
@endif

@foreach ($options as $k => $v)
    @php $id = \Balfour\LaravelFormBuilder\FormUtils::generateComponentID($name, $k, $v); @endphp
    <div class="form-check {{ implode(' ', $classes) }} {{ $inline ? 'form-check-inline mr-1' : '' }}">
        <input type="checkbox" name="{{ $name }}" id="{{ $id }}" class="form-check-input" value="{{ $k }}" {{ $disabled ? 'disabled' : '' }} {{ in_array($k, $checked) ? 'checked' : '' }}>
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
