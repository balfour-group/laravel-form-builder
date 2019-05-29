<?php

namespace Balfour\LaravelFormBuilder\Components;

use Balfour\LaravelFormBuilder\FormUtils;
use Illuminate\Support\Str;
use Illuminate\Support\ViewErrorBag;

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
            $label = $this->getName();

            if (preg_match('/^(.+)\[\]$/', $label, $parts)) {
                // person[] -> Person
                $label = $parts[1];
            } elseif (preg_match('/^(.+)\[(.+)\]$/', $label, $parts)) {
                // photos[profile] -> Profile
                // person[][email] -> Email
                // person[foo][email] -> Email
                $label = $parts[2];
            }

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
     * @return mixed
     */
    public function getValue()
    {
        return FormUtils::getValueFromRequest($this->getName(), $this->getDefaultValue());
    }

    /**
     * @param mixed $rule
     * @return $this
     */
    public function rule($rule)
    {
        if (is_array($rule)) {
            foreach ($rule as $r) {
                $this->rules[] = $r;
            }
        } else {
            $this->rules[] = $rule;
        }

        return $this;
    }

    /**
     * @param array $rules
     * @return $this
     */
    public function rules(array $rules)
    {
        return $this->rule($rules);
    }

    /**
     * @return string
     */
    protected function getValidationKey()
    {
        $name = $this->getName();

        // handle array syntax
        // person[] -> person.*
        // person[first_name] => person.first_name
        // person[][first_name] = person.*.first_name
        // person[][roles][] = person.*.roles.*

        $name = str_replace(['[]', '[', ']'], ['.*', '.', ''], $name);

        return $name;
    }

    /**
     * @return string|null
     */
    protected function getParentValidationKey()
    {
        // person.* -> person
        // person.first_name => null
        // person.*.first_name => null
        // person.*.roles.* => person.*.roles

        return $this->isArrayComponent() ? mb_substr($this->getValidationKey(), 0, -2) : null;
    }

    /**
     * @return bool
     */
    protected function isArrayComponent()
    {
        return Str::endsWith($this->getValidationKey(), '.*');
    }

    /**
     * @return array
     */
    public function getAutoValidationRules()
    {
        return [];
    }

    /**
     * @return array
     */
    public function getParentAutoValidationRules()
    {
        return [];
    }

    /**
     * @return array
     */
    public function getValidationRules()
    {
        return $this->buildParentValidationRules() + $this->buildComponentValidationRules();
    }

    /**
     * @return array
     */
    protected function buildParentValidationRules()
    {
        if (!$this->isArrayComponent() || $this->isDisabled() || !$this->isVisible()) {
            return [];
        }

        $rules = [];

        if ($this->isRequired()) {
            $rules[] = 'required';
        }

        $rules[] = 'array';

        $rules = array_merge($rules, $this->getParentAutoValidationRules());

        return count($rules) > 0 ? [$this->getParentValidationKey() => $rules] : [];
    }

    /**
     * @return array
     */
    protected function buildComponentValidationRules()
    {
        if ($this->isDisabled() || !$this->isVisible()) {
            return [];
        }

        $rules = [];

        $isArrayComponent = $this->isArrayComponent();
        $isRequired = $this->isRequired() || $isArrayComponent;

        if ($isRequired) {
            $rules[] = 'required';
        }

        $other = array_merge(
            $this->getAutoValidationRules(),
            $this->rules
        );

        if (!$isRequired && count($other) > 0) {
            $rules[] = 'nullable';
        }

        $rules = array_merge($rules, $other);

        return count($rules) > 0 ? [$this->getValidationKey() => $rules] : [];
    }

    /**
     * @return ViewErrorBag
     */
    protected function getErrorBag()
    {
        $errors = session()->get('errors', app(ViewErrorBag::class));
        /** @var ViewErrorBag $bag */
        return $errors;
    }

    /**
     * @return string|null
     */
    protected function getError()
    {
        $errors = $this->getErrorBag();

        if ($this->isArrayComponent() && $errors->has($this->getParentValidationKey())) {
            return $errors->first($this->getParentValidationKey());
        } else {
            return $errors->first($this->getValidationKey());
        }
    }

    /**
     * @return bool
     */
    protected function hasErrors()
    {
        $errors = $this->getErrorBag();

        if ($this->isArrayComponent() && $errors->has($this->getParentValidationKey())) {
            return true;
        } else {
            return $errors->has($this->getValidationKey());
        }
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function render()
    {
        return view($this->view, array_merge($this->getRenderViewVars(), [
            'id' => FormUtils::generateComponentID($this->getName()),
            'label' => $this->getLabel(),
            'name' => $this->getName(),
            'required' => $this->isRequired(),
            'disabled' => $this->isDisabled(),
            'value' => $this->getValue(),
            'hasErrors' => $this->hasErrors(),
            'error' => $this->getError(),
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
