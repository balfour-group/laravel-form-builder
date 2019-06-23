<?php

namespace Balfour\LaravelFormBuilder\Components;

class FileInput extends TextInput
{
    /**
     * @var string
     */
    protected $name = 'file';

    /**
     * @var string
     */
    protected $type = 'file';

    /**
     * @var array
     */
    protected $mimes = [];

    /**
     * @var int|null
     */
    protected $maxSize = null;

    /**
     * @param string|array $mimes
     * @return $this
     */
    public function mimes($mimes)
    {
        if (!is_array($mimes)) {
            $mimes = (array) $mimes;
        }

        $this->mimes = $mimes;

        return $this;
    }

    /**
     * @return array
     */
    public function getMimes()
    {
        return $this->mimes;
    }

    /**
     * @param int $size
     * @return $this
     */
    public function maxSize($size)
    {
        $this->maxSize = $size;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMaxSize()
    {
        return $this->maxSize;
    }

    /**
     * @return array
     */
    public function getAutoValidationRules()
    {
        $rules = [
            'file',
        ];

        if (count($this->mimes) > 0) {
            $rules[] = sprintf('mimetypes:%s', implode(',', $this->mimes));
        }

        if ($this->maxSize) {
            $rules[] = sprintf('max:%d', $this->maxSize);
        }

        return $rules;
    }
}
