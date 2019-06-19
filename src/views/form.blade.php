<form method="{{ $method }}" action="{{ $action }}" class="{{ implode(' ', $classes) }}" {!! isset($id) ? sprintf('id="%s"', e($id)) : '' !!}>
    @csrf
    {{ $slot }}
    <div class="form-group">
        <button class="btn btn-primary" type="submit">{{ $button }}</button>
        @if ($hasResetButton)
            <button class="btn btn-secondary" type="reset">Reset</button>
        @endif
    </div>
</form>
