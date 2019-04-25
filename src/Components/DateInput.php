<?php

namespace Balfour\LaravelFormBuilder\Components;

class DateInput extends TextInput
{
    /**
     * @var string
     */
    protected $name = 'date';

    /**
     * @var string
     */
    protected $type = 'date';

    /**
     * @return array
     */
    public function getAutoValidationRules()
    {
        return [
            'date',
        ];
    }
}
