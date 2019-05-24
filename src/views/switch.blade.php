@isset($label)
    <label class="d-block">{{ $label }}</label>
@endif

<label class="switch switch-label switch-pill switch-success">
    <input type="checkbox" name="{{ $name ?? '' }}" value="1" class="switch-input" {{ isset($on) && $on === true ? 'checked' : '' }}>
    <span class="switch-slider" data-checked="{{ $on_label ?? 'On' }}" data-unchecked="{{ $off_label ?? 'Off' }}"></span>
</label>
