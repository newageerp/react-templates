<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\Table;

use Newageerp\SfReactTemplates\Template\Placeholder;
use Newageerp\SfReactTemplates\Template\Template;

class TableTd extends Template
{
    protected Placeholder $contents;

    protected ?string $textAlignment = null;


    public function __construct(?Placeholder $contents = null)
    {
        $this->contents = $contents ? $contents : new Placeholder();
    }

    public function getTemplateName(): string
    {
        return 'table.td';
    }

    public function getProps(): array
    {
        return [
            'contents' => $this->getContents()->toArray(),
            'textAlignment' => $this->getTextAlignment(),
        ];
    }


    /**
     * Get the value of textAlignment
     *
     * @return ?string
     */
    public function getTextAlignment(): ?string
    {
        return $this->textAlignment;
    }

    /**
     * Set the value of textAlignment
     *
     * @param ?string $textAlignment
     *
     * @return self
     */
    public function setTextAlignment(?string $textAlignment): self
    {
        $this->textAlignment = $textAlignment;

        return $this;
    }

    /**
     * Get the value of contents
     *
     * @return Placeholder
     */
    public function getContents(): Placeholder
    {
        return $this->contents;
    }

    /**
     * Set the value of contents
     *
     * @param Placeholder $contents
     *
     * @return self
     */
    public function setContents(Placeholder $contents): self
    {
        $this->contents = $contents;

        return $this;
    }
}