<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\List\Columns;

use Newageerp\SfReactTemplates\CoreTemplates\Form\ListBaseColumn;

class NumberColumn extends ListBaseColumn {
    public function getTemplateName(): string
    {
        return 'list.ro.numbercolumn';
    }
}