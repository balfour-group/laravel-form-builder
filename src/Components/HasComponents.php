<?php

namespace Balfour\LaravelFormBuilder\Components;

trait HasComponents
{
    /**
     * @var array
     */
    protected $components = [];

    /**
     * @param ComponentInterface|array $component
     * @return $this
     */
    public function add($component)
    {
        if (is_array($component)) {
            foreach ($component as $c) {
                /** @var ComponentInterface $c */
                $this->add($c);
            }
        } else {
            $this->components[] = $component;
        }

        return $this;
    }

    /**
     * @param ComponentInterface|array $component
     * @return $this
     */
    public function with($component)
    {
        return $this->add($component);
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
     * @return array
     */
    public function getValidationRules()
    {
        $rules = [];

        foreach ($this->getVisibleComponents() as $component) {
            /** @var ComponentInterface $component */
            $r = $component->getValidationRules();

            if (count($r) > 0) {
                $rules = array_merge($rules, $r);
            }
        }

        return $rules;
    }
}
