<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\Form\RoFields;

use Newageerp\SfReactTemplates\Template\Placeholder;
use Newageerp\SfReactTemplates\Template\Template;

class ImageRoField extends Template
{
    public function getProps(): array
    {
        return [];
    }

    public function getTemplateName(): string
    {
        return 'form.ro.imagefield';
    }
}