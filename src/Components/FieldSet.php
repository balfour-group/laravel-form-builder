<?php

namespace Balfour\LaravelFormBuilder\Components;

use Illuminate\Support\HtmlString;

class FieldSet extends BaseComponent implements HasComponentsInterface
{
    use HasComponents;

    /**
     * @var string
     */
    protected $view = 'form-builder::fieldset';

    /**
     * @var string
     */
    protected $legend;

    /**
     * @param string $legend
     * @return $this
     */
    public function legend($legend)
    {
        $this->legend = $legend;

        return $this;
    }

    /**
     * @return string
     */
    public function getLegend()
    {
        return $this->legend;
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function render()
    {
        return view('form-builder::fieldset', [
            'legend' => $this->getLegend(),
            'slot' => new HtmlString($this->renderChildComponents()),
        ])->render();
    }
}
