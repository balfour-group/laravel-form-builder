@php $checked = $checked ?? []; @endphp

@isset($label)
    @label(['required' => $required ?? false])
        {{ $label }}
    @endlabel
@endif

@foreach ($options as $key => $value)
    @php $id = form_label_id($name, $key, $value); @endphp
    <div class="form-check {{ isset($inline) && $inline === true ? 'form-check-inline mr-1' : '' }}">
        <input type="checkbox" name="{{ $name }}[]" id="{{ $id }}" class="form-check-input" value="{{ $key }}" {{ isset($disabled) && $disabled === true ? 'disabled' : '' }} {{ in_array($key, $checked) ? 'checked' : '' }}>
        <label for="{{ $id }}" class="form-check-label">{{ $value }}</label>
    </div>
@endforeach

@formerror
    {{ $name }}
@endformerror
