<?php

namespace Balfour\LaravelFormBuilder\Components;

class EmailInput extends TextInput
{
    /**
     * @var string
     */
    protected $name = 'email';

    /**
     * @var string
     */
    protected $type = 'email';

    /**
     * @return array
     */
    public function getAutoValidationRules()
    {
        return [
            'email',
        ];
    }
}
