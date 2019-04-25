<?php

namespace Balfour\LaravelFormBuilder;

use Balfour\LaravelFormBuilder\Components\ComponentInterface;
use Balfour\LaravelFormBuilder\Components\FormControlInterface;
use Balfour\LaravelFormBuilder\Components\HiddenInput;
use Balfour\LaravelFormBuilder\Components\Row;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

class Form
{
    /**
     * @var string
     */
    protected $action;

    /**
     * @var string
     */
    protected $button = 'Submit';

    /**
     * @var string
     */
    protected $method = 'POST';

    /**
     * @var array
     */
    protected $components = [];

    /**
     * @param string $name
     * @param array $params
     * @return $this
     */
    public function route($name, array $params = [])
    {
        return $this->action(route($name, $params));
    }

    /**
     * @param string $uri
     * @return $this
     */
    public function to($uri)
    {
        return $this->action(url($uri));
    }

    /**
     * @param string $action
     * @return $this
     */
    public function action($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $button
     * @return $this
     */
    public function button($button)
    {
        $this->button = $button;

        return $this;
    }

    /**
     * @return string
     */
    public function getButton()
    {
        return $this->button;
    }

    /**
     * @param string $method
     * @return $this
     */
    public function method($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
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
    public function getLeafFormControls()
    {
        $components = [];

        foreach ($this->components as $component) {
            if ($component instanceof FormControlInterface) {
                $components[] = $component;
            } elseif ($component instanceof Row) {
                foreach ($component->getComponents() as $c) {
                    if ($c instanceof FormControlInterface) {
                        $components[] = $c;
                    }
                }
            }
        }

        return $components;
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
     * @param mixed $values
     * @return $this
     */
    public function fill($values)
    {
        if ($values instanceof Model) {
            $values = $values->toArray();
        } elseif (!is_array($values)) {
            $values = (array) $values;
        }

        foreach ($this->getLeafFormControls() as $component) {
            /** @var FormControlInterface $component */
            $name = $component->getName();

            if (array_key_exists($name, $values)) {
                $component->defaults($values[$name]);
            }
        }

        return $this;
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function render()
    {
        // render child components
        $rendered = array_map(function (ComponentInterface $component) {
            if ($this->isRowContainerRequired($component)) {
                $component = Row::build()->with($component);
            }

            return $component->render();
        }, $this->getVisibleComponents());

        return view('form-builder::form', [
            'action' => $this->getAction(),
            'button' => $this->getButton(),
            'method' => $this->getMethod(),
            'slot' =>  new HtmlString(implode('', $rendered)),
        ])->render();
    }

    /**
     * @param ComponentInterface $component
     * @return bool
     */
    protected function isRowContainerRequired(ComponentInterface $component)
    {
        return !$component instanceof Row
            && !$component instanceof HiddenInput;
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

    /**
     * @return static
     */
    public static function build()
    {
        return new static();
    }
}
