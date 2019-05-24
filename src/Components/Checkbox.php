<?php

namespace Balfour\LaravelFormBuilder\Components;

class Checkbox extends FormControl
{
    /**
     * @var string
     */
    protected $view = 'form-builder::checkbox';

    /**
     * @var mixed
     */
    protected $value = '1';

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
     * @return bool
     */
    public function isChecked()
    {
        return $this->getValue() == '1';
    }

    /**
     * @return array
     */
    protected function getRenderViewVars()
    {
        return [
            'value' => $this->getValue(),
            'isChecked' => $this->isChecked(),
        ];
    }
}
