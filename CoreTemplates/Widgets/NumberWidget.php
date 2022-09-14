<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\Widgets;

use Newageerp\SfReactTemplates\Template\Template;

class NumberWidget extends Template
{
    protected ?string $title = null;

    protected ?string $description = null;

    protected ?float $floatNumber = null;

    protected ?float $floatInt = null;

    public function __construct()
    {
    }

    public function getProps(): array
    {
        return [
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'number' => $this->getFloatNumber() ? $this->getFloatNumber() : $this->getFloatInt(),
            'asFloat' => !!$this->getFloatNumber()
        ];
    }

    public function getTemplateName(): string
    {
        return 'widgets.numberwidget';
    }

    /**
     * Get the value of title
     *
     * @return ?string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @param ?string $title
     *
     * @return self
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of description
     *
     * @return ?string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @param ?string $description
     *
     * @return self
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of floatNumber
     *
     * @return ?float
     */
    public function getFloatNumber(): ?float
    {
        return $this->floatNumber;
    }

    /**
     * Set the value of floatNumber
     *
     * @param ?float $floatNumber
     *
     * @return self
     */
    public function setFloatNumber(?float $floatNumber): self
    {
        $this->floatNumber = $floatNumber;

        return $this;
    }

    /**
     * Get the value of floatInt
     *
     * @return ?float
     */
    public function getFloatInt(): ?float
    {
        return $this->floatInt;
    }

    /**
     * Set the value of floatInt
     *
     * @param ?float $floatInt
     *
     * @return self
     */
    public function setFloatInt(?float $floatInt): self
    {
        $this->floatInt = $floatInt;

        return $this;
    }
}
