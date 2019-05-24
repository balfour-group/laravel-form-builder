<?php

namespace Balfour\LaravelFormBuilder\Components;

use Illuminate\Validation\Rule;

class RadioButtonGroup extends FormControl
{
    /**
     * @var string
     */
    protected $view = 'form-builder::radio-button-group';

    /**
     * @var array
     */
    protected $options = [];

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
     * @return array
     */
    protected function getRenderViewVars()
    {
        return [
            'options' => $this->getOptions(),
        ];
    }
}
