<?php

namespace Balfour\LaravelFormBuilder\Components;

class Checkbox extends FormControl
{
    /**
     * @var string
     */
    protected $view = 'form-builder::checkbox';

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
            'isChecked' => $this->isChecked(),
        ];
    }
}
