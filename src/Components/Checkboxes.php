<?php

namespace Balfour\LaravelFormBuilder\Components;

use Balfour\LaravelFormBuilder\ResolvesOptionsTrait;

class Checkboxes extends FormControl
{
    use ResolvesOptionsTrait;

    /**
     * @var string
     */
    protected $view = 'form-builder::checkboxes';

    /**
     * @var bool
     */
    protected $inline = false;

    /**
     * @return array
     */
    public function getAutoValidationRules()
    {
        return [
            'array',
        ];
    }

    /**
     * @return array|null
     */
    public function getValidationRules()
    {
        if ($this->isDisabled() || !$this->isVisible()) {
            return null;
        }

        $rules = parent::getValidationRules();

        $rules[sprintf('%s.*', $this->getName())] = [
            'required',
            $this->getOptionValidationRule(),
        ];

        return $rules;
    }

    /**
     * @param bool $bool
     * @return $this
     */
    public function inline($bool)
    {
        $this->inline = $bool;

        return $this;
    }

    /**
     * @return bool
     */
    public function isInline()
    {
        return $this->inline;
    }

    /**
     * @return array
     */
    public function getCheckedValues()
    {
        return $this->getValue() ?? [];
    }

    /**
     * @return array
     */
    protected function getRenderViewVars()
    {
        return [
            'inline' => $this->isInline(),
            'options' => $this->getOptions(),
            'checked' => $this->getCheckedValues(),
        ];
    }
}
