@php
$default = old(
    $name,
    request(
        $name,
        isset($default) ? $default : null
    )
);
@endphp

@isset($label)
    @label(['required' => isset($required) ? $required : false])
        {{ $label }}
    @endlabel
@endif
<div class="btn-group d-block">
    @foreach ($options as $option)
        @php $id = form_label_id($name, $option['key'], $option['value']); @endphp
        <button type="button" class="btn btn-light radio-button-selector {{ $default == $option['key'] ? 'active' : '' }}" {{ isset($disabled) && $disabled === true ? 'disabled' : '' }}>
            <input type="radio" name="{{ $name }}" id="{{ $id }}" value="{{ $option['key'] }}" style="display: none;" {{ $default == $option['key'] ? 'checked' : '' }}>
            @isset($option['icon'])
                <i class="{{ $option['icon'] }} mr-2"></i>
            @endif
            {{ $option['value'] }}
        </button>
    @endforeach
</div>
@formerror
    {{ $name }}
@endformerror
