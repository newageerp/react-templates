<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\List\Columns;

use Newageerp\SfReactTemplates\CoreTemplates\Form\ListBaseColumn;

class EnumTextColumn extends ListBaseColumn {
    public function getTemplateName(): string
    {
        return 'list.ro.enumtextcolumn';
    }
}