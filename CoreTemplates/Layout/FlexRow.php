<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\Layout;

use Newageerp\SfReactTemplates\Template\Placeholder;
use Newageerp\SfReactTemplates\Template\Template;

class FlexRow extends Template
{
    protected Placeholder $children;

    public function __construct(?Placeholder $children = null)
    {
        $this->children = $children ? $children : new Placeholder();
    }

    public function getTemplateName(): string
    {
        return 'layout.flexrow';
    }

    public function getProps(): array
    {
        return [
            'children' => $this->children->toArray(),
        ];
    }
}
