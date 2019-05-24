<?php

if (!function_exists('form_label_id')) {
    /**
     * @param mixed ...$parts
     * @return string
     */
    function form_label_id(...$parts)
    {
        $parts = array_map(function ($part) {
            return \Illuminate\Support\Str::slug($part, '_');
        }, $parts);
        $parts[] = \Illuminate\Support\Str::random(5);
        return implode('_', $parts);
    }
}

if (!function_exists('form_input_default_value')) {
    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    function form_input_default_value($name, $default = null)
    {
        return old(
            $name,
            request(
                $name,
                $default
            )
        );
    }
}
