<?php

namespace Balfour\LaravelFormBuilder\Components;

use Balfour\LaravelFormBuilder\ResolvesOptionsTrait;
use Illuminate\Support\Str;

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
     * @param string $name
     * @return $this
     */
    public function name($name)
    {
        if (!Str::endsWith($name, '[]')) {
            $name .= '[]';
        }

        $this->name = $name;

        return $this;
    }

    /**
     * @return array
     */
    public function getValidationRules()
    {
        if ($this->isDisabled() || !$this->isVisible()) {
            return [];
        }

        $child = $this->getValidationKey();
        $parent = mb_substr($child, 0, -2);
        return [
            $parent => $this->getParentValidationRules(),
            $child => $this->getComponentValidationRules(),
        ];
    }

    /**
     * @return array
     */
    protected function getParentValidationRules()
    {
        $rules = [];

        if ($this->isRequired()) {
            $rules[] = 'required';
        }

        $rules[] = 'array';

        return $rules;
    }

    /**
     * @return array
     */
    protected function getComponentValidationRules()
    {
        $rules = [
            'required',
            $this->getOptionValidationRule(),
        ];

        return array_merge($rules, $this->rules);
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
