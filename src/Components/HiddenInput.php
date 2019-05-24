<?php

namespace Balfour\LaravelFormBuilder\Components;

class HiddenInput extends FormControl
{
    /**
     * @var string
     */
    protected $view = 'form-builder::hidden';

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @param mixed $value
     * @return $this
     */
    public function value($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return array
     */
    protected function getRenderViewVars()
    {
        return [
            'value' => $this->getValue(),
        ];
    }
}
