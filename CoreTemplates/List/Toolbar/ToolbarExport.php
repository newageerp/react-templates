<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\List\Toolbar;

use Newageerp\SfReactTemplates\Template\Template;

class ToolbarExport extends Template
{
    protected array $exports = [];

    public function __construct(array $exports)
    {
        $this->exports = $exports;
    }

    public function getProps(): array
    {
        return [
            'exports' => $this->getExports(),
        ];
    }

    public function getTemplateName(): string
    {
        return 'list.toolbar.export';
    }


    /**
     * Get the value of exports
     *
     * @return array
     */
    public function getExports(): array
    {
        return $this->exports;
    }

    /**
     * Set the value of exports
     *
     * @param array $exports
     *
     * @return self
     */
    public function setExports(array $exports): self
    {
        $this->exports = $exports;

        return $this;
    }
}