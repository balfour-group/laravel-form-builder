@isset($label)
    @label(['required' => $required])
        {{ $label }}
    @endlabel
@endif

<div class="btn-group d-block">
    @foreach ($options as $option)
        @php $id = \Balfour\LaravelFormBuilder\FormUtils::generateComponentID($name, $option['key'], $option['value']); @endphp
        <button type="button" class="btn btn-light radio-button-selector {{ implode(' ', $classes) }} {{ $value == $option['key'] ? 'active' : '' }}" {{ $disabled ? 'disabled' : '' }}>
            <input type="radio" name="{{ $name }}" id="{{ $id }}" value="{{ $option['key'] }}" style="display: none;" {{ $value == $option['key'] ? 'checked' : '' }}>
            @isset($option['icon'])
                <i class="{{ $option['icon'] }} mr-2"></i>
            @endif
            {{ $option['value'] }}
        </button>
    @endforeach
</div>

@if ($hasErrors)
    <div class="invalid-feedback">{{ $error }}</div>
@endif
