<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\List;

use Newageerp\SfControlpanel\Console\EntitiesUtilsV3;
use Newageerp\SfControlpanel\Console\TabsUtilsV3;
use Newageerp\SfReactTemplates\CoreTemplates\Cards\WhiteCard;
use Newageerp\SfReactTemplates\Template\Placeholder;
use Newageerp\SfReactTemplates\Template\Template;

class TableService
{
    public const NOWRAP = 0;
    public const WRAPWITHCARD = 10;
    public const WRAPWITHCARDANDTITLE = 20;

    protected TableHeaderService $tableHeaderService;

    protected TableRowService $tableRowService;

    protected TabsUtilsV3 $tabsUtilsV3;

    protected EntitiesUtilsV3 $entitiesUtilsV3;

    public function __construct(
        TableHeaderService $tableHeaderService,
        TableRowService $tableRowService,
        TabsUtilsV3 $tabsUtilsV3,
        EntitiesUtilsV3 $entitiesUtilsV3,
    ) {
        $this->tableHeaderService = $tableHeaderService;
        $this->tableRowService = $tableRowService;
        $this->tabsUtilsV3 = $tabsUtilsV3;
        $this->entitiesUtilsV3 = $entitiesUtilsV3;
    }

    public function buildListDataSourceForRel(
        string $schema,
        string $type,
        string $targetKey,
        int $elementId,
        ?int $wrapWithCard = self::NOWRAP,
    ): Template {
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

        if ($wrapWithCard >= self::WRAPWITHCARD) {
            $whiteCard = new WhiteCard();
            if ($wrapWithCard === self::WRAPWITHCARDANDTITLE) {
                $whiteCard->setTitle($this->getEntitiesUtilsV3()->getTitlePluralBySlug('contact'));
            }
            $whiteCard->getChildren()->addTemplate($listDataSource);
            return $whiteCard;
        }

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

    /**
     * Get the value of entitiesUtilsV3
     *
     * @return EntitiesUtilsV3
     */
    public function getEntitiesUtilsV3(): EntitiesUtilsV3
    {
        return $this->entitiesUtilsV3;
    }

    /**
     * Set the value of entitiesUtilsV3
     *
     * @param EntitiesUtilsV3 $entitiesUtilsV3
     *
     * @return self
     */
    public function setEntitiesUtilsV3(EntitiesUtilsV3 $entitiesUtilsV3): self
    {
        $this->entitiesUtilsV3 = $entitiesUtilsV3;

        return $this;
    }
}
