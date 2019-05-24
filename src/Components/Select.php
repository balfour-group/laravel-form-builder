<?php

namespace Balfour\LaravelFormBuilder\Components;

use Balfour\LaravelFormBuilder\ResolvesOptionsTrait;

class Select extends FormControl
{
    use ResolvesOptionsTrait;

    /**
     * @var string
     */
    protected $view = 'form-builder::select';

    /**
     * @var bool
     */
    protected $emptyOption = false;

    /**
     * @param bool $emptyOption
     * @return $this
     */
    public function emptyOption($emptyOption = true)
    {
        $this->emptyOption = $emptyOption;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasEmptyOption()
    {
        return $this->emptyOption;
    }

    /**
     * @return array
     */
    public function getAutoValidationRules()
    {
        return [
            $this->getOptionValidationRule(),
        ];
    }

    /**
     * @return array
     */
    protected function getRenderViewVars()
    {
        $options = $this->getOptions();

        if ($this->hasEmptyOption()) {
            $options = ['' => '-'] + $options;
        }

        return [
            'options' => $options,
        ];
    }
}
