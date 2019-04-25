<?php

namespace Balfour\LaravelFormBuilder\Components;

class TextInput extends FormControl
{
    /**
     * @var string
     */
    protected $type = 'text';

    /**
     * @var string
     */
    protected $placeholder;

    /**
     * @param string $type
     */
    public function type($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
     * @return string
     * @throws \Throwable
     */
    public function render()
    {
        return view('form-builder::input', [
            'label' => $this->getLabel(),
            'type' => $this->getType(),
            'name' => $this->getName(),
            'required' => $this->isRequired(),
            'default' => $this->getDefaultValue(),
            'disabled' => $this->isDisabled(),
            'placeholder' => $this->placeholder,
        ])->render();
    }
}
