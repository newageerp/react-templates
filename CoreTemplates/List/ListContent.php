<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\List;

use Newageerp\SfPermissions\Service\EntityPermissionService;
use Newageerp\SfReactTemplates\Template\Placeholder;
use Newageerp\SfReactTemplates\Template\Template;

class ListContent extends Template
{
    protected string $schema = '';

    protected string $type = '';

    protected Placeholder $tableHeader;

    protected Placeholder $tableRow;

    public function __construct(string $schema, string $type)
    {
        $this->schema = $schema;
        $this->type = $type;

        $this->tableHeader = new Placeholder();
        $this->tableRow = new Placeholder();
    }
    

    public function getTemplateData(): array
    {
        return [
            'creatable' => true, // TODO
            'tableHeader' => $this->tableHeader->toArray(),
            'tableRow' => $this->tableRow->toArray(),
        ];
    }

    public function getProps(): array
    {
        return [
            'schema' => $this->getSchema(),
            'type' => $this->getType(),
        ];
    }

    public function getTemplateName(): string
    {
        return 'list.content';
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
     * Get the value of tableHeader
     *
     * @return Placeholder
     */
    public function getTableHeader(): Placeholder
    {
        return $this->tableHeader;
    }

    /**
     * Set the value of tableHeader
     *
     * @param Placeholder $tableHeader
     *
     * @return self
     */
    public function setTableHeader(Placeholder $tableHeader): self
    {
        $this->tableHeader = $tableHeader;

        return $this;
    }

    /**
     * Get the value of tableRow
     *
     * @return Placeholder
     */
    public function getTableRow(): Placeholder
    {
        return $this->tableRow;
    }

    /**
     * Set the value of tableRow
     *
     * @param Placeholder $tableRow
     *
     * @return self
     */
    public function setTableRow(Placeholder $tableRow): self
    {
        $this->tableRow = $tableRow;

        return $this;
    }
}
