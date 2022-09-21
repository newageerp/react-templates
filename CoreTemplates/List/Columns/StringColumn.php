<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\List\Columns;

use Newageerp\SfReactTemplates\CoreTemplates\Form\ListBaseColumn;

class StringColumn extends ListBaseColumn {
    public function getTemplateName(): string
    {
        return 'list.ro.stringcolumn';
    }
}