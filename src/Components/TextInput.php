<?php

namespace Balfour\LaravelFormBuilder\Components;

class TextInput extends FormControl
{
    /**
     * @var string
     */
    protected $view = 'form-builder::input';

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
     * @return array
     */
    protected function getRenderViewVars()
    {
        return [
            'type' => $this->getType(),
            'placeholder' => $this->getPlaceholder(),
        ];
    }
}
