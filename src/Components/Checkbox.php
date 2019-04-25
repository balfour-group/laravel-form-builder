<?php

namespace Balfour\LaravelFormBuilder\Components;

class Checkbox extends FormControl
{
    /**
     * @return string
     * @throws \Throwable
     */
    public function render()
    {
        return view('form-builder::checkbox', [
            'label' => $this->getLabel(),
            'name' => $this->getName(),
            'default' => $this->getDefaultValue(),
            'disabled' => $this->isDisabled(),
        ])->render();
    }
}
