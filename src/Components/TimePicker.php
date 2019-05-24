<?php

namespace Balfour\LaravelFormBuilder\Components;

class TimePicker extends FormControl
{
    /**
     * @var string
     */
    protected $view = 'form-builder::timepicker';

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
     * @return array
     */
    protected function getRenderViewVars()
    {
        return [
            'sibling' => $this->getSibling(),
        ];
    }
}
