<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\List\Columns;

use Newageerp\SfReactTemplates\CoreTemplates\Form\ListBaseColumn;

class DateTimeColumn extends ListBaseColumn {
    public function getTemplateName(): string
    {
        return 'list.ro.datetimecolumn';
    }
}