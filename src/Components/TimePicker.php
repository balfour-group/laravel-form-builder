<?php

namespace Balfour\LaravelFormBuilder\Components;

class TimePicker extends FormControl
{
    /**
     * @var string
     */
    protected $sibling;

    /**
     * @param string $sibling
     * @return $this
     */
    public function sibling($sibling)
    {
        $this->sibling = $sibling;

        return $this;
    }

    /**
     * @return string
     */
    public function getSibling()
    {
        return $this->sibling;
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function render()
    {
        return view('form-builder::timepicker', [
            'label' => $this->getLabel(),
            'name' => $this->getName(),
            'required' => $this->isRequired(),
            'default' => $this->getDefaultValue(),
            'disabled' => $this->isDisabled(),
            'sibling' => $this->getSibling(),
        ])->render();
    }
}
