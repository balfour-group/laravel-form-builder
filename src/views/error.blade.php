@php $key = (string) $slot; @endphp

@if ($errors->has($key))
    <div class="invalid-feedback">{{ $errors->first($key) }}</div>
@endif
