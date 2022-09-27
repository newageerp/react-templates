<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\List\Toolbar;

use Newageerp\SfReactTemplates\Template\Template;

class ToolbarTabSwitch extends Template
{
    protected string $schema;

    protected array $tabs = [];

    public function __construct(string $schema, array $tabs)
    {
        $this->schema = $schema;
        $this->tabs = $tabs;
    }

    public function getProps(): array
    {
        return [
            'schema' => $this->getSchema(),
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

    /**
     * Get the value of schema
     *
     * @return string
     */
    public function getSchema(): string
    {
        return $this->schema;
    }

    /**
     * Set the value of schema
     *
     * @param string $schema
     *
     * @return self
     */
    public function setSchema(string $schema): self
    {
        $this->schema = $schema;

        return $this;
    }
}