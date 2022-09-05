<?php

namespace Newageerp\SfReactTemplates\Template;

abstract class Template
{
    abstract public function getTemplateName(): string;

    abstract public function getProps(): array;

    abstract public function getAction(): string;

    public function toArray(): array
    {
        return [
            'comp' => $this->getTemplateName(),
            'props' => $this->getProps(),
            'action' => $this->getAction(),
        ];
    }
}
