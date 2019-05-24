@isset($label)
    <label class="d-block">{{ $label }}</label>
@endif

<label class="switch switch-label switch-pill switch-success">
    <input type="checkbox" name="{{ $name }}" value="1" class="switch-input" {{ $isOn ? 'checked' : '' }}>
    <span class="switch-slider" data-checked="{{ $onLabel ?? 'On' }}" data-unchecked="{{ $offLabel ?? 'Off' }}"></span>
</label>
