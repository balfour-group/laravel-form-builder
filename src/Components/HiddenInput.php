<?php

namespace Balfour\LaravelFormBuilder\Components;

class HiddenInput extends FormControl
{
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
     * @return string
     * @throws \Throwable
     */
    public function render()
    {
        return view('form-builder::hidden', [
            'name' => $this->getName(),
            'value' => $this->getValue(),
        ])->render();
    }
}
