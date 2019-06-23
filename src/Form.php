<?php

namespace Balfour\LaravelFormBuilder;

use Balfour\LaravelFormBuilder\Components\FileInput;
use Balfour\LaravelFormBuilder\Components\FormControlInterface;
use Balfour\LaravelFormBuilder\Components\HasComponentsInterface;
use Balfour\LaravelFormBuilder\Components\HasComponents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

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
     * @var array
     */
    protected $classes = [];

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
     * @param string|array $classes
     * @return $this
     */
    public function classes($classes)
    {
        if (!is_array($classes)) {
            $classes = (array) $classes;
        }

        foreach ($classes as $class) {
            if (!in_array($class, $this->classes)) {
                $this->classes[] = $class;
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getClasses()
    {
        return $this->classes;
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
                $controls = array_merge($controls, $this->getFormControlComponents($component->getComponents()));
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
            $key = $component->getName();
            $key = str_replace(['[]', '[', ']'], ['.*', '.', ''], $key);
            if (Str::endsWith($key, '.*')) {
                $key = mb_substr($key, 0, -2);
            }

            if (Arr::has($values, $key)) {
                $component->defaults(Arr::get($values, $key));
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    protected function getEncodingType()
    {
        $components = collect($this->getFormControlComponents())->filter(function (FormControlInterface $component) {
            return $component instanceof FileInput;
        });

        return count($components) > 0 ? 'multipart/form-data' : 'application/x-www-form-urlencoded';
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function render()
    {
        return view('form-builder::form', [
            'enctype' => $this->getEncodingType(),
            'id' => $this->getID(),
            'action' => $this->getAction(),
            'classes' => $this->getClasses(),
            'button' => $this->getButton(),
            'hasResetButton' => $this->hasResetButton(),
            'method' => $this->getMethod(),
            'slot' =>  new HtmlString($this->renderChildComponents()),
        ])->render();
    }

    /**
     * @return static
     */
    public static function build()
    {
        return new static();
    }
}
