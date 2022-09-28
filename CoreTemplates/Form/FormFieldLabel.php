<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\Form;

use Newageerp\SfReactTemplates\Template\Placeholder;
use Newageerp\SfReactTemplates\Template\Template;

class FormFieldLabel extends Template
{
    protected string $title = '';

    protected ?string $className = null;

    protected ?string $width = null;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function getProps(): array
    {
        return [
            'title' => $this->getTitle(),
            'className' => $this->getClassName(),
            'width' => $this->getWidth(),
        ];
    }

    public function getTemplateName(): string
    {
        return 'form.fieldlabel';
    }

    /**
     * Get the value of title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @param string $title
     *
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of className
     *
     * @return ?string
     */
    public function getClassName(): ?string
    {
        return $this->className;
    }

    /**
     * Set the value of className
     *
     * @param ?string $className
     *
     * @return self
     */
    public function setClassName(?string $className): self
    {
        $this->className = $className;

        return $this;
    }

    /**
     * Get the value of width
     *
     * @return ?string
     */
    public function getWidth(): ?string
    {
        return $this->width;
    }

    /**
     * Set the value of width
     *
     * @param ?string $width
     *
     * @return self
     */
    public function setWidth(?string $width): self
    {
        $this->width = $width;

        return $this;
    }
}
