<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\Form\EditableFields;

use Newageerp\SfReactTemplates\CoreTemplates\Form\FormBaseField;
use Newageerp\SfReactTemplates\Template\Placeholder;
use Newageerp\SfReactTemplates\Template\Template;

class ArrayEditableField extends FormBaseField
{
    public function getProps(): array
    {
        return [];
    }

    public function getTemplateName(): string
    {
        return 'form.editable.arrayfield';
    }
}
