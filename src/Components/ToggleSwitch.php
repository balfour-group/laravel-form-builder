<?php

namespace Balfour\LaravelFormBuilder\Components;

class ToggleSwitch extends FormControl
{
    /**
     * @var string
     */
    protected $view = 'form-builder::switch';

    /**
     * @var string
     */
    protected $onLabel = 'On';

    /**
     * @var string
     */
    protected $offLabel = 'Off';

    /**
     * @param mixed $default
     * @return $this
     */
    public function defaults($default)
    {
        // do some magic to turn truey values into 1 and 0 for the form control
        if (!is_callable($default)) {
            if (is_bool($default)) {
                $default = $default ? '1' : '0';
            } else {
                switch (strtolower($default)) {
                    case 'true':
                    case 'on':
                        $default = 1;
                        break;
                    case 'false':
                    case 'off':
                        $default = 0;
                        break;
                    default:
                        $default = (bool) $default ? '1' : '0';
                }
            }
        }

        $this->default = $default;

        return $this;
    }

    /**
     * @param string $label
     * @return $this
     */
    public function onLabel($label)
    {
        $this->onLabel = $label;

        return $this;
    }

    /**
     * @return string
     */
    public function getOnLabel()
    {
        return $this->onLabel;
    }

    /**
     * @param string $label
     * @return $this
     */
    public function offLabel($label)
    {
        $this->offLabel = $label;

        return $this;
    }

    /**
     * @return string
     */
    public function getOffLabel()
    {
        return $this->offLabel;
    }

    /**
     * @return array
     */
    protected function getRenderViewVars()
    {
        return [
            'on_label' => $this->getOnLabel(),
            'off_label' => $this->getOffLabel(),
        ];
    }
}
