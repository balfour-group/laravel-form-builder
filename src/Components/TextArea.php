<?php

namespace Balfour\LaravelFormBuilder\Components;

class TextArea extends FormControl
{
    /**
     * @var string
     */
    protected $view = 'form-builder::textarea';

    /**
     * @var int
     */
    protected $rows = 5;

    /**
     * @var string
     */
    protected $placeholder;

    /**
     * @param int $rows
     * @return $this
     */
    public function rows($rows)
    {
        $this->rows = $rows;

        return $this;
    }

    /**
     * @return int
     */
    public function getRows()
    {
        return $this->rows;
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
            'rows' => $this->getRows(),
            'placeholder' => $this->getPlaceholder(),
        ];
    }
}
