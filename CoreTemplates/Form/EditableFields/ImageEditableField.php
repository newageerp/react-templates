<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\EditableFields;

use Newageerp\SfReactTemplates\Template\Placeholder;
use Newageerp\SfReactTemplates\Template\Template;

class ImageEditableField extends Template
{
    public function getProps(): array
    {
        return [];
    }

    public function getTemplateName(): string
    {
        return 'form.editable.imagefield';
    }
}
