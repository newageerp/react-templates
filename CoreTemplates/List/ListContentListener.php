<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\List;

use Newageerp\SfAuth\Service\AuthService;
use Newageerp\SfControlpanel\Console\EntitiesUtilsV3;
use Newageerp\SfControlpanel\Console\TabsUtilsV3;
use Newageerp\SfReactTemplates\CoreTemplates\List\Toolbar\ToolbarDetailedSearch;
use Newageerp\SfReactTemplates\CoreTemplates\List\Toolbar\ToolbarExport;
use Newageerp\SfReactTemplates\CoreTemplates\List\Toolbar\ToolbarNewButton;
use Newageerp\SfReactTemplates\CoreTemplates\List\Toolbar\ToolbarQs;
use Newageerp\SfReactTemplates\CoreTemplates\List\Toolbar\ToolbarSort;
use Newageerp\SfReactTemplates\CoreTemplates\List\Toolbar\ToolbarTabSwitch;
use Newageerp\SfReactTemplates\CoreTemplates\MainToolbar\MainToolbarTitle;
use Newageerp\SfReactTemplates\CoreTemplates\Popup\PopupWindow;
use Newageerp\SfReactTemplates\Event\LoadTemplateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ListContentListener implements EventSubscriberInterface
{
    protected EntitiesUtilsV3 $entitiesUtilsV3;

    protected TableHeaderService $tableHeaderService;

    protected TableRowService $tableRowService;

    protected TabsUtilsV3 $tabsUtilsV3;

    public function __construct(
        EntitiesUtilsV3 $entitiesUtilsV3,
        TableHeaderService $tableHeaderService,
        TableRowService $tableRowService,
        TabsUtilsV3 $tabsUtilsV3,
    ) {
        $this->entitiesUtilsV3 = $entitiesUtilsV3;
        $this->tableHeaderService = $tableHeaderService;
        $this->tableRowService = $tableRowService;
        $this->tabsUtilsV3 = $tabsUtilsV3;
    }

    public function onTemplate(LoadTemplateEvent $event)
    {
        if ($event->isTemplateForAnyEntity('PageMainList')) {
            $listContent = new ListContent(
                $event->getData()['schema'],
                $event->getData()['type'],
            );
            $isPopup = isset($event->getData()['isPopup']) && $event->getData()['isPopup'];

            $tr = $this->tableHeaderService->buildHeaderRow(
                $event->getData()['schema'],
                $event->getData()['type'],
            );
            $listContent->getTableHeader()->addTemplate($tr);

            $tr = $this->tableRowService->buildDataRow(
                $event->getData()['schema'],
                $event->getData()['type'],
            );
            $listContent->getTableRow()->addTemplate($tr);

            // toolbar
            $tab = $this->getTabsUtilsV3()->getTabBySchemaAndType(
                $event->getData()['schema'],
                $event->getData()['type'],
            );
            if ($tab) {
                // CREATE BUTTON
                $disableCreate = isset($tab['disableCreate']) && $tab['disableCreate'];
                if (
                    !$disableCreate &&
                    $this->getEntitiesUtilsV3()->checkIsCreatable(
                        $event->getData()['schema'],
                        AuthService::getInstance()->getUser()->getPermissionGroup(),
                    )
                ) {
                    $listContent->getToolbar()->getToolbarLeft()->addTemplate(
                        new ToolbarNewButton($event->getData()['schema'])
                    );
                }

                // QS
                $qsFields = $this->getTabsUtilsV3()->getTabQsFields(
                    $event->getData()['schema'],
                    $event->getData()['type'],
                );
                if (count($qsFields) > 0) {
                    $listContent->getToolbar()->getToolbarLeft()->addTemplate(
                        new ToolbarQs($qsFields)
                    );
                }

                // TABS SWITCH
                $tabsSwitch = $this->getTabsUtilsV3()->getTabsSwitchOptions(
                    $event->getData()['schema'],
                    $event->getData()['type'],
                );
                if (count($tabsSwitch) > 0) {
                    $listContent->getToolbar()->getToolbarLeft()->addTemplate(
                        new ToolbarTabSwitch(
                            $event->getData()['schema'],
                            $event->getData()['type'],
                            $tabsSwitch
                        )
                    );
                }

                // TABS EXPORT
                if (isset($tab['exports']) && $tab['exports']) {
                    $listContent->getToolbar()->getToolbarRight()->addTemplate(
                        new ToolbarExport($event->getData()['schema'], $tab['exports'])
                    );
                }

                // SORT
                $sort = $this->getTabsUtilsV3()->getTabSort(
                    $event->getData()['schema'],
                    $event->getData()['type'],
                );
                if (count($sort) > 0) {
                    $listContent->getToolbar()->getToolbarRight()->addTemplate(
                        new ToolbarSort($event->getData()['schema'], $sort)
                    );
                }

                // DETAILED SEARCH
                $listContent->getToolbar()->getToolbarRight()->addTemplate(
                    new ToolbarDetailedSearch($event->getData()['schema'])
                );
            }

            if ($isPopup) {
                $popupWindow = new PopupWindow();
                $popupWindow->getChildren()->addTemplate($listContent);
                $event->getPlaceholder()->addTemplate($popupWindow);
            } else {
                $event->getPlaceholder()->addTemplate($listContent);

                $toolbarTitle = new MainToolbarTitle($this->entitiesUtilsV3->getTitlePluralBySlug($event->getData()['schema']));
                $event->getPlaceholder()->addTemplate($toolbarTitle);
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            LoadTemplateEvent::NAME => 'onTemplate'
        ];
    }

    /**
     * Get the value of tabsUtilsV3
     *
     * @return TabsUtilsV3
     */
    public function getTabsUtilsV3(): TabsUtilsV3
    {
        return $this->tabsUtilsV3;
    }

    /**
     * Set the value of tabsUtilsV3
     *
     * @param TabsUtilsV3 $tabsUtilsV3
     *
     * @return self
     */
    public function setTabsUtilsV3(TabsUtilsV3 $tabsUtilsV3): self
    {
        $this->tabsUtilsV3 = $tabsUtilsV3;

        return $this;
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
