<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\List;

use Newageerp\SfControlpanel\Console\EntitiesUtilsV3;
use Newageerp\SfReactTemplates\CoreTemplates\MainToolbar\MainToolbarTitle;
use Newageerp\SfReactTemplates\CoreTemplates\Popup\PopupWindow;
use Newageerp\SfReactTemplates\Event\LoadTemplateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ListContentListener implements EventSubscriberInterface
{
    protected EntitiesUtilsV3 $entitiesUtilsV3;

    protected TableHeaderService $tableHeaderService;

    protected TableRowService $tableRowService;

    public function __construct(
        EntitiesUtilsV3 $entitiesUtilsV3,
        TableHeaderService $tableHeaderService,
        TableRowService $tableRowService,
    ) {
        $this->entitiesUtilsV3 = $entitiesUtilsV3;
        $this->tableHeaderService = $tableHeaderService;
        $this->tableRowService = $tableRowService;
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
}
