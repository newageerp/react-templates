<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\Form\EditableFields;

use Newageerp\SfReactTemplates\Template\Placeholder;
use Newageerp\SfReactTemplates\Template\Template;

class EnumTextEditableField extends Template
{
    public function getProps(): array
    {
        return [];
    }

    public function getTemplateName(): string
    {
        return 'form.editable.enumtextfield';
    }
}
