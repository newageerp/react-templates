<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\Modal;

use Newageerp\SfReactTemplates\Template\Template;

class MenuItemWithCreate extends MenuItem
{
    protected int $elementId = 0;
    protected string $targetSchema = '';
    protected string $sourceSchema = '';
    protected ?bool $forcePopup = null;

    public function __construct(
        string $children,
        int $elementId,
        string $sourceSchema,
        string $targetSchema,
        ?bool $forcePopup = null
    ) {
        parent::__construct($children, null);

        $this->elementId = $elementId;
        $this->targetSchema = $targetSchema;
        $this->sourceSchema = $sourceSchema;
        $this->forcePopup = $forcePopup;
    }

    public function getProps(): array
    {
        $props = parent::getProps();

        $props['elementId'] = $this->getElementId();
        $props['targetSchema'] = $this->getTargetSchema();
        $props['sourceSchema'] = $this->getSourceSchema();
        $props['forcePopup'] = $this->getForcePopup();

        return $props;
    }

    public function getTemplateName(): string
    {
        return 'modal.menu-item-with-create';
    }

    /**
     * Get the value of elementId
     *
     * @return int
     */
    public function getElementId(): int
    {
        return $this->elementId;
    }

    /**
     * Set the value of elementId
     *
     * @param int $elementId
     *
     * @return self
     */
    public function setElementId(int $elementId): self
    {
        $this->elementId = $elementId;

        return $this;
    }

    /**
     * Get the value of targetSchema
     *
     * @return string
     */
    public function getTargetSchema(): string
    {
        return $this->targetSchema;
    }

    /**
     * Set the value of targetSchema
     *
     * @param string $targetSchema
     *
     * @return self
     */
    public function setTargetSchema(string $targetSchema): self
    {
        $this->targetSchema = $targetSchema;

        return $this;
    }

    /**
     * Get the value of sourceSchema
     *
     * @return string
     */
    public function getSourceSchema(): string
    {
        return $this->sourceSchema;
    }

    /**
     * Set the value of sourceSchema
     *
     * @param string $sourceSchema
     *
     * @return self
     */
    public function setSourceSchema(string $sourceSchema): self
    {
        $this->sourceSchema = $sourceSchema;

        return $this;
    }

    /**
     * Get the value of forcePopup
     *
     * @return ?bool
     */
    public function getForcePopup(): ?bool
    {
        return $this->forcePopup;
    }

    /**
     * Set the value of forcePopup
     *
     * @param ?bool $forcePopup
     *
     * @return self
     */
    public function setForcePopup(?bool $forcePopup): self
    {
        $this->forcePopup = $forcePopup;

        return $this;
    }
}
