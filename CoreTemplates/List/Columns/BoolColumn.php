<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\List\Columns;

use Newageerp\SfReactTemplates\CoreTemplates\Form\ListBaseColumn;

class BoolColumn extends ListBaseColumn {
    public function getTemplateName(): string
    {
        return 'list.ro.boolcolumn';
    }
}