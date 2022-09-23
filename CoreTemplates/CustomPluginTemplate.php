<?php

namespace Newageerp\SfReactTemplates\CoreTemplates;

use Newageerp\SfReactTemplates\Template\Template;

class CustomPluginTemplate extends Template
{
    protected string $templateName = '';
    protected array $props = [];

    public function __construct(string $templateName, array $props)
    {
        $this->templateName = $templateName;
        $this->props = $props;
    }

    /**
     * Get the value of templateName
     *
     * @return string
     */
    public function getTemplateName(): string
    {
        return $this->templateName;
    }

    /**
     * Set the value of templateName
     *
     * @param string $templateName
     *
     * @return self
     */
    public function setTemplateName(string $templateName): self
    {
        $this->templateName = $templateName;

        return $this;
    }

    /**
     * Get the value of props
     *
     * @return array
     */
    public function getProps(): array
    {
        return $this->props;
    }

    /**
     * Set the value of props
     *
     * @param array $props
     *
     * @return self
     */
    public function setProps(array $props): self
    {
        $this->props = $props;

        return $this;
    }
}
