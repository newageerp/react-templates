<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\View;

use Newageerp\SfPermissions\Service\EntityPermissionService;
use Newageerp\SfReactTemplates\Template\Placeholder;
use Newageerp\SfReactTemplates\Template\Template;

class ViewContent extends Template
{
    protected string $schema = '';

    protected string $type = '';

    protected string $id = '';

    protected ?object $entity = null;

    protected ?int $defaultViewIndex = null;

    protected Placeholder $rightContent;
    protected Placeholder $afterTitleBlockContent;

    public function __construct(string $schema, string $type, string $id, ?object $entity)
    {
        $this->schema = $schema;
        $this->type = $type;
        $this->id = $id;
        $this->entity = $entity;

        $this->rightContent = new Placeholder();
        $this->afterTitleBlockContent = new Placeholder();
    }

    public function getTemplateData(): array
    {
        return [
            'editable' => EntityPermissionService::checkIsEditable($this->entity),
            'removable' => EntityPermissionService::checkIsRemovable($this->entity),
            'rightContent' => $this->getRightContent()->toArray(),
            'afterTitleBlockContent' => $this->getAfterTitleBlockContent()->toArray(),
        ];
    }

    public function getProps(): array
    {
        return [
            'schema' => $this->getSchema(),
            'type' => $this->getType(),
            'id' => $this->getId(),
            'defaultViewIndex' => $this->getDefaultViewIndex(),
        ];
    }

    public function getTemplateName(): string
    {
        return 'view.content';
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
     * Get the value of id
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param string $id
     *
     * @return self
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of defaultViewIndex
     *
     * @return ?int
     */
    public function getDefaultViewIndex(): ?int
    {
        return $this->defaultViewIndex;
    }

    /**
     * Set the value of defaultViewIndex
     *
     * @param ?int $defaultViewIndex
     *
     * @return self
     */
    public function setDefaultViewIndex(?int $defaultViewIndex): self
    {
        $this->defaultViewIndex = $defaultViewIndex;

        return $this;
    }

    /**
     * Get the value of rightContent
     *
     * @return Placeholder
     */
    public function getRightContent(): Placeholder
    {
        return $this->rightContent;
    }

    /**
     * Set the value of rightContent
     *
     * @param Placeholder $rightContent
     *
     * @return self
     */
    public function setRightContent(Placeholder $rightContent): self
    {
        $this->rightContent = $rightContent;

        return $this;
    }

    /**
     * Get the value of afterTitleBlockContent
     *
     * @return Placeholder
     */
    public function getAfterTitleBlockContent(): Placeholder
    {
        return $this->afterTitleBlockContent;
    }

    /**
     * Set the value of afterTitleBlockContent
     *
     * @param Placeholder $afterTitleBlockContent
     *
     * @return self
     */
    public function setAfterTitleBlockContent(Placeholder $afterTitleBlockContent): self
    {
        $this->afterTitleBlockContent = $afterTitleBlockContent;

        return $this;
    }
}
