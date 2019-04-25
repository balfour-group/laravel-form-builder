@php
$id = form_label_id($name);
@endphp

<input type="hidden" name="{{ $name }}" id="{{ $id }}" value="{{ $value }}">
