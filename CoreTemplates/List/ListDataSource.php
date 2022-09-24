<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\List;

use Newageerp\SfReactTemplates\Template\Placeholder;
use Newageerp\SfReactTemplates\Template\Template;

class ListDataSource extends Template
{
    protected Placeholder $children;
    protected bool $hidePaging = false;
    protected array $quickSearchFields = [];
    protected array $sort = [];

    protected string $schema = '';
    protected string $type = '';

    protected array $extraFilters = [];

    protected bool $scrollToHeaderOnLoad = true;
    protected bool $disableVerticalMargin = false;

    public function __construct(string $schema, string $type)
    {
        $this->schema = $schema;
        $this->type = $type;
        $this->children = new Placeholder();
    }

    public function getProps(): array
    {
        return [
            'schema' => $this->getSchema(),
            'type' => $this->getType(),

            'children' => $this->getChildren()->toArray(),
            'hidePaging' => $this->getHidePaging(),
            'quickSearchFields' => $this->getQuickSearchFields(),
            'sort' => $this->getSort(),
            'extraFilters' => $this->getExtraFilters(),
            'scrollToHeaderOnLoad' => $this->getScrollToHeaderOnLoad(),
            'disableVerticalMargin' => $this->getDisableVerticalMargin(),
        ];
    }

    public function getTemplateName(): string
    {
        return 'list.list-data-source';
    }

    /**
     * Get the value of children
     *
     * @return Placeholder
     */
    public function getChildren(): Placeholder
    {
        return $this->children;
    }

    /**
     * Set the value of children
     *
     * @param Placeholder $children
     *
     * @return self
     */
    public function setChildren(Placeholder $children): self
    {
        $this->children = $children;

        return $this;
    }

    /**
     * Get the value of hidePaging
     *
     * @return bool
     */
    public function getHidePaging(): bool
    {
        return $this->hidePaging;
    }

    /**
     * Set the value of hidePaging
     *
     * @param bool $hidePaging
     *
     * @return self
     */
    public function setHidePaging(bool $hidePaging): self
    {
        $this->hidePaging = $hidePaging;

        return $this;
    }

    /**
     * Get the value of quickSearchFields
     *
     * @return array
     */
    public function getQuickSearchFields(): array
    {
        return $this->quickSearchFields;
    }

    /**
     * Set the value of quickSearchFields
     *
     * @param array $quickSearchFields
     *
     * @return self
     */
    public function setQuickSearchFields(array $quickSearchFields): self
    {
        $this->quickSearchFields = $quickSearchFields;

        return $this;
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

    /**
     * Get the value of type
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @param string $type
     *
     * @return self
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of extraFilters
     *
     * @return array
     */
    public function getExtraFilters(): array
    {
        return $this->extraFilters;
    }

    /**
     * Set the value of extraFilters
     *
     * @param array $extraFilters
     *
     * @return self
     */
    public function setExtraFilters(array $extraFilters): self
    {
        $this->extraFilters = $extraFilters;

        return $this;
    }

    /**
     * Get the value of scrollToHeaderOnLoad
     *
     * @return bool
     */
    public function getScrollToHeaderOnLoad(): bool
    {
        return $this->scrollToHeaderOnLoad;
    }

    /**
     * Set the value of scrollToHeaderOnLoad
     *
     * @param bool $scrollToHeaderOnLoad
     *
     * @return self
     */
    public function setScrollToHeaderOnLoad(bool $scrollToHeaderOnLoad): self
    {
        $this->scrollToHeaderOnLoad = $scrollToHeaderOnLoad;

        return $this;
    }

    /**
     * Get the value of disableVerticalMargin
     *
     * @return bool
     */
    public function getDisableVerticalMargin(): bool
    {
        return $this->disableVerticalMargin;
    }

    /**
     * Set the value of disableVerticalMargin
     *
     * @param bool $disableVerticalMargin
     *
     * @return self
     */
    public function setDisableVerticalMargin(bool $disableVerticalMargin): self
    {
        $this->disableVerticalMargin = $disableVerticalMargin;

        return $this;
    }
}
