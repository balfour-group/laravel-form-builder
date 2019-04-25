<?php

namespace Balfour\LaravelFormBuilder\Components;

use Balfour\LaravelFormBuilder\ResolvesOptionsTrait;

class Checkboxes extends FormControl
{
    use ResolvesOptionsTrait;

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
     * @return string
     * @throws \Throwable
     */
    public function render()
    {
        return view('form-builder::checkboxes', [
            'label' => $this->getLabel(),
            'name' => $this->getName(),
            'required' => $this->isRequired(),
            'options' => $this->getOptions(),
            'checked' => $this->getDefaultValue(),
            'disabled' => $this->isDisabled(),
        ])->render();
    }
}
