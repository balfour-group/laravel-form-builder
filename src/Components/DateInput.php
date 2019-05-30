<?php

namespace Balfour\LaravelFormBuilder\Components;

use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;

class DateInput extends TextInput
{
    /**
     * @var string
     */
    protected $name = 'date';

    /**
     * @var string
     */
    protected $type = 'date';

    /**
     * @param mixed $default
     * @return $this
     */
    public function defaults($default)
    {
        if (!is_callable($default)) {
            if ($default instanceof CarbonInterface) {
                $default = $default->toDateString();
            } else {
                // laravel casts 'date' attributes to date time in the format "YYYY-MM-DD H:i:s"
                // the date input expects "YYYY-MM-DD", so we re-format here
                $date = Carbon::parse($default);
                $default = $date->toDateString();
            }
        }

        $this->default = $default;

        return $this;
    }

    /**
     * @return array
     */
    public function getAutoValidationRules()
    {
        return [
            'date',
        ];
    }
}
