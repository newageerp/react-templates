<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\List\Columns;

use Newageerp\SfReactTemplates\CoreTemplates\Form\ListBaseColumn;

class DateColumn extends ListBaseColumn {
    public function getTemplateName(): string
    {
        return 'list.ro.datecolumn';
    }
}