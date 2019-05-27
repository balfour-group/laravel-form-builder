<?php

namespace Balfour\LaravelFormBuilder\Components;

interface ComponentInterface
{
    /**
     * @return string
     */
    public function render();

    /**
     * @return array
     */
    public function getValidationRules();

    /**
     * @return bool
     */
    public function isVisible();

    /**
     * @param bool $visible
     * @return $this
     */
    public function setVisibility($visible);
}
