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
     * @var bool
     */
    protected $nullOption = false;

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
    public function hasEmptyOption(): bool
    {
        return $this->emptyOption;
    }

    /**
     * @param bool $nullOption
     * @return $this
     */
    public function nullOption($nullOption = true)
    {
        $this->nullOption = $nullOption;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasNullOption(): bool
    {
        return $this->nullOption;
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
        $options = [];
        if ($this->hasEmptyOption()) {
            $options += ['' => '-'];
        }

        if ($this->hasNullOption()) {
            $options += ['null' => 'None'];
        }

        $options += $this->getOptions();

        return [
            'options' => $options,
        ];
    }
}
