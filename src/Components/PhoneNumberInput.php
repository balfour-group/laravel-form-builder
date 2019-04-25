<?php

namespace Balfour\LaravelFormBuilder\Components;

class PhoneNumberInput extends TextInput
{
    /**
     * @var string
     */
    protected $name = 'phone_number';

    /**
     * @var string
     */
    protected $type = 'tel';

    /**
     * @return array
     */
    public function getAutoValidationRules()
    {
        return [
            'phone:AUTO,ZA',
        ];
    }
}
