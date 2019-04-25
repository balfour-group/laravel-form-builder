<?php

namespace Balfour\LaravelFormBuilder\Components;

use Balfour\LaravelFormBuilder\ResolvesOptionsTrait;

class Select extends FormControl
{
    use ResolvesOptionsTrait;

    /**
     * @var bool
     */
    protected $emptyOption = false;

    /**
     * @param bool $emptyOption
     * @return $this
     */
    public function emptyOption($emptyOption = true)
    {
        $this->emptyOption = $emptyOption;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasEmptyOption()
    {
        return $this->emptyOption;
    }

    /**
     * @return array
     */
    public function getAutoValidationRules()
    {
        return [
            $this->getOptionValidationRule(),
        ];
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function render()
    {
        return view('form-builder::select', [
            'label' => $this->getLabel(),
            'name' => $this->getName(),
            'required' => $this->isRequired(),
            'empty_option' => $this->hasEmptyOption(),
            'options' => $this->getOptions(),
            'default' => $this->getDefaultValue(),
            'disabled' => $this->isDisabled(),
        ])->render();
    }
}
