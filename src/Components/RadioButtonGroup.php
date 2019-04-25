<?php

namespace Balfour\LaravelFormBuilder\Components;

use Illuminate\Validation\Rule;

class RadioButtonGroup extends FormControl
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @param array $options
     * @return $this
     */
    public function options(array $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return array
     */
    public function getAutoValidationRules()
    {
        $keys = array_map(function ($option) {
            return $option['key'];
        }, $this->options);

        return [
            Rule::in($keys),
        ];
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function render()
    {
        return view('form-builder::radio-button-group', [
            'label' => $this->getLabel(),
            'name' => $this->getName(),
            'required' => $this->isRequired(),
            'default' => $this->getDefaultValue(),
            'options' => $this->getOptions(),
            'disabled' => $this->isDisabled(),
        ])->render();
    }
}
