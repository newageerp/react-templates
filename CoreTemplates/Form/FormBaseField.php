<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\Form;

use Newageerp\SfReactTemplates\Template\Placeholder;
use Newageerp\SfReactTemplates\Template\Template;

abstract class FormBaseField extends Template
{
    protected string $key = '';

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function getProps(): array
    {
        return [
            'key' => $this->getKey()
        ];
    }


    /**
     * Get the value of key
     *
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Set the value of key
     *
     * @param string $key
     *
     * @return self
     */
    public function setKey(string $key): self
    {
        $this->key = $key;

        return $this;
    }
}
