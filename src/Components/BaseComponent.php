<?php

namespace Balfour\LaravelFormBuilder\Components;

abstract class BaseComponent implements ComponentInterface
{
    /**
     * @var bool
     */
    protected $visible = true;

    /**
     * @return bool
     */
    public function isVisible()
    {
        return $this->visible;
    }

    /**
     * @param bool $visible
     * @return $this
     */
    public function setVisibility($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * @return static
     */
    public static function build()
    {
        return new static();
    }
}
