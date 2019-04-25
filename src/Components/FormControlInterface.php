<?php

namespace Balfour\LaravelFormBuilder\Components;

interface FormControlInterface extends ComponentInterface
{
    /**
     * @param string $name
     * @return $this
     */
    public function name($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $label
     * @return $this
     */
    public function label($label);

    /**
     * @return string
     */
    public function getLabel();

    /**
     * @param bool $required
     * @return $this
     */
    public function required($required = true);

    /**
     * @return bool
     */
    public function isRequired();

    /**
     * @param bool $disabled
     * @return $this
     */
    public function disabled($disabled = true);

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
