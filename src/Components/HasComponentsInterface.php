<?php

namespace Balfour\LaravelFormBuilder\Components;

interface HasComponentsInterface
{
    /**
     * @param ComponentInterface|array $component
     * @return $this
     */
    public function add($component);

    /**
     * @param ComponentInterface|array $component
     * @return $this
     */
    public function with($component);

    /**
     * @return array
     */
    public function getComponents();

    /**
     * @return array
     */
    public function getVisibleComponents();

    /**
     * @return bool
     */
    public function isEmpty();
}
