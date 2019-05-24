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
     * @return array
     */
    protected function getRenderViewVars()
    {
        return [
            'options' => $this->getOptions(),
            'checked' => $this->getDefaultValue(),
        ];
    }
}
