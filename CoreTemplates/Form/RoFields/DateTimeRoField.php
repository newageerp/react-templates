<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\RoFields;

use Newageerp\SfReactTemplates\Template\Placeholder;
use Newageerp\SfReactTemplates\Template\Template;

class DateTimeRoField extends Template
{
    public function getProps(): array
    {
        return [];
    }

    public function getTemplateName(): string
    {
        return 'form.ro.datetimefield';
    }
}
