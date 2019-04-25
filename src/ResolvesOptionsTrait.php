<?php

namespace Balfour\LaravelFormBuilder;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

trait ResolvesOptionsTrait
{
    /**
     * @var mixed
     */
    protected $originalOptions;

    /**
     * @var mixed
     */
    protected $options;

    /**
     * @var bool
     */
    protected $parsed = false;

    /**
     * @param mixed $options
     * @return $this
     */
    public function options($options)
    {
        $this->options = $this->originalOptions = $options;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        if (!$this->parsed) {
            $this->options = static::parseOptions($this->options);
            $this->parsed = true;
        }

        return $this->options;
    }

    /**
     * @return mixed
     */
    protected function getOptionValidationRule()
    {
        if (is_string($this->originalOptions) && class_exists($this->originalOptions)) {
            $class = new $this->originalOptions();
            if ($class instanceof Model) {
                return sprintf('exists:%s,id', $class->getTable());
            }
        }

        $values = array_keys($this->getOptions());

        return Rule::in($values);
    }

    /**
     * @param mixed $options
     * @return array
     */
    protected static function parseOptions($options)
    {
        // we allow for a little bit of magic here
        if (is_string($options) && class_exists($options)) {
            return call_user_func([$options, 'listify']);
        } elseif (is_callable($options)) {
            return call_user_func($options);
        } elseif (is_array($options)) {
            return $options;
        } else {
            throw new \InvalidArgumentException();
        }
    }
}
