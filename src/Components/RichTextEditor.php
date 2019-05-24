<?php

namespace Balfour\LaravelFormBuilder\Components;

class RichTextEditor extends FormControl
{
    /**
     * @var string
     */
    protected $view = 'form-builder::wysiwyg';

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
     * @return array
     */
    protected function getRenderViewVars()
    {
        return [
            'rows' => $this->getRows(),
        ];
    }
}
