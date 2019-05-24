<?php

namespace Balfour\LaravelFormBuilder\Components;

use Illuminate\Support\Str;

abstract class FormControl extends BaseComponent implements FormControlInterface
{
    /**
     * @var string
     */
    protected $view;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var bool
     */
    protected $required = false;

    /**
     * @var bool
     */
    protected $disabled = false;

    /**
     * @var mixed
     */
    protected $default = null;

    /**
     * @var array
     */
    protected $rules = [];

    /**
     * @param string $name
     * @return $this
     */
    public function name($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $label
     * @return $this
     */
    public function label($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        if ($this->label === '') {
            return null;
        } elseif ($this->label) {
            return $this->label;
        } else {
            // generate label from name
            $label = $this->name;
            if (Str::endsWith($label, '_id')) {
                $label = mb_substr($label, 0, -3);
            }
            $label = str_replace('_', ' ', $label);
            $label = Str::title($label);
            return $label;
        }
    }

    /**
     * @param bool $required
     * @return $this
     */
    public function required($required = true)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * @return bool
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * @param bool $disabled
     * @return $this
     */
    public function disabled($disabled = true)
    {
        $this->disabled = $disabled;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDisabled()
    {
        return $this->disabled;
    }

    /**
     * @param mixed $default
     * @return $this
     */
    public function defaults($default)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDefaultValue()
    {
        return is_callable($this->default) ?  call_user_func($this->default) : $this->default;
    }

    /**
     * @param mixed $rule
     * @return $this
     */
    public function rule($rule)
    {
        $this->rules[] = $rule;

        return $this;
    }

    /**
     * @return array
     */
    public function getAutoValidationRules()
    {
        return [];
    }

    /**
     * @return array|null
     */
    public function getValidationRules()
    {
        if ($this->isDisabled() || !$this->isVisible()) {
            return null;
        }

        $rules = [];

        if ($this->isRequired()) {
            $rules[] = 'required';
        }

        $other = array_merge(
            $this->getAutoValidationRules(),
            $this->rules
        );

        if (!$this->isRequired() && count($other) > 0) {
            $rules[] = 'nullable';
        }

        $rules = array_merge($rules, $other);

        return count($rules) > 0 ? [$this->name => $rules] : null;
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function render()
    {
        return view($this->view, array_merge($this->getRenderViewVars(), [
            'label' => $this->getLabel(),
            'name' => $this->getName(),
            'required' => $this->isRequired(),
            'default' => $this->getDefaultValue(),
            'disabled' => $this->isDisabled(),
        ]))->render();
    }

    /**
     * @return array
     */
    protected function getRenderViewVars()
    {
        return [];
    }
}
