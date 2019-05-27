<?php

namespace Balfour\LaravelFormBuilder;

abstract class FormUtils
{
    /**
     * @param mixed ...$parts
     * @return string
     */
    public static function generateComponentID(...$parts)
    {
        $parts = array_map(function ($part) {
            return \Illuminate\Support\Str::slug($part, '_');
        }, $parts);
        $parts[] = \Illuminate\Support\Str::random(5);
        return implode('_', $parts);
    }

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public static function getValueFromRequest($name, $default = null)
    {
        $name = str_replace(['[]', '[', ']'], ['', '.', ''], $name);

        return old(
            $name,
            request(
                $name,
                $default
            )
        );
    }
}
