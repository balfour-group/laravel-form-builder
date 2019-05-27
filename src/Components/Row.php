<?php

namespace Balfour\LaravelFormBuilder\Components;

class Row extends BaseComponent implements HasComponentsInterface
{
    use HasComponents;

    /**
     * @return string
     */
    public function getColClass()
    {
        switch (count($this->components)) {
            case 3:
                return 'col-md-4';
            case 2:
                return 'col-md-6';
            default:
                return 'col-md-12';
        }
    }

    /**
     * @return string
     */
    public function render()
    {
        $components = $this->getVisibleComponents();

        if ($this->isEmpty()) {
            return null;
        }

        if (count($components) === 1) {
            $component = $components[0];
            /** @var ComponentInterface $component */
            return sprintf('<div class="form-group">%s</div>', $component->render());
        } else {
            $html = '<div class="form-row">';
            foreach ($components as $component) {
                /** @var ComponentInterface $component */
                $html .= sprintf('<div class="form-group %s">%s</div>', $this->getColClass(), $component->render());
            }
            $html .= '</div>';
            return $html;
        }
    }
}
