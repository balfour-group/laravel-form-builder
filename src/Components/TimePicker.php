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
     * @var string
     */
    protected $placeholder;

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
     * @param string $placeholder
     * @return $this
     */
    public function placeholder($placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * @return array
     */
    protected function getRenderViewVars()
    {
        return [
            'sibling' => $this->getSibling(),
            'placeholder' => $this->getPlaceholder(),
        ];
    }
}
