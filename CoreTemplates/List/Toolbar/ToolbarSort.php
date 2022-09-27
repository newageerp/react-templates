<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\List\Toolbar;

use Newageerp\SfReactTemplates\Template\Template;

class ToolbarSort extends Template
{
    protected array $sort;
    
    public function __construct(array $sort)
    {
        $this->sort = $sort;
    }

    public function getTemplateName(): string
    {
        return 'list.toolbar.sort';
    }

    public function getProps(): array
    {
        return [
            'sort' => $this->getSort(),
        ];
    }

    /**
     * Get the value of sort
     *
     * @return array
     */
    public function getSort(): array
    {
        return $this->sort;
    }

    /**
     * Set the value of sort
     *
     * @param array $sort
     *
     * @return self
     */
    public function setSort(array $sort): self
    {
        $this->sort = $sort;

        return $this;
    }
}
