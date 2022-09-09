<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\View;

use Newageerp\SfPermissions\Service\EntityPermissionService;
use Newageerp\SfReactTemplates\Template\Template;

class ViewContent extends Template
{
    protected string $schema = '';

    protected string $type = '';

    protected string $id = '';

    protected bool $isPopup = false;

    protected ?object $entity = null;

    public function __construct(string $schema, string $type, string $id, ?object $entity)
    {
        $this->schema = $schema;
        $this->type = $type;
        $this->id = $id;
        $this->entity = $entity;
    }

    public function getTemplateData(): array
    {
        return [
            'editable' => EntityPermissionService::checkIsEditable($this->entity),
            'removable' => EntityPermissionService::checkIsRemovable($this->entity),
        ];
    }

    public function getProps(): array
    {
        return [
            'schema' => $this->getSchema(),
            'type' => $this->getType(),
            'id' => $this->getId(),
        ];
    }

    public function getAction(): ?string
    {
        return null;
    }

    public function getTemplateName(): string
    {
        if ($this->getIsPopup()) {
            return 'view.popupcontent';
        }
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
     * Get the value of isPopup
     *
     * @return bool
     */
    public function getIsPopup(): bool
    {
        return $this->isPopup;
    }

    /**
     * Set the value of isPopup
     *
     * @param bool $isPopup
     *
     * @return self
     */
    public function setIsPopup(bool $isPopup): self
    {
        $this->isPopup = $isPopup;

        return $this;
    }
}
