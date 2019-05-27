<?php

namespace Balfour\LaravelFormBuilder\Components;

interface FormControlInterface extends ComponentInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getLabel();

    /**
     * @return bool
     */
    public function isRequired();

    /**
     * @return bool
     */
    public function isDisabled();

    /**
     * @param mixed $default
     * @return $this
     */
    public function defaults($default);

    /**
     * @return mixed
     */
    public function getDefaultValue();
}
