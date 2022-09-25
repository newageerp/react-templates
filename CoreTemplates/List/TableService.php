<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\List;

use Newageerp\SfControlpanel\Console\TabsUtilsV3;
use Newageerp\SfReactTemplates\Template\Placeholder;

class TableService
{
    protected TableHeaderService $tableHeaderService;

    protected TableRowService $tableRowService;

    protected TabsUtilsV3 $tabsUtilsV3;

    public function __construct(
        TableHeaderService $tableHeaderService,
        TableRowService $tableRowService,
        TabsUtilsV3 $tabsUtilsV3,
    ) {
        $this->tableHeaderService = $tableHeaderService;
        $this->tableRowService = $tableRowService;
        $this->tabsUtilsV3 = $tabsUtilsV3;
    }

    public function buildListDataSourceForRel(
        string $schema,
        string $type,
        string $targetKey,
        int $elementId
    ): ListDataSource {
        $listDataSource = $this->buildListDataSource(
            $schema,
            $type,
        );
        $listDataSource->setExtraFilters(
            [
                [
                    'and' => [
                        ['i.' . $targetKey, '=', $elementId, true]

                    ]
                ]
            ]
        );
        $listTable = $this->buildTableData(
            $schema,
            $type,
        );
        $listDataSource->setSocketData([
            'id' => $targetKey . '.' . $schema . '.' . $type . '.rel',
            'data' => [
                $schema . '.' . $targetKey . '.id' => $elementId,
            ]
        ]);
        $listDataSource->getChildren()->addTemplate($listTable);

        return $listDataSource;
    }

    public function buildListDataSource(string $schema, string $type): ListDataSource
    {
        $tabQs = $this->tabsUtilsV3->getTabQsFields($schema, $type);
        $tabSort = $this->tabsUtilsV3->getTabSort($schema, $type);

        $listDataSource = new ListDataSource($schema, $type);
        $listDataSource->setQuickSearchFields($tabQs);
        $listDataSource->setSort($tabSort);

        $filters = [];
        if ($fs = $this->tabsUtilsV3->getTabFilter($schema, $type)) {
            $filters[] = $fs;
        }
        $listDataSource->setExtraFilters($filters);

        return $listDataSource;
    }

    public function buildTableData(string $schema, string $type): ListDataTable
    {

        $thead = $this->tableHeaderService->buildHeaderRow(
            $schema,
            $type,
        );
        $tbody = $this->tableRowService->buildDataRow(
            $schema,
            $type,
        );

        $tableData = new ListDataTable();
        $tableData->getHeader()->addTemplate($thead);
        $tableData->getRow()->addTemplate($tbody);

        return $tableData;
    }
}
