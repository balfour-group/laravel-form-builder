@isset($label)
    <label class="d-block">{{ $label }}</label>
@endif
<label class="switch switch-label switch-pill switch-success">
    <input type="checkbox" name="{{ isset($name) ? $name : '' }}" value="1" class="switch-input" {{ isset($on) && $on === true ? 'checked' : '' }}>
    <span class="switch-slider" data-checked="{{ isset($on_label) ? $on_label : 'On' }}" data-unchecked="{{ isset($off_label) ? $off_label : 'Off' }}"></span>
</label>
