<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\List\Columns;

use Newageerp\SfReactTemplates\CoreTemplates\Form\ListBaseColumn;

class ArrayColumn extends ListBaseColumn {
    public function getTemplateName(): string
    {
        return 'list.ro.arraycolumn';
    }
}