<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\List\Columns;

use Newageerp\SfReactTemplates\CoreTemplates\Form\ListBaseColumn;

class ObjectColumn extends ListBaseColumn {
    public function getTemplateName(): string
    {
        return 'list.ro.objectcolumn';
    }
}