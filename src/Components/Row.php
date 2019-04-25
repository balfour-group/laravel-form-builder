<?php

namespace Balfour\LaravelFormBuilder\Components;

class Row extends BaseComponent
{
    /**
     * @var array
     */
    protected $components = [];

    /**
     * @param ComponentInterface|array $component
     * @return $this
     */
    public function with($component)
    {
        if (is_array($component)) {
            foreach ($component as $c) {
                /** @var ComponentInterface $c */
                $this->with($c);
            }
        } else {
            $this->components[] = $component;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getComponents()
    {
        return $this->components;
    }

    /**
     * @return array
     */
    public function getVisibleComponents()
    {
        return array_filter($this->components, function (ComponentInterface $component) {
            return $component->isVisible();
        });
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return count($this->components) === 0;
    }

    /**
     * @return string
     */
    public function getColClass()
    {
        switch (count($this->components)) {
            case 3:
                return 'col-md-4';
            case 2:
                return 'col-md-6';
            default:
                return 'col-md-12';
        }
    }

    /**
     * @return string
     */
    public function render()
    {
        $components = $this->getVisibleComponents();

        if ($this->isEmpty()) {
            return null;
        }

        if (count($components) === 1) {
            $component = $components[0];
            /** @var ComponentInterface $component */
            return sprintf('<div class="form-group">%s</div>', $component->render());
        } else {
            $html = '<div class="form-row">';
            foreach ($components as $component) {
                /** @var ComponentInterface $component */
                $html .= sprintf('<div class="form-group %s">%s</div>', $this->getColClass(), $component->render());
            }
            $html .= '</div>';
            return $html;
        }
    }

    /**
     * @return array
     */
    public function getValidationRules()
    {
        $rules = [];

        foreach ($this->getVisibleComponents() as $component) {
            /** @var ComponentInterface $component */
            $r = $component->getValidationRules();

            if ($r) {
                $rules = array_merge($rules, $r);
            }
        }

        return $rules;
    }
}
