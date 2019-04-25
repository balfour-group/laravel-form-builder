<?php

namespace Balfour\LaravelFormBuilder\Components;

class RichTextEditor extends FormControl
{
    /**
     * @var int
     */
    protected $rows = 5;

    /**
     * @param int $rows
     */
    public function rows($rows)
    {
        $this->rows = $rows;
    }

    /**
     * @return int
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function render()
    {
        return view('form-builder::wysiwyg', [
            'label' => $this->getLabel(),
            'name' => $this->getName(),
            'rows' => $this->getRows(),
            'required' => $this->isRequired(),
            'default' => $this->getDefaultValue(),
            'disabled' => $this->isDisabled(),
        ])->render();
    }
}
