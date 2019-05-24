<form method="{{ $method ?? 'POST' }}" action="{{ $action }}" {!! isset($id) ? sprintf('id="%s"', e($id)) : '' !!}>
    @csrf
    {{ $slot }}
    <div class="form-group {{ isset($center_buttons) && $center_buttons === true ? 'text-center' : '' }}">
        <button class="btn btn-primary" type="submit">{{ $button ?? 'Submit' }}</button>
        @if (isset($reset) && $reset === true)
            <button class="btn btn-secondary" type="reset">Reset</button>
        @endif
    </div>
</form>
