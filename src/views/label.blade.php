<label {!! isset($for) ? 'for="' . e($for) . '"' : '' !!}>{{ $slot }} {{ isset($required) && $required === true ? '*' : '' }}</label>
