<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\List\Toolbar;

use Newageerp\SfReactTemplates\Template\Template;

class ToolbarTabSwitch extends Template
{
    protected array $tabs = [];

    public function __construct(array $tabs)
    {
        $this->tabs = $tabs;
    }

    public function getProps(): array
    {
        return [
            'tabs' => $this->getTabs(),
        ];
    }

    public function getTemplateName(): string
    {
        return 'list.toolbar.tabs-switch';
    }

    /**
     * Get the value of tabs
     *
     * @return array
     */
    public function getTabs(): array
    {
        return $this->tabs;
    }

    /**
     * Set the value of tabs
     *
     * @param array $tabs
     *
     * @return self
     */
    public function setTabs(array $tabs): self
    {
        $this->tabs = $tabs;

        return $this;
    }
}