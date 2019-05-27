<?php

namespace Balfour\LaravelFormBuilder;

use Balfour\LaravelFormBuilder\Components\ComponentInterface;
use Balfour\LaravelFormBuilder\Components\FormControlInterface;
use Balfour\LaravelFormBuilder\Components\HasComponentsInterface;
use Balfour\LaravelFormBuilder\Components\HasComponents;
use Balfour\LaravelFormBuilder\Components\HiddenInput;
use Balfour\LaravelFormBuilder\Components\Row;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

class Form implements HasComponentsInterface
{
    use HasComponents;

    /**
     * @var string
     */
    protected $id = null;

    /**
     * @var string
     */
    protected $action;

    /**
     * @var string
     */
    protected $button = 'Submit';

    /**
     * @var bool
     */
    protected $hasResetButton = false;

    /**
     * @var string
     */
    protected $method = 'POST';

    /**
     * @param string $id
     * @return $this
     */
    public function id($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getID()
    {
        return $this->id;
    }

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
     * @return $this
     */
    public function showResetButton()
    {
        $this->hasResetButton = true;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasResetButton()
    {
        return $this->hasResetButton;
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
     * @param array|null $components
     * @return array
     */
    protected function getFormControlComponents($components = null)
    {
        $components = $components ?? $this->components;

        $controls = [];

        foreach ($components as $component) {
            if ($component instanceof FormControlInterface) {
                $controls[] = $component;
            } elseif ($component instanceof HasComponentsInterface) {
                $controls = array_merge($controls, $this->getFormControlComponents($component));
            }
        }

        return $controls;
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

        foreach ($this->getFormControlComponents() as $component) {
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
            'id' => $this->getID(),
            'action' => $this->getAction(),
            'button' => $this->getButton(),
            'hasResetButton' => $this->hasResetButton(),
            'method' => $this->getMethod(),
            'slot' =>  new HtmlString(implode('', $rendered)),
        ])->render();
    }

    /**`
     * @param ComponentInterface $component
     * @return bool
     */
    protected function isRowContainerRequired(ComponentInterface $component)
    {
        return !$component instanceof HasComponentsInterface
            && !$component instanceof HiddenInput;
    }

    /**
     * @return static
     */
    public static function build()
    {
        return new static();
    }
}
