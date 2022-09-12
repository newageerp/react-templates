<?php

namespace Newageerp\SfReactTemplates\Template;

class Placeholder
{
    /**
     * @var Template[] $templates
     */
    protected array $templates = [];

    public function addTemplate(Template $template)
    {
        $this->templates[] = $template;
    }

    /**
     * Get the value of templates
     *
     * @return array
     */
    public function getTemplates(): array
    {
        return $this->templates;
    }

    /**
     * Set the value of templates
     *
     * @param array $templates
     *
     * @return self
     */
    public function setTemplates(array $templates): self
    {
        $this->templates = $templates;

        return $this;
    }

    public function toArray(): array
    {
        $data = array_map(
            function (Template $t) {
                return $t->toArray();
            },
            $this->templates
        );
        return $data;
    }

    public function getTemplatesData(): array
    {
        /**
         * @var array $data
         */
        $data = array_map(
            function (Template $t) {
                return $t->getTemplateData();
            },
            $this->templates
        );
        return array_merge(...$data);
    }
}
